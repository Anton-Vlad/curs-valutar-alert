<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LatestCurrencyRate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookmarkController extends Controller
{
    /**
     * Show the user's dashboard page.
     */
    public function index(Request $request): Response
    {
        $latestRates = LatestCurrencyRate::orderBy('rate', 'desc')
            ->whereIn('currency', ['EUR', 'USD', 'CHF', 'GBP', 'BGN', 'HUF'])
            ->get();


        return Inertia::render('Bookmarks', [
            'bookmarks' => $latestRates,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        return back();
    }
}
