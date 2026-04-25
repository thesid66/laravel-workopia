@props(['id', 'name', 'label' => null, 'value' => '', 'div_class' => '', 'options' => []])

<div class="{{ $div_class }}">
	@if ($label)
		<label
			for="{{ $id }}"
			class="mb-1 block text-sm font-medium text-slate-700"=
		>{{ $label }}</label>
	@endif
	<select
		name="{{ $name }}"
		id="{{ $id }}"
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
		@foreach ($options as $optionValue => $optionLabel)
			<option
				value="{{ $optionValue }}"
				{{ old($name, $value) == $optionValue ? 'selected' : '' }}
			>{{ $optionLabel }}</option>
		@endforeach
	</select>
	@error($name)
		<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
	@enderror
</div>
