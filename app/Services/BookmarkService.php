<?php
namespace App\Services;

use App\Models\Bookmark;
use Illuminate\Support\Collection;
use Inertia\Inertia;

class BookmarkService
{
    /**
     * @return Collection
     *
     * Handle the display of latest date for rates
     */
    public function getUserBookmarks(): Collection
    {
        $bookmarks = Bookmark::where('user_id', auth()->id())->get();
        if ($bookmarks->isEmpty()) {
            return collect([]);
        }

        return collect($bookmarks[0]->symbols)->filter(function ($value) {
            return $value !== false;
        });
    }
}
