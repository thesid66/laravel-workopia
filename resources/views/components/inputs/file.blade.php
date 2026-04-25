@props(['id', 'name', 'label' => null, 'value' => '', 'placeholder' => '', 'div_class' => ''])

<div class="{{ $div_class }}">
	@if ($label)
		<label
			for="{{ $id }}"
			class="mb-1 block text-sm font-medium text-slate-700"
		>{{ $label }}</label>
	@endif
	<input
		type="file"
		name="{{ $name }}"
		id="{{ $id }}"
		accept="image/*"
		@class([
			'w-full rounded-md border px-3 py-2 text-slate-800 file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200 focus:outline-none focus:ring-1',
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
