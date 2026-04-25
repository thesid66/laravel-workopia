<x-layout>
	<x-slot name="title">Job Listing</x-slot>
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
