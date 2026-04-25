<form
	action="{{ route('logout') }}"
	method="POST"
	class="{{ $mobile ? 'w-full' : '' }}"
>
	@csrf

	@if ($mobile)
		<x-button
			type="submit"
			variant="outline"
			class="w-full"
		>
			Logout
		</x-button>
	@else
		<button
			type="submit"
			class="flex w-full items-center gap-3 px-4 py-3 text-sm text-red-400 hover:bg-slate-800"
		>
			<i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
			<span>Logout</span>
		</button>
	@endif
</form>
