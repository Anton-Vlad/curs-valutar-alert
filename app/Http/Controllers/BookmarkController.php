<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bookmarks\BookmarkUpdateRequest;
use App\Models\Bookmark;
use App\Services\BookmarkService;
use App\Services\RateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookmarkController extends Controller
{
    /**
     * Show the user's dashboard page.
     */
    public function index(Request $request, RateService $rateService, BookmarkService $bookmarkService): Response
    {
        $bookmarks = $bookmarkService->getUserBookmarks();
        if ($bookmarks->isEmpty()) {
            return Inertia::render('Bookmarks', [
                'rates' => []
            ]);
        }

        $bookmarkedSymbols = $bookmarks->keys()->toArray();

        return Inertia::render('Bookmarks', [
            'rates' => $rateService->getLatestRates($bookmarkedSymbols),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        try {
            Bookmark::updateOrCreate([
                'user_id' => $user->id
            ], [
                'symbols' => $request->input('symbols')
            ]);

            return back()->with('status', 'success'); //to_route('dashboard');
        } catch (\Throwable $error) {
//            throw $error;
            logger()->error($error);
            return back()->with('status', 'error');
        }
    }

    public function update(BookmarkUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $symbol = $request->input('symbol');
        $action = $request->input('action');

        try {
            $userBookmark = Bookmark::where('user_id', $user->id)->first();

            if (!$userBookmark) {
                Bookmark::create([
                    'user_id' => $user->id,
                    'symbols' => [$symbol => $action === 'add']
                ]);
                return back()->with('status', 'success');
            }

            $currentSymbols = $userBookmark->symbols;
            $currentSymbols[$symbol] = $action === 'add';
            $userBookmark->symbols = $currentSymbols;
            $userBookmark->save();

            return back()->with('status', 'success');
        } catch (\Throwable $error) {
//            throw $error;
            logger()->error($error);
            return back()->with('status', 'error');
        }
    }
}
