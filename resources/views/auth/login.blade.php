<x-layout>
	<x-slot name="title">Login</x-slot>

	<div class="py-10">
		<div class="mx-auto w-full max-w-lg rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
			<div class="mb-6">
				<h1 class="text-2xl font-bold text-slate-900">Welcome back</h1>
				<p class="mt-1 text-sm text-slate-600">Log in to continue managing your jobs.</p>
			</div>

			<form
				action="{{ route('login.authenticate') }}"
				method="POST"
				class="space-y-4"
			>
				@csrf

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
					placeholder="Enter your password"
				/>

				<x-button
					type="submit"
					variant="primary"
					class="w-full"
				>
					Login
				</x-button>
			</form>

			<p class="mt-5 text-center text-sm text-slate-600">
				Don&apos;t have an account?
				<a
					href="{{ route('register') }}"
					class="font-medium text-indigo-600 hover:text-indigo-700"
				>
					Register
				</a>
			</p>
		</div>
	</div>
</x-layout>
