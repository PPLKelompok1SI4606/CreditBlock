<div {{ $attributes->merge(['class' => 'flex flex-col w-[600px] px-8 py-5 h-[300px] rounded-3xl border-2 border-gray-300 bg-[#c7e7ff] transition ease-in-out duration-300 hover:-translate-y-1 hover:shadow-xl']) }}>
    {{ $slot }}
</div>
