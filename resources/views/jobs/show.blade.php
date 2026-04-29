<x-layout>
	<x-slot name="title">{{ $job->title }}</x-slot>

	<div
		x-data="{ confirmDelete: false, confirmApplicantDelete: false, applicantDeleteFormId: null, applicantDeleteName: '' }"
		@keydown.escape.window="confirmDelete = false; confirmApplicantDelete = false"
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

				@guest()
					<div class="mt-10 w-full rounded-full bg-gray-200 px-4 py-2 font-bold text-gray-700">
						<i class="fas fa-info-circle mr-3"></i> You must be logged into apply for this job
					</div>
				@else
					@if ($job->applicants()->where('user_id', auth()->id())->exists())
						<div class="mt-10 w-full rounded-full bg-emerald-100 px-4 py-2 font-bold text-emerald-700">
							<i class="fas fa-check-circle mr-3"></i> Already Applied
						</div>
					@else
						<div
							x-data="{ applyModal: false }"
							@keydown.escape.window="applyModal = false"
						>
							<button
								type="button"
								@click="applyModal = true"
								class="block w-full cursor-pointer rounded border bg-indigo-100 px-5 py-2.5 text-center text-base font-medium text-indigo-700 shadow-sm hover:bg-indigo-200"
							>Apply now</button>
							<div
								x-show="applyModal"
								x-scroll-lock="applyModal"
								x-cloak
								x-transition.opacity
								@click.self="applyModal = false"
								class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4"
							>
								<div
									x-transition
									class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-6 shadow-xl"
								>
									<div class="flex items-start justify-between gap-4">
										<h3 class="text-lg font-semibold text-slate-900">Apply for {{ $job->title }}</h3>
										<button
											type="button"
											@click="applyModal = false"
											class="rounded-md p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800"
											aria-label="Close application modal"
										>
											<i class="fa-solid fa-xmark"></i>
										</button>
									</div>
									<p class="mb-2 mt-2 text-sm text-slate-600">
										{{ $job->description }}
									</p>
									<form
										method="post"
										enctype="multipart/form-data"
										class="space-y-4"
										action="{{ route('applicant.store', $job->id) }}"
									>
										@csrf
										<x-inputs.text
											id="full_name"
											name="full_name"
											label="Full Name"
											placeholder="Enter your fullname"
											:required="true"
										/>

										<x-inputs.text
											id="contact_email"
											name="contact_email"
											label="Email"
											placeholder="Enter your email"
										/>

										<x-inputs.text
											id="contact_phone"
											name="contact_phone"
											label="Phone *"
											placeholder="Enter you phone"
											:required="true"
										/>

										<x-inputs.text-area
											id="message"
											name="message"
											label="Message *"
											placeholder="Message"
											:required="true"
											rows="3"
										/>

										<x-inputs.text
											id="location"
											name="location"
											label="Location"
											placeholder="Enter you Location"
										/>

										<x-inputs.file
											id="resume_path"
											name="resume_path"
											label="Select your resume"
											required="true"
										/>

										<x-button
											type="submit"
											variant="primary"
											rounded="rounded-sm"
										>Submit</x-button>
									</form>
								</div>
							</div>
						</div>
					@endif
				@endguest
				@can('update', $job)

					<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
						<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
							<div>
								<h2 class="text-xl font-semibold text-slate-900">Applicants</h2>
								<p class="mt-1 text-sm text-slate-600">Review candidates who applied for this role.</p>
							</div>
							<span class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-semibold text-indigo-700">
								{{ $job->applicants->count() }} total
							</span>
						</div>

						<div class="space-y-5">
							@foreach ($job->applicants as $applicant)
								<div
									class="rounded-lg border border-slate-200 bg-slate-50 p-5 transition hover:border-indigo-200 hover:bg-white hover:shadow-sm"
								>
									<div class="flex flex-row gap-4 sm:flex-row sm:items-start sm:justify-between">
										<div class="min-w-0 space-y-2">
											<p class="text-base font-semibold text-slate-950">{{ $applicant->full_name }}</p>
											<p class="flex items-center gap-2 break-all text-sm text-slate-600">
												<i class="fa-regular fa-envelope w-4 text-slate-400"></i>
												{{ $applicant->contact_email }}
											</p>
											<p class="flex items-center gap-2 text-sm text-slate-600">
												<i class="fa-solid fa-phone w-4 text-slate-400"></i>
												{{ $applicant->contact_phone }}
											</p>
											@if ($applicant->location)
												<p class="flex items-center gap-2 text-sm text-slate-600">
													<i class="fa-solid fa-location-dot w-4 text-slate-400"></i>
													{{ $applicant->location }}
												</p>
											@endif
										</div>
										<div
											class="rounded-md border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-700 sm:max-w-sm"
										>
											{{ $applicant->message }}
										</div>
									</div>
									<div class="mt-4 flex flex-wrap items-center justify-end gap-2"><a
											href="{{ asset($applicant->resume_path) }}"
											download
											class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-2 py-1 text-sm font-medium text-white hover:bg-indigo-700"
										>
											<i class="fa-solid fa-download"></i>
											Download Resume
										</a>
										<form
											id="delete-applicant-form-{{ $applicant->id }}"
											action="{{ route('applicant.destroy', $applicant->id) }}"
											method="POST"
											@submit.prevent="applicantDeleteFormId = 'delete-applicant-form-{{ $applicant->id }}'; applicantDeleteName = @js($applicant->full_name); confirmApplicantDelete = true"
										>
											@csrf
											@method('DELETE')
											<button
												type="submit"
												class="inline-flex items-center gap-2 rounded-md bg-rose-600 px-2 py-1 text-sm font-medium text-white hover:bg-rose-700"
											>
												<i class="fa-solid fa-trash"></i>
												Delete
											</button>
										</form>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				@endcan
				<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
					<h2 class="mb-4 text-xl font-semibold text-slate-900">Job Location</h2>

					<div
						id="map"
						class="h-100 w-full rounded-sm"
					></div>
					<p
						id="map-status"
						class="mt-3 text-sm text-slate-500"
					>
						Loading job location...
					</p>

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

					@guest()
						<div class="mt-10 w-full rounded-full bg-gray-200 px-4 py-2 text-center font-bold text-gray-700">
							<i class="fas fa-info-circle mr-3"></i> You must be logged into bookmark a job
						</div>
					@else
						<form
							method="post"
							action="{{ auth()->user()->bookmarkedJobs()->where('job_id', $job->id)->exists() ? route('bookmarks.destroy', $job->id) : route('bookmarks.store', $job->id) }}"
						>
							@csrf
							@if (auth()->user()->bookmarkedJobs()->where('job_id', $job->id)->exists())
								@method('DELETE')
								<button
									type="submit"
									class="mt-6 inline-flex w-full items-center justify-center rounded-md bg-red-500 px-4 py-2 text-xs font-semibold text-white hover:bg-red-600"
								><i class="fa fa-bookmark"></i>Remove Bookmark</button>
							@else
								<button
									type="submit"
									class="mt-6 inline-flex w-full items-center justify-center rounded-md bg-amber-500 px-4 py-2 text-xs font-semibold text-white hover:bg-amber-600"
								><i class="fa fa-bookmark"></i>Add to Bookmark</button>
							@endif
						</form>
					@endguest
				</div>
			</aside>
		</div>

		<div
			x-show="confirmDelete"
			x-scroll-lock="confirmDelete"
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

		<div
			x-show="confirmApplicantDelete"
			x-scroll-lock="confirmApplicantDelete"
			x-cloak
			x-transition.opacity
			class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4"
		>
			<div
				@click.away="confirmApplicantDelete = false; applicantDeleteFormId = null; applicantDeleteName = ''"
				x-transition
				class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-6 shadow-xl"
			>
				<h3 class="text-lg font-semibold text-slate-900">Delete this applicant?</h3>
				<p class="mt-2 text-sm text-slate-600">
					Are you sure you want to delete <span
						class="font-semibold text-slate-900"
						x-text="applicantDeleteName"
					></span>'s application?
				</p>
				<div class="mt-6 flex items-center justify-end gap-3">
					<button
						type="button"
						@click="confirmApplicantDelete = false; applicantDeleteFormId = null; applicantDeleteName = ''"
						class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200"
					>
						Cancel
					</button>
					<button
						type="button"
						@click="document.getElementById(applicantDeleteFormId).submit()"
						class="inline-flex items-center rounded-md bg-rose-600 px-4 py-2 text-sm font-medium text-white hover:bg-rose-700"
					>
						Delete
					</button>
				</div>
			</div>
		</div>
	</div>

	@push('styles')
		@once
			<link
				href="https://api.mapbox.com/mapbox-gl-js/v3.21.0/mapbox-gl.css"
				rel="stylesheet"
			>
		@endonce
	@endpush

	@push('scripts')
		@once
			<script src="https://api.mapbox.com/mapbox-gl-js/v3.21.0/mapbox-gl.js"></script>
		@endonce

		<script>
			document.addEventListener('DOMContentLoaded', () => {
				const mapElement = document.getElementById('map');
				const statusElement = document.getElementById('map-status');
				const accessToken = @js(config('services.mapbox.token'));
				const geocodeUrl = @js(route('geocode'));
				const address = @js(trim(($job->address ?: '') . ', ' . ($job->city ?: '') . ', ' . ($job->state ?: '') . ' ' . ($job->zipcode ?: '')));

				const setStatus = (message) => {
					if (statusElement) {
						statusElement.textContent = message;
					}
				};

				if (!mapElement || typeof mapboxgl === 'undefined') {
					return;
				}

				if (!accessToken) {
					setStatus('Mapbox access token is missing.');
					return;
				}

				mapboxgl.accessToken = accessToken;

				const map = new mapboxgl.Map({
					container: mapElement,
					// Other Mapbox styles:
					// mapbox://styles/mapbox/streets-v12
					// mapbox://styles/mapbox/outdoors-v12
					// mapbox://styles/mapbox/light-v11
					// mapbox://styles/mapbox/dark-v11
					// mapbox://styles/mapbox/satellite-v9
					// mapbox://styles/mapbox/satellite-streets-v12
					// mapbox://styles/mapbox/navigation-day-v1
					// mapbox://styles/mapbox/navigation-night-v1
					style: 'mapbox://styles/mapbox/streets-v12',
					center: [85.3240, 27.7172],
					zoom: 9,
				});

				if (!address) {
					setStatus('No location details are available for this job.');
					return;
				}

				fetch(`${geocodeUrl}?address=${encodeURIComponent(address)}`)
					.then((response) => response.json())
					.then((data) => {
						const location = data.features?.[0];

						if (!location) {
							setStatus('No map results found for this address.');
							return;
						}

						const [longitude, latitude] = location.center;

						map.setCenter([longitude, latitude]);
						map.setZoom(14);

						const popupContent = document.createElement('div');
						popupContent.className = 'max-w-xs rounded-md bg-white text-sm text-slate-700';

						const popupTitle = document.createElement('p');
						popupTitle.className = 'mb-1 font-semibold text-slate-950';
						popupTitle.textContent = 'Job Location';

						const popupAddress = document.createElement('p');
						popupAddress.className = 'leading-5';
						popupAddress.textContent = address;

						popupContent.append(popupTitle, popupAddress);

						const popup = new mapboxgl.Popup({
							offset: 25,
							focusAfterOpen: false,
						}).setDOMContent(popupContent);

						new mapboxgl.Marker()
							.setLngLat([longitude, latitude])
							.setPopup(popup)
							.addTo(map);

						popup.addTo(map);
						setStatus('Map location is approximate and based on the listed address.');
					})
					.catch(() => {
						setStatus('Error geocoding address.');
					});
			});
		</script>
	@endpush
</x-layout>
