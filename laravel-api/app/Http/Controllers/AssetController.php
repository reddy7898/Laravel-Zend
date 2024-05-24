<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User;
use App\Models\AssetHistory;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index($userId)
    {
        $user = User::findOrFail($userId);
        return response()->json($user->assets()->where('is_active', true)->get());
    }

    public function activate(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);
        $asset->is_active = true;
        $asset->activated_at = now();
        $asset->save();

        AssetHistory::create([
            'asset_id' => $asset->id,
            'user_id' => auth()->id(),
            'status' => 'activated',
            'changed_at' => now()
        ]);

        return response()->json(['message' => 'Asset activated successfully']);
    }

    public function deactivate(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);
        $asset->is_active = false;
        $asset->deactivated_at = now();
        $asset->save();

        AssetHistory::create([
            'asset_id' => $asset->id,
            'user_id' => auth()->id(),
            'status' => 'deactivated',
            'changed_at' => now()
        ]);

        return response()->json(['message' => 'Asset deactivated successfully']);
    }
}
