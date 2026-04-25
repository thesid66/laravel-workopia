@props(['url' => '/', 'active' => false, 'icon' => null, 'block' => false])

<a href="{{ $url }}"
    class="text-sm font-medium transition {{ $active ? 'text-indigo-400' : 'text-slate-300 hover:text-white' }} {{ $block ? 'block' : '' }}">
    @if ($icon)
        <i class="fa fa-{{ $icon }}"></i>
    @endif
    {{ $slot }}
</a>
