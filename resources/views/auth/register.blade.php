<x-layout>
	<x-slot name="title">Create Account</x-slot>

	<div class="py-10">
		<div class="mx-auto w-full max-w-lg rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
			<div class="mb-6">
				<h1 class="text-2xl font-bold text-slate-900">Create your account</h1>
				<p class="mt-1 text-sm text-slate-600">Join Workopia to post and manage job listings.</p>
			</div>

			<form
				action="{{ route('register.store') }}"
				method="POST"
				class="space-y-4"
			>
				@csrf

				<x-inputs.text
					id="name"
					name="name"
					label="Full Name"
					:value="old('name')"
					placeholder="Enter your full name"
				/>

				<x-inputs.text
					id="email"
					name="email"
					type="email"
					label="Email Address"
					:value="old('email')"
					placeholder="you@example.com"
				/>

				<x-inputs.text
					id="password"
					name="password"
					type="password"
					label="Password"
					placeholder="Create a strong password"
				/>

				<x-inputs.text
					id="password_confirmation"
					name="password_confirmation"
					type="password"
					label="Confirm Password"
					placeholder="Re-enter your password"
				/>

				<x-button
					type="submit"
					variant="primary"
					class="w-full"
				>
					Register
				</x-button>
			</form>

			<p class="mt-5 text-center text-sm text-slate-600">
				Already have an account?
				<a
					href="{{ route('login') }}"
					class="font-medium text-indigo-600 hover:text-indigo-700"
				>
					Log in
				</a>
			</p>
		</div>
	</div>
</x-layout>
