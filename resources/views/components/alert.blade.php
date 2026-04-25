@props(['type', 'message', 'timeout' => '3000'])

@if (session()->has($type))
	<div
		x-data="{ show: true }"
		x-init="setTimeout(() => show = false, {{ $timeout }})"
		x-show="show"
		class="{{ $type == 'success' ? 'bg-green-500' : 'bg-red-500' }} mb-4 rounded p-4 text-sm text-white"
	>
		{{ $message }}
	</div>
@endif
