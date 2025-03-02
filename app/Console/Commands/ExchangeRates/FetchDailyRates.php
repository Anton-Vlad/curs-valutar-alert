<?php

namespace App\Console\Commands\ExchangeRates;

use App\Models\ExchangeRate;
use App\Models\LatestCurrencyRate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;
use SimpleXMLElement;

class FetchDailyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange-rates:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch RON exchange rates for the current day.';

    /**
     * Execute the console command.
     * @throws Throwable
     */
    public function handle(): void
    {
        $url = "https://www.bnr.ro/nbrfxrates.xml";

        // Fetch exchange rate from BNR API
        $response = Http::get($url);

        if ($response->failed()) {
            $this->error('Failed to fetch exchange rates from BNR.');
            logger()->error($response->json());
            return;
        }

        // Parse XML response
        $xml = new SimpleXMLElement($response->body());
        $publishDate = (string)$xml->Header->PublishingDate;

        $this->info('Exchange rates from ' . $publishDate);

        try {
            foreach ($xml->Body->Cube as $day) {
                $date = (string)$day['date'];
                $dayRates = [];

                foreach ($day->Rate as $rate) {
                    $currency = (string)$rate['currency'];
                    $rateValue = (float)$rate;

                    $dayRates[$currency] = $rateValue;
                    $this->updateLatestRates($date, $currency, $rateValue);
                }

                $this->storeDayHistory($date, $dayRates);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage());
        }
    }

    private function storeDayHistory($date, $rates): void
    {
        ExchangeRate::updateOrCreate([
            'date' => $date,
        ], [
            'rates' => $rates,
        ]);
    }

    private function updateLatestRates($date, $currency, $rate): void
    {
        LatestCurrencyRate::updateOrCreate([
            'currency' => $currency,
        ], [
            'date' => $date,
            'rate' => $rate,
        ]);
    }
}
