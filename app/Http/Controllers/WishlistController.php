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
        $wishlistItems = Wishlist::where('user_id','=', $user->id)->get();
        return view('user.wishlist', compact('wishlistItems'));
    }

    public function addOrRemove (Request $request, $id) {
        $user = Auth::guard('user')?->user();
        
        if (!$user){
            return redirect('user/login');    
        }

        $wishlistItem = Wishlist::where('user_id', $user->id)
        ->where('tutorial_id', $id)
        ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $message = 'دوره باموفقیت از لیست علاقه‌مندی های شما حذف شد.';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'tutorial_id' =>  $id,
            ]);
            $message = 'دوره با موفقیت به لیست علاقه‌مندی های شما اضافه شد.';
        }

        return redirect()->back()->with('success', $message);
    }

}
