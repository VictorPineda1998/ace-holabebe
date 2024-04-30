<button {{ $attributes->merge([
    'type' => 'button', 
    'class' => 'inline-flex items-center px-4 py-2 bg-purple-400
                border border-transparent rounded-md font-semibold
                text-xs text-white uppercase tracking-widest hover:bg-purple-600 
                focus:bg-green-600 active:bg-green-700 focus:outline-none
                focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>