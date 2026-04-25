@props([
    'heading' => 'Your next role is waiting',
    'subheading' =>
        'Search curated listings, filter by what matters to you, and apply with confidence — all in one place.',
])
<section {{ $attributes->class('border-b border-slate-800 bg-blue-900 py-6 sm:py-8') }}>
    <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
            {{ $heading }}
        </h2>
        <p class="mt-3 text-base leading-relaxed text-white sm:text-lg">
            {{ $subheading }}
        </p>
    </div>
</section>
