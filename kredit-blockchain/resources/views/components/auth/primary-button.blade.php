<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-[50px] py-4 bg-[#2A9DF4] border-transparent shadow-xl shadow-blue-200 rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#0090FE] focus:bg-[#0090FE] active:bg-[#0090FE] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-300 ease-in-out hover:-translate-y-1 hover:scale-110']) }}>
    {{ $slot }}
</button>
