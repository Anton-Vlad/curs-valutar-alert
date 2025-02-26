<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Models\ExchangeRate;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Show the user's dashboard page.
     */
    public function index(Request $request): Response
    {
        $latestRates = ExchangeRate::orderBy('date')->take(2)->get();
        $ratesDict = $latestRates[0]->rates;
        $rates = [];

        $codes = array_keys($ratesDict);
        foreach ($codes as $code) {
            $rates[] = [
                'code' => $code,
                'value' => $ratesDict[$code]
            ];
        }

        $date = $latestRates[0]->date;

        return Inertia::render('Dashboard', [
            'date' => $date,
            'rates' => $rates,
        ]);
    }
}
