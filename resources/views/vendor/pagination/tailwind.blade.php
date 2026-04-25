@if ($paginator->hasPages())
	<nav
		role="navigation"
		aria-label="{{ __('Pagination Navigation') }}"
	>

		<div class="flex items-center justify-between gap-2 sm:hidden">

			@if ($paginator->onFirstPage())
				<span
					class="pagination-active inline-flex cursor-not-allowed items-center rounded-md border px-4 py-2 text-sm font-medium leading-5"
				>
					{!! __('pagination.previous') !!}
				</span>
			@else
				<a
					href="{{ $paginator->previousPageUrl() }}"
					rel="prev"
					class="pagination-link inline-flex items-center rounded-md border bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-800 transition duration-150 ease-in-out focus:outline-none"
				>
					{!! __('pagination.previous') !!}
				</a>
			@endif

			@if ($paginator->hasMorePages())
				<a
					href="{{ $paginator->nextPageUrl() }}"
					rel="next"
					class="pagination-link inline-flex items-center rounded-md border bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-800 transition duration-150 ease-in-out focus:outline-none"
				>
					{!! __('pagination.next') !!}
				</a>
			@else
				<span
					class="pagination-active inline-flex cursor-not-allowed items-center rounded-md border px-4 py-2 text-sm font-medium leading-5"
				>
					{!! __('pagination.next') !!}
				</span>
			@endif

		</div>

		<div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between sm:gap-2">

			<div>
				<p class="text-sm leading-5 text-gray-700">
					{!! __('Showing') !!}
					@if ($paginator->firstItem())
						<span class="font-medium">{{ $paginator->firstItem() }}</span>
						{!! __('to') !!}
						<span class="font-medium">{{ $paginator->lastItem() }}</span>
					@else
						{{ $paginator->count() }}
					@endif
					{!! __('of') !!}
					<span class="font-medium">{{ $paginator->total() }}</span>
					{!! __('results') !!}
				</p>
			</div>

			<div>
				<span class="inline-flex rounded-md shadow-sm rtl:flex-row-reverse">

					{{-- Previous Page Link --}}
					@if ($paginator->onFirstPage())
						<span
							aria-disabled="true"
							aria-label="{{ __('pagination.previous') }}"
						>
							<span
								class="pagination-active inline-flex cursor-not-allowed items-center rounded-l-md border px-2 py-2 text-sm font-medium leading-5"
								aria-hidden="true"
							>
								<svg
									class="h-5 w-5"
									fill="currentColor"
									viewBox="0 0 20 20"
								>
									<path
										fill-rule="evenodd"
										d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
										clip-rule="evenodd"
									/>
								</svg>
							</span>
						</span>
					@else
						<a
							href="{{ $paginator->previousPageUrl() }}"
							rel="prev"
							class="pagination-link inline-flex items-center rounded-l-md border bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out focus:outline-none"
							aria-label="{{ __('pagination.previous') }}"
						>
							<svg
								class="h-5 w-5"
								fill="currentColor"
								viewBox="0 0 20 20"
							>
								<path
									fill-rule="evenodd"
									d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
									clip-rule="evenodd"
								/>
							</svg>
						</a>
					@endif

					{{-- Pagination Elements --}}
					@foreach ($elements as $element)
						{{-- "Three Dots" Separator --}}
						@if (is_string($element))
							<span aria-disabled="true">
								<span
									class="-ml-px inline-flex cursor-default items-center border bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700"
								>{{ $element }}</span>
							</span>
						@endif

						{{-- Array Of Links --}}
						@if (is_array($element))
							@foreach ($element as $page => $url)
								@if ($page == $paginator->currentPage())
									<span aria-current="page">
										<span
											class="pagination-active -ml-px inline-flex cursor-default items-center border px-4 py-2 text-sm font-medium leading-5"
										>{{ $page }}</span>
									</span>
								@else
									<a
										href="{{ $url }}"
										class="pagination-link -ml-px inline-flex items-center border bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out focus:outline-none"
										aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
									>
										{{ $page }}
									</a>
								@endif
							@endforeach
						@endif
					@endforeach

					{{-- Next Page Link --}}
					@if ($paginator->hasMorePages())
						<a
							href="{{ $paginator->nextPageUrl() }}"
							rel="next"
							class="pagination-link -ml-px inline-flex items-center rounded-r-md border bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out focus:outline-none"
							aria-label="{{ __('pagination.next') }}"
						>
							<svg
								class="h-5 w-5"
								fill="currentColor"
								viewBox="0 0 20 20"
							>
								<path
									fill-rule="evenodd"
									d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
									clip-rule="evenodd"
								/>
							</svg>
						</a>
					@else
						<span
							aria-disabled="true"
							aria-label="{{ __('pagination.next') }}"
						>
							<span
								class="pagination-active -ml-px inline-flex cursor-not-allowed items-center rounded-r-md border px-2 py-2 text-sm font-medium leading-5"
								aria-hidden="true"
							>
								<svg
									class="h-5 w-5"
									fill="currentColor"
									viewBox="0 0 20 20"
								>
									<path
										fill-rule="evenodd"
										d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
										clip-rule="evenodd"
									/>
								</svg>
							</span>
						</span>
					@endif
				</span>
			</div>
		</div>
	</nav>
@endif
