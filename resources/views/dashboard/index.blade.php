<x-layout>
	@php
		$postedJobsCount = $jobs->count();
		$totalApplicantsCount = 0;
	@endphp

	<div
		x-data="{ confirmDelete: false, deleteFormId: null }"
		@keydown.escape.window="confirmDelete = false"
		class="py-8 sm:py-10"
	>
		<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
			<div>
				<p class="text-sm font-medium uppercase tracking-wide text-indigo-600">Employer Dashboard</p>
				<h1 class="mt-1 text-3xl font-bold text-slate-950">Welcome back, {{ $user->name }}</h1>
				<p class="mt-2 text-sm text-slate-600">Track your posted jobs and manage listings from one place.</p>
			</div>

			<x-button
				href="{{ route('jobs.create') }}"
				icon="fa-solid fa-plus"
				size="small"
			>
				Post a Job
			</x-button>
		</div>

		<div class="mb-10 grid gap-5 sm:grid-cols-2">
			<div
				class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
			>
				<div class="flex items-center gap-4">
					<div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
						<i class="fa-solid fa-briefcase text-xl"></i>
					</div>
					<div>
						<p class="text-sm font-medium text-slate-500">Posted Jobs</p>
						<p class="mt-1 text-3xl font-bold text-slate-900">{{ $postedJobsCount }}</p>
					</div>
				</div>
			</div>

			<div
				class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
			>
				<div class="flex items-center gap-4">
					<div class="flex h-12 w-12 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
						<i class="fa-solid fa-users text-xl"></i>
					</div>
					<div>
						<p class="text-sm font-medium text-slate-500">Total Applicants</p>
						<p class="mt-1 text-3xl font-bold text-slate-900">{{ $totalApplicantsCount }}</p>
					</div>
				</div>
			</div>
		</div>

		<div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
			<div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
				<div>
					<h2 class="text-xl font-bold text-slate-950">My Listings</h2>
					<p class="mt-1 text-sm text-slate-600">Review, edit, or remove jobs you have posted.</p>
				</div>
			</div>

			@if ($jobs->isEmpty())
				<div class="px-6 py-12 text-center">
					<div class="mx-auto flex h-14 w-14 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
						<i class="fa-solid fa-briefcase text-xl"></i>
					</div>
					<h3 class="mt-4 text-base font-semibold text-slate-950">No listings yet</h3>
					<p class="mt-1 text-sm text-slate-600">Your posted jobs will appear here.</p>
					<x-button
						href="{{ route('jobs.create') }}"
						icon="fa-solid fa-plus"
						size="small"
						class="mt-5"
						rounded="rounded-sm"
					>
						Create Listing
					</x-button>
				</div>
			@else
				<div class="divide-y divide-slate-200">
					@foreach ($jobs as $job)
						<div class="grid gap-4 px-6 py-5 md:grid-cols-[1fr_auto] md:items-center">
							<div class="min-w-0">
								<div class="flex flex-wrap items-center gap-2">
									<h3 class="truncate text-base font-semibold text-slate-950">{{ $job->title }}</h3>
									<span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">
										{{ $job->job_type }}
									</span>
									@if ($job->remote)
										<span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700">
											Remote
										</span>
									@endif
								</div>
								<div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-slate-600">
									<span>
										<i class="fa-solid fa-building mr-1 text-slate-400"></i>
										{{ $job->company_name }}
									</span>
									<span>
										<i class="fa-solid fa-location-dot mr-1 text-slate-400"></i>
										{{ trim(($job->city ?: '') . ', ' . ($job->state ?: ''), ', ') ?: 'N/A' }}
									</span>
									<span>
										<i class="fa-solid fa-calendar mr-1 text-slate-400"></i>
										Posted {{ $job->created_at->format('M d, Y') }}
									</span>
								</div>
							</div>

							<div class="flex flex-wrap items-center gap-2 md:justify-end">
								<a
									href="{{ route('jobs.show', $job) }}"
									class="inline-flex items-center gap-2 rounded-md border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
								>
									<i class="fa-solid fa-eye"></i>
									View
								</a>
								<a
									href="{{ route('jobs.edit', $job) }}"
									class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700"
								>
									<i class="fa-solid fa-pen"></i>
									Edit
								</a>
								<form
									id="delete-job-form-{{ $job->id }}"
									action="{{ route('jobs.destroy', $job) }}?from=dashboard"
									method="POST"
								>
									@csrf
									@method('DELETE')
									<button
										type="button"
										@click="deleteFormId = 'delete-job-form-{{ $job->id }}'; confirmDelete = true"
										class="inline-flex items-center gap-2 rounded-md bg-rose-600 px-3 py-2 text-sm font-medium text-white hover:bg-rose-700"
									>
										<i class="fa-solid fa-trash"></i>
										Delete
									</button>
								</form>
							</div>
						</div>
					@endforeach
				</div>
			@endif
		</div>

		<div
			x-show="confirmDelete"
			x-cloak
			x-transition.opacity
			class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4"
		>
			<div
				@click.away="confirmDelete = false"
				x-transition
				class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-6 shadow-xl"
			>
				<h3 class="text-lg font-semibold text-slate-900">Delete this job?</h3>
				<p class="mt-2 text-sm text-slate-600">
					This action cannot be undone. Are you sure you want to delete this job listing?
				</p>
				<div class="mt-6 flex items-center justify-end gap-3">
					<button
						type="button"
						@click="confirmDelete = false; deleteFormId = null"
						class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200"
					>
						Cancel
					</button>
					<button
						type="button"
						@click="document.getElementById(deleteFormId).submit()"
						class="inline-flex items-center rounded-md bg-rose-600 px-4 py-2 text-sm font-medium text-white hover:bg-rose-700"
					>
						Yes, Delete
					</button>
				</div>
			</div>
		</div>
	</div>
	<x-bottom-banner />
</x-layout>
