@props(['job'])

<div class="rounded-xl border border-slate-200 bg-white p-5">
	<div class="mb-4 flex items-start justify-between gap-3">
		<div class="flex items-start gap-3">
			<div class="h-12 w-12 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
				@if (!empty($job->company_logo))
					<img
						src="{{ $job->company_logo }}"
						alt="{{ $job->company_name }} logo"
						class="h-full w-full object-contain"
					/>
				@else
					<div class="flex h-full w-full items-center justify-center text-sm font-semibold text-slate-600">
						{{ strtoupper(substr($job->company_name ?? 'C', 0, 1)) }}
					</div>
				@endif
			</div>

			<div class="flex flex-col items-start">
				<h3 class="text-lg font-semibold text-slate-900">{{ $job->title }}</h3>
				<p class="rounded-xl bg-blue-300 px-2 py-1 text-xs text-slate-900">{{ $job->job_type }}</p>
			</div>
		</div>

	</div>

	<p class="mb-4 line-clamp-2 text-sm text-slate-700">
		{{ $job->description }}
	</p>

	<div class="mb-4 space-y-1 rounded-xl bg-slate-200 p-4 text-sm text-slate-600">
		<p>Company: <span class="font-medium text-slate-800">{{ $job->company_name }}</span></p>
		<p>Location: <span class="font-medium text-slate-800">{{ $job->city }}, {{ $job->state }}</span></p>
		<p>Salary: <span class="font-medium text-slate-800">Rs. {{ number_format($job->salary) }}</span></p>
		@if ($job->tags)
			<p>Tags: <span class="font-medium text-slate-800"> {{ $job->tags }}</span></p>
		@endif
	</div>

	<div class="flex items-center justify-between">

		<span
			class="{{ $job->remote ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }} rounded-md px-2.5 py-1 text-xs font-medium"
		>
			{{ $job->remote ? 'Remote' : 'On-site' }}
		</span>
		<a
			href="/jobs/{{ $job->id }}"
			class="text-sm font-medium text-indigo-600 hover:text-indigo-700"
		>
			View Details
		</a>
	</div>
</div>
