<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index() 
    {
        $wishlistedRooms = Auth::user()->wishlists()->with('room')->get();
        return view('users.wishlist', compact('wishlistedRooms'));
    }

    public function toggle(Request $request)
    {
        $roomId = $request->input('room_id');
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $wishlist = Wishlist::where('user_id', $user->id)->where('room_id', $roomId)->first();

        if ($wishlist) {
            // Hapus dari wishlist jika sudah ada
            $wishlist->delete();
            return response()->json(['success' => true, 'message' => 'Removed from wishlist']);
        } else {
            // Tambahkan ke wishlist jika belum ada
            Wishlist::create([
                'user_id' => $user->id,
                'room_id' => $roomId,
            ]);
            return response()->json(['success' => true, 'message' => 'Added to wishlist']);
        }
    }

    public function remove($id)
    {
        $wishlist = Wishlist::where('id', $id)->where('user_id', Auth::id())->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed']);
        }

        return response()->json(['status' => 'error', 'message' => 'Wishlist not found'], 404);
    }
}
