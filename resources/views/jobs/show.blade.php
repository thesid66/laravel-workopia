<x-layout>
	<x-slot name="title">{{ $job->title }}</x-slot>

	<div
		x-data="{ confirmDelete: false }"
		@keydown.escape.window="confirmDelete = false"
		class="py-8"
	>
		<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
			<div class="space-y-6 lg:col-span-2">
				<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
					<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
						<a
							href="{{ route('jobs.index') }}"
							class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200"
						>
							Back to Listings
						</a>
						@can('update', $job)
							<div class="flex items-center gap-2">
								<a
									href="{{ route('jobs.edit', $job) }}"
									class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
								>
									Edit
								</a>

								<form
									id="delete-job-form-{{ $job->id }}"
									action="{{ route('jobs.destroy', $job) }}"
									method="POST"
								>
									@csrf
									@method('DELETE')
									<button
										type="button"
										@click="confirmDelete = true"
										class="inline-flex items-center rounded-md bg-rose-600 px-4 py-2 text-sm font-medium text-white hover:bg-rose-700"
									>
										Delete
									</button>
								</form>
							</div>
						@endcan
					</div>

					<h1 class="mb-3 text-3xl font-bold text-slate-900">{{ $job->title }}</h1>
					<p class="mb-6 text-slate-700">{{ $job->description }}</p>

					<div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
						<div class="rounded-lg bg-slate-100 px-4 py-3">
							<p class="text-xs uppercase tracking-wide text-slate-500">Job Type</p>
							<p class="text-sm font-semibold text-slate-800">{{ $job->job_type ?: 'N/A' }}</p>
						</div>
						<div class="rounded-lg bg-slate-100 px-4 py-3">
							<p class="text-xs uppercase tracking-wide text-slate-500">Work Mode</p>
							<p class="text-sm font-semibold text-slate-800">{{ $job->remote ? 'Remote' : 'On-site' }}</p>
						</div>
						<div class="rounded-lg bg-slate-100 px-4 py-3">
							<p class="text-xs uppercase tracking-wide text-slate-500">Location</p>
							<p class="text-sm font-semibold text-slate-800">
								{{ trim(($job->city ?: '') . ', ' . ($job->state ?: ''), ', ') ?: 'N/A' }}
							</p>
						</div>
						<div class="rounded-lg bg-slate-100 px-4 py-3">
							<p class="text-xs uppercase tracking-wide text-slate-500">Salary</p>
							<p class="text-sm font-semibold text-slate-800">
								{{ $job->salary ? 'Rs. ' . number_format($job->salary) : 'N/A' }}
							</p>
						</div>
					</div>
				</div>

				<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
					<h2 class="mb-4 text-xl font-semibold text-slate-900">Job Details</h2>

					<div class="space-y-5">
						@if ($job->requirements)
							<div>
								<h3 class="mb-1 text-sm font-semibold uppercase tracking-wide text-slate-500">Requirements</h3>
								<p class="text-slate-700">{{ $job->requirements ?: 'No requirements listed.' }}</p>
							</div>
						@endif

						@if ($job->benefits)
							<div>
								<h3 class="mb-1 text-sm font-semibold uppercase tracking-wide text-slate-500">Benefits</h3>
								<p class="text-slate-700">{{ $job->benefits ?: 'No benefits listed.' }}</p>
							</div>
						@endif

						@if ($job->tags)
							<div>
								<h3 class="mb-1 text-sm font-semibold uppercase tracking-wide text-slate-500">Tags</h3>
								<p class="text-slate-700">{{ $job->tags ?: 'No tags provided.' }}</p>
							</div>
						@endif

						<div>
							<h3 class="mb-1 text-sm font-semibold uppercase tracking-wide text-slate-500">Address</h3>
							<p class="text-slate-700">
								{{ trim(($job->address ?: '') . ', ' . ($job->city ?: '') . ', ' . ($job->state ?: '') . ' ' . ($job->zipcode ?: '')) ?: 'N/A' }}
							</p>
						</div>

						<div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
							<div class="rounded-lg bg-slate-100 px-4 py-3">
								<p class="text-xs uppercase tracking-wide text-slate-500">Contact Email</p>
								<p class="break-all text-sm font-medium text-slate-800">{{ $job->contact_email ?: 'N/A' }}</p>
							</div>
							@if ($job->contact_phone)
								<div class="rounded-lg bg-slate-100 px-4 py-3">
									<p class="text-xs uppercase tracking-wide text-slate-500">Contact Phone</p>
									<p class="text-sm font-medium text-slate-800">{{ $job->contact_phone ?: 'N/A' }}</p>
								</div>
							@endif

						</div>
					</div>
				</div>
			</div>

			<aside class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-1">
				<div>
					<h2 class="mb-4 text-xl font-semibold text-slate-900">Company Details</h2>

					<div class="mb-4 h-20 w-20 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
						@if (!empty($job->company_logo))
							<img
								src="{{ $job->company_logo }}"
								alt="{{ $job->company_name }} logo"
								class="h-full w-full object-contain"
							>
						@else
							<div class="flex h-full w-full items-center justify-center text-lg font-semibold text-slate-500">
								{{ strtoupper(substr($job->company_name ?? 'C', 0, 1)) }}
							</div>
						@endif
					</div>

					<div class="space-y-3">
						<div>
							<p class="text-xs uppercase tracking-wide text-slate-500">Company Name</p>
							<p class="text-sm font-semibold text-slate-800">{{ $job->company_name ?: 'N/A' }}</p>
						</div>

						<div>
							<p class="text-xs uppercase tracking-wide text-slate-500">Website</p>
							@if (!empty($job->company_website))
								<a
									href="{{ $job->company_website }}"
									target="_blank"
									rel="noopener noreferrer"
									class="break-all text-sm font-medium text-indigo-600 hover:text-indigo-700"
								>
									{{ $job->company_website }}
								</a>
							@else
								<p class="text-sm text-slate-700">N/A</p>
							@endif
						</div>
						@if ($job->company_description)
							<div>
								<p class="text-xs uppercase tracking-wide text-slate-500">Description</p>
								<p class="text-sm text-slate-700">{{ $job->company_description ?: 'No company description provided.' }}</p>
							</div>
						@endif

					</div>

					<a
						href=""
						class="mt-6 inline-flex w-full items-center justify-center rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-600"
					>
						<i class="fa fa-bookmark"></i>Add to Bookmark
					</a>
				</div>
			</aside>
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
						@click="confirmDelete = false"
						class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200"
					>
						Cancel
					</button>
					<button
						type="button"
						@click="document.getElementById('delete-job-form-{{ $job->id }}').submit()"
						class="inline-flex items-center rounded-md bg-rose-600 px-4 py-2 text-sm font-medium text-white hover:bg-rose-700"
					>
						Yes, Delete
					</button>
				</div>
			</div>
		</div>
	</div>
</x-layout>
