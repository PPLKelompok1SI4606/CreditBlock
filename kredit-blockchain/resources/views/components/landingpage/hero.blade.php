<div class="flex items-center justify-between px-[50px] w-[1320px] h-[610px] rounded-2xl border border-[#c7e7ff] bg-white">
    <div class="w-[600px]">
        <h1 class="text-4xl font-bold w-[600px] text-[#2A9DF4] hidden-animated">
            Pinjam Dana Instan, Dijamin Aman dengan Teknologi Blockchain!
        </h1>

        <div class="w-full h-[1px] bg-[#c7e7ff] mt-3"></div>

        <h1 class="mt-5 mb-10 text-5xl font-bold text-[#1167B1] hidden-animated">
            Easy for Your Credit
        </h1>

        <ul class="flex flex-col gap-y-2">
            <li class="flex hidden-animated">
                <img src="{{asset('images/check.png')}}" alt="" class="mr-2">
                Ajukan pinjamanmu tanpa ribet!
            </li>
            <li class="flex hidden-animated">
                <img src="{{asset('images/check.png')}}" alt="" class="mr-2">
                Lacak transaksi secara real-time
            </li>
            <li class="flex hidden-animated">
                <img src="{{asset('images/check.png')}}" alt="" class="mr-2">
                Nikmati cicilan fleksibel dalam satu platform
            </li>
        </ul>

        <div class="relative inline-flex w-full h-full mt-10 shadow-lg hidden-animated">
            <input
                type="text"
                class="w-full h-[60px] border border-gray-300 rounded-md focus:outline-none focus:ring-2 #c7e7ff focus:ring-blue-500"
                placeholder="Masukkan teks..."
            />
            <button
                class="flex items-center px-10 py-2 mt-[9px] mr-4 absolute right-0 bg-blue-500 text-white rounded-xl border border-blue-500 hover:bg-blue-600">
                Submit
            </button>
        </div>

        <button
            class="inline-flex hidden-animated text-white w-full items-center justify-center mt-5 h-[50px] border border-gray-300 rounded-md bg-[#2A9DF4] focus:outline-none focus:ring-2 #c7e7ff focus:ring-blue-500 transition duration-300 ease-in-out hover:-translate-y-1">
            <img src="{{asset('images/mail.png')}}" alt="" class="w-[25px] h-[25px] mr-4">
            Respond to Mail Offer
        </button>

        <div class="inline-flex w-full h-full items-center mt-5 hidden-animated">
            <img src="{{asset('images/people.png')}}" alt="" class="w-[80px]">
            <h1 class="font-semibold ml-3">50,000+ pengguna di dunia </h1>
        </div>

    </div>
    <div class="flex flex-col w-full h-full items-end py-9 hidden-animated">
        <a href="{{route('dashboard')}}">
            <button class="inline-flex text-2xl justify-end items-center px-10 py-4 text-white rounded-full bg-blue-400 transition duration-300 ease-in-out hover:-translate-y-1 hover:scale-105 hover:shadow-xl">
                Mulai ajukan !
                <img src="{{asset('images/arrow.png')}}" alt="" class="w-[15px] h-[15px] ml-3">
            </button>
        </a>
        <img src="{{asset('images/logoCard.png')}}" alt="" class="mt-10 w-[500px] absolute">
    </div>
</div>

<script ></script>
