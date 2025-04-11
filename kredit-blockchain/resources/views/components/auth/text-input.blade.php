@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'bg-gray-100 border-0 border-b-2 border-b-blue-500 focus:border-b-blue-500 outline-none py-2 px-3 text-gray-700 placeholder-gray-400 transition-colors duration-200 ease-in-out']) }}
/>
