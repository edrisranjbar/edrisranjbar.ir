<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::guard('user')?->user();
        $wishlistItems = Wishlist::all();#Wishlist::where('user_id','=', $user->id);
        return view('user.wishlist', compact('wishlistItems'));
    }

    public function addOrRemove (Request $request, $id) {
        $tutorial = Tutorial::findOrFail($id);
        $user = Auth::guard('user')?->user();

        // Check if the tutorial is already in the wishlist
        $wishlistItem = Wishlist::where('user_id', $user->id)
        ->where('tutorial_id', $tutorial->id)
        ->first();

        if ($wishlistItem) {
            // If the tutorial is in the wishlist, remove it
            $wishlistItem->delete();
            $message = 'دوره باموفقیت از لیست علاقه‌مندی های شما حذف شد.';
        } else {
            // If the tutorial is not in the wishlist, add it
            Wishlist::create([
                'user_id' => $user->id,
                'tutorial_id' => $tutorial->id,
            ]);
            $message = 'دوره با موفقیت به لیست علاقه‌مندی های شما اضافه شد.';
        }

        return redirect()->back()->with('success', $message);
    }

}
