@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-0 border-b-2 border-b-gray-200 focus:border-b-blue-500 focus:ring-0 focus:outline-none py-2 px-2 text-gray-700 placeholder-gray-400 transition-colors duration-200 ease-in-out']) }}
/>
