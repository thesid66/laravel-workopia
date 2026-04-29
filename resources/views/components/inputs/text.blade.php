@props([
    'id',
    'name',
    'label' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'div_class' => '',
    'required' => false
])

<div class="{{ $div_class }}">
	@if ($label)
		<label
			for="{{ $id }}"
			class="mb-1 block text-sm font-medium text-slate-700"
		>{{ $label }}</label>
	@endif
	<input
		type="{{ $type }}"
		name="{{ $name }}"
		id="{{ $id }}"
		value="{{ old($name, $value) }}"
		placeholder="{{ $placeholder }}"
		{{ $required ? 'required' : '' }}
		@class([
			'w-full rounded-md border px-3 py-2 text-slate-800 focus:outline-none focus:ring-1',
			'border-red-500 focus:border-red-500 focus:ring-red-500' => $errors->has(
				$name
			),
			'border-slate-300 focus:border-indigo-500 focus:ring-indigo-500' => !$errors->has(
				$name
			)
		])
	>
	@error($name)
		<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
	@enderror
</div>
