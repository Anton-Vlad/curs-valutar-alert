<?php

namespace App\Console\Commands\ExchangeRates;

use App\Models\ExchangeRate;
use App\Models\LatestCurrencyRate;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;
use SimpleXMLElement;
use function Laravel\Prompts\progress;

class SeedExchangeRates extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange-rates:seed {year}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch RON exchange rates for an entire year from BNR API';

    /**
     * Execute the console command.
     * @throws Throwable
     */
    public function handle(): void
    {
        $year = $this->argument('year'); // Expected format: YYYY

        if (!preg_match('/^\d{4}$/', $year)) {
            $this->fail('Invalid year format. Use YYYY.');
        }

        if ($year < 2020 || $year > Carbon::now()->year) {
            $this->fail('Invalid year requested.');
        }

        $url = "https://www.bnr.ro/files/xml/years/nbrfxrates{$year}.xml";

        // Fetch exchange rate from BNR API
        $response = Http::get($url);

        if ($response->failed()) {
            $htmlContent = $response->body();
            $dom = new \DOMDocument();
            @$dom->loadHTML($htmlContent);
            $titleTag = $dom->getElementsByTagName('title')->item(0);
            $errorMessage = $titleTag ? $titleTag->textContent : 'Unknown error';

            logger()->error($htmlContent);
            $this->fail($errorMessage);
        }

        $xml = new SimpleXMLElement($response->body());

        DB::beginTransaction();

        try {
            progress(
                label: 'Storing Exchange Rates for year ' . $year,
                steps: $xml->Body->Cube,
                callback: function ($day) {
                    $date = (string)$day['date'];

                    $dayRates = [];
                    foreach ($day->Rate as $rate) {
                        $currency = (string)$rate['currency'];
                        $rateValue = (float)$rate;

                        $dayRates[$currency] = $rateValue;
                    }

//                    logger()->info("DAY: {$date}", $dayRates);

                    $this->storeRate($date, $dayRates);
                    $this->updateLatestRates($date, $dayRates);

                    return;
                }
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage());
        }
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'year' => 'Which year to import data for? (At most 2020)',
        ];
    }

    private function storeRate($date, $rates): void
    {
        ExchangeRate::create([
            'rates' => $rates,
            'date' => $date,
        ]);
    }

    private function updateLatestRates($date, $rates): void
    {
        foreach ($rates as $currency => $rate) {
            LatestCurrencyRate::updateOrCreate([
                'currency' => $currency,
            ], [
                'date' => $date,
                'rate' => $rate,
            ]);
        }
    }
}
