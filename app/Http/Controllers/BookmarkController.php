<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\LatestCurrencyRate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use PhpParser\Node\Expr\Throw_;

class BookmarkController extends Controller
{
    /**
     * Show the user's dashboard page.
     */
    public function index(Request $request): Response
    {
        $bookmarks = Bookmark::where('user_id', auth()->id())->get();
        if ($bookmarks->isEmpty()) {
            $bookmarkedSymbols = [];
            return Inertia::render('Bookmarks', [
                'data' => [],
            ]);
        }

        $bookmarkedSymbols = collect($bookmarks[0]->symbols)->filter(function ($value) {
            return $value !== false;
        })->keys()->toArray();

        $latestRates = LatestCurrencyRate::orderBy('rate', 'desc')
            ->whereIn('currency', $bookmarkedSymbols)
            ->get();


        return Inertia::render('Bookmarks', [
            'data' => $bookmarkedSymbols,
            'rates' => $latestRates,
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
}
