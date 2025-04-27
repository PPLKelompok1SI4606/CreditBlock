<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <h1 class="text-2xl font-bold mb-6">Verify KYC for {{ $user->name }}</h1>
        <div class="bg-white shadow sm:rounded-lg p-6">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>ID Type:</strong> {{ $user->id_type === 'passport' ? 'KTP' : 'SIM' }}</p>
            <p><strong>Document:</strong> <a href="{{ Storage::url($user->id_document) }}" target="_blank">View Document</a></p>
            <div class="mt-6">
                <form action="{{ route('admin.kyc.approve', $user->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Approve</button>
                </form>
                <form action="{{ route('admin.kyc.reject', $user->id) }}" method="POST" class="inline ml-4">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Reject</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
