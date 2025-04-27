<x-guest-layout>
    <div class="text-3xl font-bold text-center w-[400px] mb-10">
        Verifikasikan Identitasmu Sekarang!🪪
    </div>
    <form action="">
        <div class="w-[500px] flex flex-col items-center justify-center">
            <div class="mb-4 w-[400px]">
                <label for="id_type" class="block text-sm font-medium text-gray-700">Tipe ID</label>
                <select name="id_type" id="id_type" class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="passport">KTP</option>
                    <option value="driver_license">SIM</option>
                </select>
            </div>
            <div class="mb-6 mt-2 w-[400px]">
                <label for="id_document" class="block text-sm font-medium text-gray-700">Upload ID Document</label>
                <div id="dropArea" class="mt-1 p-6 border-2 border-dashed border-gray-300 rounded-lg text-center">
                    <div id="previewContainer" class="flex flex-col items-center mb-2">
                        <svg id="uploadIcon" class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 4v6m-6-6h6"></path>
                        </svg>
                        <img id="previewImage" class="hidden max-w-full max-h-48 object-contain" alt="Preview">
                    </div>
                    <p id="dropText" class="text-gray-600">Drag and Drop or <span class="text-blue-500 cursor-pointer" onclick="document.getElementById('id_document').click()">Choose file</span> to upload</p>
                    <p id="formatText" class="text-gray-400 text-sm mt-1">Supported formats: .jpg, .png</p>
                    <button id="cancelButton" type="button" class="hidden mt-2 text-red-500 hover:text-red-700">Cancel</button>
                    <input type="file" name="id_document" id="id_document" class="hidden" accept="image/jpeg,image/png" required>
                </div>
            </div>
            <div class="flex mt-7 relative w-[400px]">
                <label for="remember_me" class="inline-flex items-center">
                    <input
                        type="checkbox"
                        class="rounded p-[10px] border-gray-300 text-blue-400 shadow-sm focus:ring-0 focus:ring-offset-0"
                        name="check"
                    >
                    <div class="flex flex-col relative">
                        <span class="ms-2 text-[11px] text-gray-400">{{ __('Saya Setuju dengan Aturan Berlaku') }}</span>
                        <x-auth.input-error :messages="$errors->get('check')" class="absolute mt-5 ms-2 " />
                    </div>
                </label>

                <div class="ml-auto">
                    <x-auth.primary-button>
                        {{ __('Sign Up') }}
                    </x-auth.primary-button>
                </div>

            </div>
        </div>
    </form>
    <div class="w-[400px] flex justify-center mt-[70px]">
        <h1>Sudah Punya Akun?
            <button class="transition duration-300 ease-in-out hover:-translate-y-1 hover:translate-x-1 hover:text-[#0090FE] hover:scale-110">
                <a href={{ route('login') }} class="text-blue-400">Mari Kesini</a>
            </button>
        </h1>
    </div>
    <div class="inline-flex gap-x-4 justify-center w-full mt-[20px] items-center">
        <a href="{{ route('welcome') }}">
            <div class="py-2 px-4 border rounded-full {{ request()->routeIs('welcome') ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white' }}">
                1
            </div>
        </a>
        <a href="{{ route('register') }}">
            <div class="py-2 px-4 border rounded-full {{ request()->routeIs('register') ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white' }}">
                2
            </div>
        </a>
        <a href="{{ route('kyc') }}">
            <div class="py-2 px-4 border rounded-full {{ request()->routeIs('kyc') ? 'bg-blue-500 text-white' : 'hover:bg-blue-500 hover:text-white' }}">
                3
            </div>
        </a>
    </div>

     <!-- JavaScript for Drag-and-Drop -->
     <script>
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('id_document');
        const previewImage = document.getElementById('previewImage');
        const previewContainer = document.getElementById('previewContainer');
        const uploadIcon = document.getElementById('uploadIcon');
        const dropText = document.getElementById('dropText');
        const formatText = document.getElementById('formatText');
        const cancelButton = document.getElementById('cancelButton');

        // Prevent default behaviors for drag-and-drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        // Highlight drop area when dragging over
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.add('border-blue-500', 'bg-blue-50');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.remove('border-blue-500', 'bg-blue-50');
            }, false);
        });

        // Function to handle file preview
        function previewFile(file) {
            if (file && (file.type === 'image/jpeg' || file.type === 'image/png')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    uploadIcon.classList.add('hidden');
                    dropText.classList.add('hidden');
                    formatText.classList.add('hidden');
                    cancelButton.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                alert('Please upload a valid image file (.jpg or .png).');
                fileInput.value = ''; // Reset file input if invalid
            }
        }

        // Handle dropped files
        dropArea.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                previewFile(files[0]);
            }
        }, false);

        // Handle manual file selection
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                previewFile(fileInput.files[0]);
            }
        });

        // Handle cancel button click
        cancelButton.addEventListener('click', () => {
            fileInput.value = ''; // Reset file input
            previewImage.src = '';
            previewImage.classList.add('hidden');
            uploadIcon.classList.remove('hidden');
            dropText.classList.remove('hidden');
            formatText.classList.remove('hidden');
            cancelButton.classList.add('hidden');
        });
    </script>
</x-guest-layout>
