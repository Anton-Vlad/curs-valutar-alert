<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Models\ExchangeRate;
use App\Models\LatestCurrencyRate;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class DashboardController extends Controller
{
    /**
     * Show the user's dashboard page.
     */
    public function index(Request $request): Response
    {
        setlocale(LC_TIME, 'ro_RO'); // Set Romanian locale
        Carbon::setLocale('ro');

        $latestRates = LatestCurrencyRate::orderBy('rate', 'desc')->get();

        $date = $latestRates[0]->date->translatedFormat('l, d F Y');

        return Inertia::render('Dashboard', [
            'latestDate' => $date,
            'rates' => $latestRates,
        ]);
    }
}
