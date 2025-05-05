<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class KYCController extends Controller
{
    public function create()
    {
        return view('auth.kyc');
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'id_type' => ['required', 'in:ktp,sim'],
                'id_document' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            ]);

            // Ambil ID pengguna dari sesi
            $userId = $request->session()->get('pending_user_id');

            if (!$userId) {
                Log::error('No pending_user_id found in session');
                return redirect()->route('welcome')->with('error', 'Sesi registrasi telah berakhir. Silakan registrasi ulang.');
            }

            $user = User::find($userId);

            if (!$user) {
                Log::error('User not found for ID: ' . $userId);
                return redirect()->route('welcome')->with('error', 'Pengguna tidak ditemukan. Silakan registrasi ulang.');
            }

            // Simpan dokumen KYC
            if ($request->hasFile('id_document')) {
                $file = $request->file('id_document');
                $fileName = 'kyc/' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public', $fileName);

                if (!$path) {
                    Log::error('Failed to store file for user ID: ' . $userId);
                    return redirect()->back()->with('error', 'Gagal menyimpan dokumen. Silakan coba lagi.');
                }

                // Perbarui data pengguna
                $user->update([
                    'id_type' => $request->id_type,
                    'id_document' => $fileName,
                    'status_kyc' => 'pending',
                ]);

                Log::info('KYC uploaded successfully for user ID: ' . $userId);
            }

            // Hapus ID pengguna dari sesi setelah KYC selesai
            $request->session()->forget('pending_user_id');

            // Arahkan ke landing page dengan pesan sukses
            return redirect()->route('landing')->with('status', 'Dokumen KYC berhasil diunggah! Silakan login setelah KYC Anda disetujui oleh admin.');
        } catch (\Exception $e) {
            Log::error('Exception in KYCController@store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}