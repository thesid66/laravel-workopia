<x-layout>
	<div class="py-10 sm:py-6 lg:py-12">
		<h1 class="mb-4 border border-gray-300 p-3 text-center text-3xl font-bold underline">Welcome to Workopolis</h1>

		<div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
			@forelse ($jobs as $job)
				<x-job-card :job="$job" />
			@empty
				<p>No jobs found</p>
			@endforelse
		</div>

		<a
			href="{{ route('jobs.index') }}"
			class="block text-center text-xl"
		>
			<i class="fa fa-arrow-alt-circle-right"></i> Show all Jobs
		</a>
	</div>
	<x-bottom-banner />
</x-layout>
