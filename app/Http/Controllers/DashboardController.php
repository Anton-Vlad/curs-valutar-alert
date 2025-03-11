<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\BookmarkService;
use App\Services\RateService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Show the user's dashboard page.
     */
    public function index(Request $request, RateService $rateService, BookmarkService $bookmarkService): Response
    {
        $latestRates = $rateService->getLatestRates();

        // Default Empty Response
        if ($latestRates->isEmpty()) {
            return Inertia::render('Dashboard', [
                'latestDate' => "",
                'rates' => [],
                'bookmarks' => []
            ]);
        }

        // User bookmarked symbols
        $bookmarks = $bookmarkService->getUserBookmarks();

        return Inertia::render('Dashboard', [
            'latestDate' => $rateService->getLatestDate(),
            'rates' => $latestRates,
            'bookmarks' => $bookmarks
        ]);
    }
}
