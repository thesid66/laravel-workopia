@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'icon' => null,
    'size' => 'medium',
    'rounded' => 'rounded-xl'
])

@php
	$baseClass = 'inline-flex items-center justify-center gap-2  text-sm font-semibold transition';

	// Size variants (you can tweak these as needed)
	$sizes = [
	    'xsmall' => 'px-2 py-1 text-xs',
	    'small' => 'px-3 py-2 text-sm',
	    'medium' => 'px-4 py-2.5 text-sm', // default (your current one)
	    'large' => 'px-6 py-4 text-lg',
	    'xlarge' => 'px-8 py-5.5 text-xl'
	];

	$sizeClass = $sizes[$size] ?? $sizes['medium'];

	$variants = [
	    'primary' => 'bg-indigo-600 text-white hover:bg-indigo-500 shadow-md',
	    'secondary' => 'bg-slate-800 text-white hover:bg-slate-700',
	    'outline' => 'border border-slate-700 text-slate-300 hover:bg-slate-900 hover:text-white',
	    'ghost' => 'text-slate-300 hover:text-white hover:bg-slate-800',
	    'danger' => 'bg-red-600 text-white hover:bg-red-500'
	];

	$variantClass = $variants[$variant] ?? $variants['primary'];
@endphp

@if ($href)
	<a
		href="{{ $href }}"
		{{ $attributes->merge(['class' => $baseClass . ' ' . $variantClass . ' ' . $sizeClass . ' ' . $rounded]) }}
	>
		@if ($icon)
			<i class="{{ $icon }}"></i>
		@endif
		{{ $slot }}
	</a>
@else
	<button
		type="{{ $type }}"
		{{ $attributes->merge(['class' => $baseClass . ' ' . $variantClass . ' ' . $sizeClass]) }}
	>
		@if ($icon)
			<i class="{{ $icon }}"></i>
		@endif
		{{ $slot }}
	</button>
@endif
