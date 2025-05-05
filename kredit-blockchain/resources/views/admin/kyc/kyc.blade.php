<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi KYC</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-stretch min-h-screen">
    <!-- Kolom Kiri: Logo dan Deskripsi -->
    <div class="w-1/2 bg-gradient-to-br from-blue-100 to-blue-200 flex flex-col justify-center items-center p-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-blue-800 mb-4">CreditBl🔹ck</h1>
            <h2 class="text-2xl font-semibold text-blue-700 mb-2">Credit Dompet Aman dengan Blockchain untuk SEMUANYA</h2>
            <p class="text-blue-600">CreditBlock adalah sebuah aplikasi berbasis website yang bisa mengamankan dompet digital Anda dengan menggunakan teknologi blockchain.</p>
        </div>
    </div>

    <!-- Kolom Kanan: Formulir KYC -->
    <div class="w-1/2 flex flex-col justify-center items-center p-8 bg-white">
        <div class="w-full max-w-md">
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Verifikasi Identitasmu Sekarang!</h2>
            <p class="text-sm text-gray-500 mb-6">Sekarang</p>

            <!-- Menampilkan pesan error jika ada -->
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Menampilkan pesan sukses jika ada -->
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <form action="{{ route('kyc.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Tipe ID -->
                <div>
                    <label for="id_type" class="block text-sm font-medium text-gray-700">Tipe ID</label>
                    <select name="id_type" id="id_type" required
                            class="mt-1 w-full border border-gray-300 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                        <option value="" disabled selected>KTP</option>
                        <option value="ktp">KTP</option>
                        <option value="sim">SIM</option>
                    </select>
                    @error('id_type')
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Unggah Foto -->
                <div>
                    <label for="id_document" class="block text-sm font-medium text-gray-700">Upload ID</label>
                    <div class="mt-1 border border-dashed border-gray-300 rounded-md p-4 text-center">
                        <input type="file" name="id_document" id="id_document" accept="image/jpeg,image/png,application/pdf" required
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-2">Format yang diterima: JPG, JPEG, PNG, PDF (maks. 2MB)</p>
                    </div>
                    @error('id_document')
                        <span class="text-red-600 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="flex justify-between">
                    <a href="{{ route('welcome') }}"
                       class="px-4 py-2 text-red-600 font-semibold rounded-md hover:text-red-700">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md font-semibold hover:bg-blue-600 transition-all duration-300">
                        Submit
                    </button>
                </div>
            </form>

            <p class="text-sm text-gray-500 mt-4 text-center">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Mari Kesini</a>
            </p>
        </div>
    </div>
</body>
</html>