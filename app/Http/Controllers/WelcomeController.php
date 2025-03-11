<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use App\Models\LatestCurrencyRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class WelcomeController extends Controller
{
    /**
     * Show the user's dashboard page.
     */
    public function index(Request $request): Response
    {
        setlocale(LC_TIME, 'ro_RO'); // Set Romanian locale
        Carbon::setLocale('ro');

        $latestRates = LatestCurrencyRate::orderBy('rate', 'desc')
            ->whereIn('currency', ['EUR', 'USD', 'CHF', 'GBP', 'BGN', 'HUF'])
            ->get();

        $date = $latestRates[0]->date->translatedFormat('d F Y');

        return Inertia::render('Welcome', [
            'latestDate' => $date,
            'rates' => $latestRates,
        ]);
    }
}
