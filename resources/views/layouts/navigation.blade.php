<x-nav-link :href="route('artistas.index')" :active="request()->routeIs('artistas.index')">
    {{ __('Artistas') }}
</x-nav-link>

<x-nav-link :href="route('albuns.index')" :active="request()->routeIs('albuns.index')">
    {{ __('Álbuns') }}
</x-nav-link>

<x-nav-link :href="route('musicas.index')" :active="request()->routeIs('musicas.index')">
    {{ __('Músicas') }}
</x-nav-link>