<x-layout>
	<x-slot name="title">Job Listing</x-slot>
	<div class="h24 mb-4 mt-4 flex items-center justify-center rounded bg-blue-900 px-4">
		<x-search />
	</div>

	{{-- Back button --}}
	@if (request()->has('keywords') || request()->has('location'))
		<x-button
			href="{{ route('jobs.index') }}"
			icon="fa-solid fa-angles-left"
			class="mb-4"
		>Back</x-button>
	@endif

	<h1 class="mb-4 text-3xl font-bold underline">Job Listing</h1>

	<div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
		@forelse ($jobs as $job)
			<x-job-card :job="$job" />
		@empty
			<p>No jobs found</p>
		@endforelse
	</div>
	{{-- Pagination --}}
	{{ $jobs->links() }}
</x-layout>
