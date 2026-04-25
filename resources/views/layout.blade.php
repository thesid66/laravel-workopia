<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1.0"
	>
	<meta
		http-equiv="X-UA-Compatible"
		content="ie=edge"
	>
	<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
		integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
		crossorigin="anonymous"
		referrerpolicy="no-referrer"
	/>
	@vite('resources/css/app.css')
	<style>
		[x-cloak] {
			display: none !important;
		}
	</style>
	<title>{{ $title ?? 'Workopia | Find and list jobs' }}</title>

</head>

<body class="bg-white">
	<x-header />
	@if (request()->is('/'))
		<x-hero />
		<x-top-banner />
	@endif
	<main class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
		{{-- display alert messages --}}
		@if (session('success'))
			<x-alert
				type="success"
				message="{{ session('success') }}"
			/>
		@endif
		@if (session('error'))
			<x-alert
				type="error"
				message="{{ session('error') }}"
			/>
		@endif
		{{ $slot }}
	</main>
</body>
<script
	defer
	src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
></script>

</html>
