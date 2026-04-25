@php
	$user = auth()->user();
@endphp

<header
	x-data="{ mobileOpen: false, jobsDropdown: false, profileDropdown: false, profileModal: {{ $errors->has('name') || $errors->has('email') || $errors->has('avatar') ? 'true' : 'false' }} }"
	@keydown.escape.window="mobileOpen = false; jobsDropdown = false; profileDropdown = false; profileModal = false"
	class="sticky top-0 z-50 border-b border-slate-800 bg-slate-950/95 shadow-lg backdrop-blur-md"
>

	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="flex h-16 items-center justify-between">

			<!-- Left -->
			<div class="flex items-center gap-10">
				<!-- Logo -->
				<a
					href="{{ url('/') }}"
					class="group flex items-center gap-3"
				>
					<div
						class="bg-linear-to-br flex h-10 w-10 items-center justify-center rounded-xl from-indigo-500 via-purple-500 to-pink-500 text-lg font-bold text-white shadow-md"
					>
						W
					</div>
					<div class="leading-tight">
						<span class="block text-lg font-bold text-white transition group-hover:text-indigo-400">
							Workopia
						</span>
						<span class="block text-[11px] text-slate-400">
							Find your next opportunity
						</span>
					</div>
				</a>

				<!-- Desktop Navigation -->
				<nav class="hidden items-center gap-6 lg:flex">
					<x-nav-link
						url="/"
						:active="request()->is('/')"
						icon="home"
					>Home</x-nav-link>
					<x-nav-link
						url="/jobs"
						:active="request()->is('/jobs')"
						icon="briefcase"
					>Browse Jobs</x-nav-link>

					<!-- Dropdown -->
					<div class="relative">
						<button
							@click="jobsDropdown = !jobsDropdown; profileDropdown = false"
							:aria-expanded="jobsDropdown.toString()"
							aria-controls="jobs-dropdown-menu"
							aria-label="Toggle categories dropdown"
							class="flex items-center gap-2 text-sm font-medium text-slate-300 transition hover:text-white"
						>
							Categories
							<i class="fa-solid fa-chevron-down text-xs"></i>
						</button>

						<div
							id="jobs-dropdown-menu"
							x-show="jobsDropdown"
							@click.away="jobsDropdown = false"
							x-transition
							x-cloak
							class="absolute left-0 mt-3 w-56 overflow-hidden rounded-xl border border-slate-800 bg-slate-900 shadow-xl"
						>
							<a
								href="{{ url('/jobs?category=tech') }}"
								class="block px-4 py-3 text-sm text-slate-300 hover:bg-slate-800 hover:text-white"
							>
								Tech Jobs
							</a>
							<a
								href="{{ url('/jobs?category=design') }}"
								class="block px-4 py-3 text-sm text-slate-300 hover:bg-slate-800 hover:text-white"
							>
								Design Jobs
							</a>
							<a
								href="{{ url('/jobs?category=marketing') }}"
								class="block px-4 py-3 text-sm text-slate-300 hover:bg-slate-800 hover:text-white"
							>
								Marketing Jobs
							</a>
							<a
								href="{{ url('/jobs?category=remote') }}"
								class="block px-4 py-3 text-sm text-slate-300 hover:bg-slate-800 hover:text-white"
							>
								Remote Jobs
							</a>
						</div>
					</div>

					<x-nav-link
						url="/companies"
						:active="request()->is('/companies')"
					>Companies</x-nav-link>
					<x-nav-link
						url="/about"
						:active="request()->is('/about')"
					>About</x-nav-link>

				</nav>
			</div>

			<!-- Right -->
			<div class="hidden items-center gap-4 lg:flex">
				<!-- Notification -->
				<button
					class="relative rounded-xl border border-slate-800 bg-slate-900 p-2.5 text-slate-300 transition hover:border-slate-700 hover:text-white"
				>
					<i class="fa-regular fa-bell text-base"></i>
					<span class="absolute right-1.5 top-1.5 h-2.5 w-2.5 rounded-full bg-pink-500"></span>
				</button>

				@guest
					<!-- Guest Buttons -->
					<x-button
						href="{{ url('/login') }}"
						variant="ghost"
					>
						Login
					</x-button>
					<x-button
						href="{{ url('/register') }}"
						variant="primary"
					>
						Register
					</x-button>
				@endguest

				@auth

					<x-button
						href="{{ url('/jobs/create') }}"
						variant="primary"
					>
						Post a Job
					</x-button>

					<!-- Profile Dropdown -->
					<div class="relative">
						<button
							@click="profileDropdown = !profileDropdown; jobsDropdown = false"
							:aria-expanded="profileDropdown.toString()"
							aria-controls="profile-dropdown-menu"
							aria-label="Toggle profile dropdown"
							class="flex items-center gap-3 rounded-xl border border-slate-800 bg-slate-900 px-3 py-2 transition hover:border-slate-700"
						>
							<img
								src="{{ $user->avatar ?: 'https://i.pravatar.cc/40?img=12' }}"
								alt="User"
								class="h-8 w-8 rounded-full object-cover"
							>
							<div class="text-left">
								<p class="text-sm font-medium text-white">{{ $user->name }}</p>
								<p class="text-xs text-slate-400">Employer</p>
							</div>
							<i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
						</button>

						<div
							id="profile-dropdown-menu"
							x-show="profileDropdown"
							@click.away="profileDropdown = false"
							x-transition
							x-cloak
							class="absolute right-0 mt-3 w-56 overflow-hidden rounded-xl border border-slate-800 bg-slate-900 shadow-xl"
						>
							<a
								href="{{ url('/dashboard') }}"
								class="flex items-center gap-3 px-4 py-3 text-sm text-slate-300 hover:bg-slate-800 hover:text-white"
							>
								<i class="fa-solid fa-table-columns w-4 text-center"></i>
								<span>Dashboard</span>
							</a>

							<button
								type="button"
								@click="profileModal = true; profileDropdown = false"
								class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm text-slate-300 hover:bg-slate-800 hover:text-white"
							>
								<i class="fa-regular fa-user w-4 text-center"></i>
								<span>My Profile</span>
							</button>

							<a
								href="{{ url('/applications') }}"
								class="flex items-center gap-3 px-4 py-3 text-sm text-slate-300 hover:bg-slate-800 hover:text-white"
							>
								<i class="fa-regular fa-file-lines w-4 text-center"></i>
								<span>Applications</span>
							</a>

							<a
								href="{{ url('/settings') }}"
								class="flex items-center gap-3 px-4 py-3 text-sm text-slate-300 hover:bg-slate-800 hover:text-white"
							>
								<i class="fa-solid fa-gear w-4 text-center"></i>
								<span>Settings</span>
							</a>

							<div class="border-t border-slate-800"></div>

							<x-logout-button />
						</div>
					</div>
				@endauth
			</div>

			<!-- Mobile button -->
			<button
				@click="mobileOpen = !mobileOpen"
				:aria-expanded="mobileOpen.toString()"
				aria-controls="mobile-menu"
				aria-label="Toggle navigation menu"
				class="inline-flex items-center justify-center rounded-xl p-2 text-slate-300 transition hover:bg-slate-800 hover:text-white lg:hidden"
			>
				<i
					x-show="!mobileOpen"
					x-cloak
					class="fa-solid fa-bars text-lg"
				></i>
				<i
					x-show="mobileOpen"
					x-cloak
					class="fa-solid fa-xmark text-lg"
				></i>
			</button>
		</div>
	</div>

	<!-- Mobile menu -->
	<div
		id="mobile-menu"
		x-show="mobileOpen"
		x-transition.origin.top
		x-cloak
		@click.away="mobileOpen = false"
		class="border-t border-slate-800 bg-slate-950 lg:hidden"
	>
		<div class="space-y-3 px-4 py-4">
			<x-nav-link
				url="/"
				:active="request()->is('/')"
				:block="true"
			>
				Home
			</x-nav-link>

			<x-nav-link
				url="/jobs"
				:active="request()->is('jobs')"
				:block="true"
			>
				Browse Jobs
			</x-nav-link>

			<x-nav-link
				url="/companies"
				:active="request()->is('companies')"
				:block="true"
			>
				Companies
			</x-nav-link>

			<x-nav-link
				url="/about"
				:active="request()->is('about')"
				:block="true"
			>
				About
			</x-nav-link>

			<div class="flex flex-col gap-2 border-t border-slate-800 pt-4">
				@guest
					<x-button
						href="{{ url('/login') }}"
						variant="outline"
						class="w-full"
					>
						Login
					</x-button>
					<x-button
						href="{{ url('/register') }}"
						variant="primary"
						class="w-full"
					>
						Register
					</x-button>
				@endguest

				@auth
					<x-button
						href="{{ url('/jobs/create') }}"
						variant="primary"
						class="w-full"
					>
						Post a Job
					</x-button>
					<x-logout-button :mobile="true" />
				@endauth
			</div>
		</div>
	</div>

	<template x-teleport="body">
		@auth
			<div
				x-show="profileModal"
				x-cloak
				x-transition.opacity
				class="z-100 fixed inset-0 flex items-center justify-center bg-slate-950/70 p-4"
			>
				<div
					@click.away="profileModal = false"
					x-transition
					class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-6 shadow-2xl"
				>
					<div class="mb-5 flex items-start justify-between gap-4">
						<div>
							<h2 class="text-xl font-bold text-slate-950">My Profile</h2>
							<p class="mt-1 text-sm text-slate-600">Update your account information.</p>
						</div>
						<button
							type="button"
							@click="profileModal = false"
							class="rounded-md p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800"
							aria-label="Close profile modal"
						>
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>

					@if ($user->avatar)
						<img
							src="{{ asset($user->avatar) }}"
							alt="{{ $user->name }} avatar"
							class="mb-4 h-16 w-16 rounded-full object-cover"
						>
					@endif
					<form
						action="{{ route('profile.update') }}"
						method="POST"
						enctype="multipart/form-data"
						class="space-y-4"
					>
						@csrf
						@method('PUT')

						<x-inputs.text
							id="profile-name"
							name="name"
							value="{{ old('name', $user->name) }}"
							placeholder="Enter Name"
							label="Name *"
						/>

						<x-inputs.text
							id="profile-email"
							name="email"
							type="email"
							value="{{ old('email', $user->email) }}"
							placeholder="Enter Email"
							label="Email *"
						/>

						<x-inputs.file
							id="avatar"
							name="avatar"
							label="Upload Avatar"
						/>

						<div class="flex items-center justify-end gap-3 pt-2">
							<button
								type="button"
								@click="profileModal = false"
								class="inline-flex items-center rounded-md bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200"
							>
								Cancel
							</button>
							<button
								type="submit"
								class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
							>
								<i class="fa-solid fa-floppy-disk"></i>
								Save
							</button>
						</div>
					</form>
				</div>
			</div>
		@endauth
	</template>
</header>
