<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex px-5 py-3 bg-blue-400 rounded-xl hover:bg-blue-500']) }}>
    {{ $slot }}
</button>
