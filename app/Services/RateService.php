<?php
namespace App\Services;

use App\Models\ExchangeRate;
use App\Models\LatestCurrencyRate;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RateService
{
    /**
     * @return Collection
     * Get latest rates with optional filtering.
     */
    public function getLatestRates(array $filterSymbols = []): Collection
    {
        $latestRatesQuery = LatestCurrencyRate::orderBy('rate', 'desc');

        if (!empty($filterSymbols)) {
            $latestRatesQuery->whereIn('currency', $filterSymbols);
        }

        $latestRates = $latestRatesQuery->get();

        // Symbols table data
        $symbolRateDict = [];
        $output = [];
        foreach ($latestRates as $latestRate) {
            $symbolRateDict[$latestRate->currency] = ['current' => 0, 'past' => 0, 'variation' => 0];
            $symbolRateDict[$latestRate->currency]['current'] = floatval($latestRate->rate);
            $output[] = [
                'currency' => $latestRate->currency,
                'value' => floatval($latestRate->rate),
            ];
        }

        // Get previous day rates
        $prevRates = ExchangeRate::orderBy('date', 'desc')->limit(2)->get();
        if (count($prevRates) === 2) {
            $output = [];
            foreach ($prevRates[1]->rates as $currency => $rate) {
                if (empty($filterSymbols) || in_array($currency, $filterSymbols)) {
                    $symbolRateDict[$currency]['past'] = floatval($rate);
                    $symbolRateDict[$currency]['variation'] = number_format($symbolRateDict[$currency]['current'] - $symbolRateDict[$currency]['past'], 4);
                    $output[] = [
                        'currency' => $currency,
                        'value' => $symbolRateDict[$currency]['current'],
                        'variation' => $symbolRateDict[$currency]['variation'],
                    ];
                }
            }
        }
        usort($output, function ($a, $b) {
            return $a["value"] < $b["value"];
        });

        return collect($output);
    }

    /**
     * @return string
     *
     * Handle the display of latest date for rates
     */
    public function getLatestDate(): string
    {
        setlocale(LC_TIME, 'ro_RO'); // Set Romanian locale
        Carbon::setLocale('ro');

        $prevRates = ExchangeRate::orderBy('date', 'desc')->get();
        if ($prevRates->isEmpty()) {
            return 'No date';
        }

        return $prevRates[0]->date->translatedFormat('l, d F Y');
    }
}
