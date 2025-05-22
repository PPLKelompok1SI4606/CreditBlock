<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        Log::info('Fetching user profile for edit', ['user_id' => $user->id, 'profile_picture' => $user->profile_picture]);
        return response()->json([
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        Log::info('Starting profile update process', ['user_id' => Auth::id()]);

        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            // Hapus foto profil lama jika ada
            if ($user->profile_picture) {
                Log::info('Deleting old profile picture', ['old_picture' => $user->profile_picture]);
                Storage::delete('public/profile_pictures/' . $user->profile_picture);
            }

            // Simpan foto profil baru
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            Log::info('Saving new profile picture', ['filename' => $filename]);
            $file->storeAs('public/profile_pictures', $filename);

            // Perbarui kolom profile_picture di database
            $user->profile_picture = $filename;
            $user->save();
            Log::info('Profile picture updated in database', ['user_id' => $user->id, 'new_picture' => $filename]);

            // Kembalikan URL dengan timestamp untuk mencegah caching
            $profilePictureUrl = asset('storage/profile_pictures/' . $filename) . '?t=' . time();
            Log::info('Returning new profile picture URL', ['url' => $profilePictureUrl]);

            return response()->json([
                'message' => 'Foto profil berhasil diperbarui.',
                'profile_picture' => $profilePictureUrl
            ]);
        }

        Log::info('No profile picture uploaded');
        return response()->json([
            'message' => 'Tidak ada foto yang diunggah.'
        ]);
    }
}