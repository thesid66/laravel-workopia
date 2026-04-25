<x-layout>
	<x-slot name="title">Edit Job Listing</x-slot>

	<div class="py-8">
		<div class="mx-auto max-w-4xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
			<h1 class="mb-6 text-2xl font-bold text-slate-900">Edit Job Listing</h1>

			<form
				action="{{ route('jobs.update', $job->id) }}"
				method="POST"
				enctype="multipart/form-data"
				class="space-y-6"
			>
				@csrf
				@method('PUT')

				<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
					<x-inputs.text
						div_class="md:col-span-2"
						id="title"
						name="title"
						label="Job Title *"
						:value="old('title', $job->title)"
						placeholder="Enter Job Title"
					/>
					<x-inputs.text-area
						id="description"
						name="description"
						label="Description *"
						:value="old('description', $job->description)"
						placeholder="Description"
						rows="4"
					/>

					<x-inputs.text
						div_class=""
						id="salary"
						name="salary"
						label="Salary (NPR) *"
						:value="old('salary', $job->salary)"
						placeholder="Enter Salary (NPR)"
						type="number"
					/>
					<x-inputs.select
						id="job_type"
						name="job_type"
						label="Job Type *"
						:value="old('job_type', $job->job_type)"
						:options="[
						    '' => '',
						    'Full-Time' => 'Full-Time',
						    'Part-Time' => 'Part-Time',
						    'Contract' => 'Contract',
						    'Temporary' => 'Temporary',
						    'Internship' => 'Internship',
						    'Volunteer' => 'Volunteer',
						    'On-Call' => 'On-Call'
						]"
					/>

					<x-inputs.text
						div_class="md:col-span-2"
						id="tags"
						name="tags"
						label="Tags"
						:value="old('tags', $job->tags)"
						placeholder="Laravel, PHP, MySQL"
					/>

					<x-inputs.text
						id="city"
						name="city"
						label="City *"
						:value="old('city', $job->city)"
						placeholder="Enter City"
					/>

					<x-inputs.text
						id="state"
						name="state"
						label="State *"
						:value="old('state', $job->state)"
						placeholder="Enter State"
					/>

					<x-inputs.text
						id="zipcode"
						name="zipcode"
						label="Zipcode"
						:value="old('zipcode', $job->zipcode)"
						placeholder="Enter Zipcode"
					/>

					<x-inputs.select
						id="remote"
						name="remote"
						label="Work Mode *"
						:value="old('remote', $job->remote)"
						:options="[0 => 'On-site', 1 => 'Remote']"
					/>

					<x-inputs.text-area
						id="address"
						name="address"
						label="Address"
						:value="old('address', $job->address)"
						placeholder="Address"
						rows="2"
					/>

					<x-inputs.text-area
						id="requirements"
						name="requirements"
						label="Requirements"
						:value="old('requirements', $job->requirements)"
						placeholder="Requirements"
						rows="3"
					/>

					<x-inputs.text-area
						id="benefits"
						name="benefits"
						label="Benefits"
						:value="old('benefits', $job->beneffits)"
						placeholder="Benefits"
						rows="3"
					/>

					<div class="border-t border-slate-200 pt-4 md:col-span-2">
						<h2 class="mb-3 text-lg font-semibold text-slate-900">Company Details</h2>
					</div>

					<x-inputs.text
						id="company_name"
						name="company_name"
						label="Company Name *"
						:value="old('company_name', $job->company_name)"
						placeholder="Enter Company Name"
					/>

					<x-inputs.text
						id="company_website"
						name="company_website"
						label="Company Website"
						:value="old('company_website', $job->company_website)"
						placeholder="Enter Company Website"
						type="url"
					/>

					<x-inputs.text
						id="contact_email"
						name="contact_email"
						label="Contact Email *"
						:value="old('contact_email', $job->contact_email)"
						placeholder="Enter Contact Email"
						type="email"
					/>

					<x-inputs.text
						id="contact_phone"
						name="contact_phone"
						label="Contact Phone *"
						:value="old('contact_phone', $job->contact_phone)"
						placeholder="Enter Contact Phone"
						type="tel"
					/>

					<x-inputs.text-area
						id="company_description"
						name="company_description"
						label="Company Description"
						:value="old('company_description', $job->company_description)"
						placeholder="Company Description"
						rows="3"
					/>

					<x-inputs.file
						id="company_logo"
						name="company_logo"
						label="Company Logo"
						:value="old('company_logo', $job->company_logo)"
						div_class="md:col-span-2"
					/>

				</div>

				<div class="flex flex-wrap gap-3 pt-2">
					<button
						type="submit"
						class="inline-flex items-center rounded-md bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700"
					>
						Update Job
					</button>
					<a
						href="{{ route('jobs.index') }}"
						class="inline-flex items-center rounded-md bg-slate-100 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-200"
					>
						Cancel
					</a>
				</div>
			</form>
		</div>
	</div>
</x-layout>
