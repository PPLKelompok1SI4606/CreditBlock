<div class="flex text-[#1167B1]">
    {{$slot}}

    <div class="h-[100px] flex items-center transition duration-300 ease-in-out hover:-translate-y-1 ">
        <div class="w-[60px] h-[60px] flex items-center justify-center rounded-full bg-[#94CEF9] hover:shadow-xl">
        <img src="{{asset('images/arrow.png')}}" alt="">
        </div>
    </div>

</div>
