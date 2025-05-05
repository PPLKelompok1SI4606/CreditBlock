@extends('layouts.admin')

   @section('title', 'Verifikasi KYC')

   @section('content')
       <div class="max-w-4xl mx-auto py-8">
           <h2 class="text-2xl font-semibold text-gray-900 mb-6">Verifikasi KYC</h2>

           @if ($error)
               <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                   {{ $error }}
               </div>
           @else
               <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                   <h3 class="text-xl font-semibold text-gray-900 mb-4">Detail Pengguna</h3>
                   <div class="space-y-4 text-sm text-gray-700">
                       <div><span class="font-medium">Nama:</span> {{ $user->name }}</div>
                       <div><span class="font-medium">Email:</span> {{ $user->email }}</div>
                       <div><span class="font-medium">Tipe ID:</span> {{ $user->id_type }}</div>
                       <div>
                           <span class="font-medium">Dokumen KYC:</span>
                           <div class="mt-2 border border-gray-200 rounded-lg p-4">
                               <img src="{{ Storage::url($user->id_document) }}" alt="Dokumen KYC" class="max-w-full h-auto rounded-lg">
                           </div>
                       </div>
                   </div>
                   <div class="mt-6 flex space-x-4">
                       <form action="{{ route('admin.kyc.approve', $user->id) }}" method="POST">
                           @csrf
                           <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600">
                               Setujui KYC
                           </button>
                       </form>
                       <form action="{{ route('admin.kyc.reject', $user->id) }}" method="POST">
                           @csrf
                           <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600"
                                   onclick="return confirm('Apakah Anda yakin ingin menolak KYC ini? Dokumen akan dihapus.')">
                               Tolak KYC
                           </button>
                       </form>
                   </div>
               </div>
           @endif
       </div>
   @endsection
