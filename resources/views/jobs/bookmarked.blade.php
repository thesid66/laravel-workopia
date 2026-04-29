<x-layout>
	<x-slot name="title">Saved Jobs | Workopia</x-slot>

	@php
		$visibleBookmarks = $bookmarks->getCollection();
		$remoteCount = $visibleBookmarks->where('remote', true)->count();
		$newestBookmark = $visibleBookmarks->sortByDesc('created_at')->first();
	@endphp

	<section class="py-8 sm:py-10">
		<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
			<div>
				<p class="text-sm font-medium uppercase tracking-wide text-indigo-600">Saved Jobs</p>
				<h1 class="mt-1 text-3xl font-bold text-slate-950">Your bookmarked opportunities</h1>
				<p class="mt-2 max-w-2xl text-sm text-slate-600">
					Keep track of roles you want to revisit and compare before applying.
				</p>
			</div>

			<x-button
				href="{{ route('jobs.index') }}"
				icon="fa-solid fa-magnifying-glass"
				size="small"
				rounded="rounded-md"
			>
				Browse Jobs
			</x-button>
		</div>

		<div class="mb-8 grid gap-4 sm:grid-cols-3">
			<div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
				<div class="flex items-center gap-4">
					<div class="flex h-11 w-11 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
						<i class="fa-solid fa-bookmark"></i>
					</div>
					<div>
						<p class="text-sm font-medium text-slate-500">Total Saved</p>
						<p class="mt-1 text-2xl font-bold text-slate-950">{{ $bookmarks->total() }}</p>
					</div>
				</div>
			</div>

			<div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
				<div class="flex items-center gap-4">
					<div class="flex h-11 w-11 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
						<i class="fa-solid fa-house-laptop"></i>
					</div>
					<div>
						<p class="text-sm font-medium text-slate-500">Remote On This Page</p>
						<p class="mt-1 text-2xl font-bold text-slate-950">{{ $remoteCount }}</p>
					</div>
				</div>
			</div>

			<div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
				<div class="flex items-center gap-4">
					<div class="flex h-11 w-11 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
						<i class="fa-solid fa-clock"></i>
					</div>
					<div>
						<p class="text-sm font-medium text-slate-500">Newest Listing</p>
						<p class="mt-1 text-sm font-semibold text-slate-950">
							{{ $newestBookmark?->created_at?->format('M d, Y') ?? 'No saved jobs yet' }}
						</p>
					</div>
				</div>
			</div>
		</div>

		@if ($bookmarks->count() === 0)
			<div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-14 text-center">
				<div class="mx-auto flex h-14 w-14 items-center justify-center rounded-lg bg-white text-slate-500 shadow-sm">
					<i class="fa-regular fa-bookmark text-xl"></i>
				</div>
				<h2 class="mt-4 text-lg font-semibold text-slate-950">No bookmarked jobs yet</h2>
				<p class="mx-auto mt-2 max-w-md text-sm text-slate-600">
					When you save jobs, they will show up here so you can quickly return to them.
				</p>
				<x-button
					href="{{ route('jobs.index') }}"
					icon="fa-solid fa-briefcase"
					size="small"
					class="mt-5"
					rounded="rounded-md"
				>
					Find Jobs
				</x-button>
			</div>
		@else
			<div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
				@foreach ($bookmarks as $job)
					<article
						class="flex h-full flex-col rounded-lg border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
					>
						<div class="mb-4 flex items-start gap-3">
							<div class="h-12 w-12 shrink-0 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
								@if (!empty($job->company_logo))
									<img
										src="{{ $job->company_logo }}"
										alt="{{ $job->company_name }} logo"
										class="h-full w-full object-contain"
									>
								@else
									<div class="flex h-full w-full items-center justify-center text-sm font-semibold text-slate-600">
										{{ strtoupper(substr($job->company_name ?? 'C', 0, 1)) }}
									</div>
								@endif
							</div>

							<div class="min-w-0">
								<h2 class="truncate text-lg font-semibold text-slate-950">{{ $job->title }}</h2>
								<p class="mt-1 truncate text-sm text-slate-600">{{ $job->company_name ?: 'Company unavailable' }}</p>
							</div>
						</div>

						<p class="mb-4 line-clamp-3 text-sm leading-6 text-slate-700">
							{{ $job->description }}
						</p>

						<div class="mb-5 grid gap-2 text-sm text-slate-600">
							<div class="flex items-center gap-2">
								<i class="fa-solid fa-location-dot w-4 text-center text-slate-400"></i>
								<span>{{ trim(($job->city ?: '') . ', ' . ($job->state ?: ''), ', ') ?: 'Location unavailable' }}</span>
							</div>
							<div class="flex items-center gap-2">
								<i class="fa-solid fa-money-bill-wave w-4 text-center text-slate-400"></i>
								<span>{{ $job->salary ? 'Rs. ' . number_format($job->salary) : 'Salary unavailable' }}</span>
							</div>
							<div class="flex items-center gap-2">
								<i class="fa-solid fa-calendar w-4 text-center text-slate-400"></i>
								<span>Posted {{ $job->created_at?->format('M d, Y') ?? 'recently' }}</span>
							</div>
						</div>

						<div class="mt-auto flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-4">
							<div class="flex flex-wrap gap-2">
								<span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">
									{{ $job->job_type ?: 'Job type' }}
								</span>
								<span
									class="{{ $job->remote ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }} rounded-full px-2.5 py-1 text-xs font-medium"
								>
									{{ $job->remote ? 'Remote' : 'On-site' }}
								</span>
							</div>

							<a
								href="{{ route('jobs.show', $job) }}"
								class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700"
							>
								<i class="fa-solid fa-eye"></i>
								View
							</a>
						</div>
					</article>
				@endforeach
			</div>

			<div class="mt-8">
				{{ $bookmarks->links() }}
			</div>
		@endif
	</section>
</x-layout>
