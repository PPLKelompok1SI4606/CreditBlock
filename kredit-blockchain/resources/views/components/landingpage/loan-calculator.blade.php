<div class="flex flex-col items-start hidden-animated">
    <p class="text-[#1167B1] font-bold text-lg"><span class="mr-3">1.</span> Jumlah Pinjaman yang akan diajukan</p>
    <p class="text-gray-500">Maksimal pengajuan pinjaman adalah <span><span class="text-red-500">Rp100.000.000</span></span></p>
    <div class="my-5 inline-flex w-[650px] h-[50px]">
        <p class="flex items-center text-[#2A9DF4] font-semibold border border-r-0 border-gray-300 rounded-l-lg w-[400px] h-full pl-5">Jumlah Pinjaman</p>
        <p class="flex items-center border border-r-0 border-l-0 border-gray-300 w-[45px] h-full pl-5 text-[#1167B1] font-semibold">Rp.</p>
        <input type="text" class="flex border-l-0 rounded-r-lg w-[250px] h-full border border-gray-300 ring-0 focus:ring-0 text-[#1167B1] font-semibold" placeholder="Masukkan jumlah pinjaman">
    </div>
</div>

<div class="flex flex-col items-start mt-5 hidden-animated">
    <p class="text-[#1167B1] font-bold text-lg"><span class="mr-3">2.</span> Lama Pinjaman yang Akan Diajukan</p>
    <p class="text-gray-500">Masukkan pinjaman dalam jangka waktu bulan.</p>
    <div class="my-5 inline-flex w-[650px] h-[50px]">
        <p class="flex items-center text-[#2A9DF4] font-semibold border border-r-0 border-gray-300 rounded-l-lg w-[250px] h-full pl-5">Lama Pinjaman</p>
        <input type="text" class="flex text-center border-l-0 border-r-0 w-[150px] h-full border border-gray-300 ring-0 focus:ring-0 text-[#1167B1] font-semibold" placeholder="Masukkan Bulan">
        <p class="flex items-center justify-end border border-l-0 border-gray-300 rounded-r-lg w-[250px] h-full pr-5 text-[#2A9DF4] font-semibold">Bulan</p>
    </div>
</div>

<div class="flex flex-col items-start mt-5 hidden-animated">
    <p class="text-[#1167B1] font-bold text-lg"><span class="mr-3">3.</span> Bunga Pinjaman</p>
    <p class="text-gray-500">Bunga pinjaman yang dimasukkan dalam kurun waktu per tahun.</p>
    <div class="my-5 inline-flex w-[650px] h-[50px]">
        <p class="flex items-center text-[#2A9DF4] font-semibold border border-r-0 border-gray-300 rounded-l-lg w-[250px] h-full pl-5">Bunga Pinjaman</p>
        <input type="text" class="flex text-center border-l-0 border-r-0 w-[150px] h-full border border-gray-300 ring-0 focus:ring-0 text-[#1167B1] font-semibold" placeholder="Masukkan Persen">
        <p class="flex items-center justify-end text-[#2A9DF4] font-semibold border border-l-0 border-gray-300 rounded-r-lg w-[250px] h-full pr-5">%</p>
    </div>
</div>

<div class="flex flex-col items-start mt-5 hidden-animated">
    <p class="text-[#1167B1] font-bold text-lg"><span class="mr-3">4.</span> Mulai Melakukan Pinjaman</p>
    <p class="text-gray-500">Masukkan waktu Anda mulai melakukan peminjaman.</p>

    <div class="flex justify-between w-[650px] h-[50px]">

        <x-landingpage.option-month></x-landingpage.option-month>

        <x-landingpage.option-year></x-landingpage.option-year>

    </div>

    <p class="mt-10 font-bold text-[#1167B1] text-lg text-center w-full hidden-animated">Sampai Dengan</p>

    <div class="flex justify-between w-[650px] h-[50px] hidden-animated">
        <x-landingpage.option-month></x-landingpage.option-month>

        <x-landingpage.option-year></x-landingpage.option-year>
    </div>

</div>
