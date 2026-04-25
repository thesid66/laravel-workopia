@props([
    'heading' => 'Hiring? Reach candidates on Workopia',
    'subheading' =>
        'Post your role in minutes and connect with people who are actively looking for their next opportunity.',
])
<section {{ $attributes->class('border-t border-blue-800 bg-blue-900 py-6 sm:py-8 mb-10') }}>
    <div class="px-4 sm:px-6 lg:px-8 flex flex-row justify-between items-center w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                {{ $heading }}
            </h2>
            <p class="mt-3 text-base leading-relaxed text-white sm:text-lg">
                {{ $subheading }}
            </p>
        </div>
        <div class=" flex justify-center">
            <x-button href="{{ url('/jobs/create') }}" size="xlarge">
                Create a job
            </x-button>
        </div>
    </div>
</section>
