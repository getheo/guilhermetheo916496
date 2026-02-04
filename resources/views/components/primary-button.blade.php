<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'inline-flex items-center px-4 py-2 bg-[#232c77] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1a215a] focus:bg-[#1a215a] active:bg-[#151a46] focus:outline-none focus:ring-2 focus:ring-[#232c77] focus:ring-offset-2 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>