<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminKYCController extends Controller
{
    /**
     * Menyetujui verifikasi KYC untuk pengguna.
     */
    public function approve(Request $request, User $user): RedirectResponse
    {
        $user->update(['is_verified' => true]);

        return redirect()->route('admin.dashboard')->with('status', 'KYC berhasil disetujui untuk ' . $user->name . '.');
    }

    /**
     * Menolak verifikasi KYC untuk pengguna dan menghapus data KYC.
     */
    public function reject(Request $request, User $user): RedirectResponse
    {
        if ($user->id_document) {
            Storage::disk('public')->delete($user->id_document);
        }

        $user->update([
            'id_type' => null,
            'id_document' => null,
            'is_verified' => false,
        ]);

        return redirect()->route('admin.dashboard')->with('status', 'KYC ditolak untuk ' . $user->name . '.');
    }
}
