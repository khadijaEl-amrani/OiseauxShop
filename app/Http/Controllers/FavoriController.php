<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Favori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriController extends Controller
{
    /**
     * Display a listing of the user's favorites.
     */
    public function index()
    {
        $favoris = Auth::user()->annoncesFavorites()->paginate(12);
        
        return view('user.favoris', compact('favoris'));
    }

    /**
     * Toggle favorite status for an announcement.
     */
    public function toggle(Request $request, $annonceId)
    {
        $annonce = Annonce::findOrFail($annonceId);
        $user = Auth::user();
        
        $favori = Favori::where('user_id', $user->id)
            ->where('annonce_id', $annonce->id)
            ->first();
            
        if ($favori) {
            $favori->delete();
            $message = 'Annonce retirée des favoris.';
            $status = false;
        } else {
            Favori::create([
                'user_id' => $user->id,
                'annonce_id' => $annonce->id,
            ]);
            $message = 'Annonce ajoutée aux favoris.';
            $status = true;
        }
        
        if ($request->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);
        }
        
        return back()->with('success', $message);
    }
}