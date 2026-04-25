<section class="relative flex min-h-88 items-center justify-center overflow-hidden sm:min-h-104">
    <div class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&amp;fit=crop&amp;w=2000&amp;q=80');">
    </div>
    <div class="absolute inset-0 bg-slate-950/75"></div>

    <div class="relative z-10 w-full max-w-5xl px-4 py-14 text-center sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl md:text-5xl">
            Find your dream job
        </h1>

        <form action="{{ route('jobs.index') }}" method="get"
            class="mx-auto mt-8 flex w-full max-w-3xl flex-nowrap items-stretch gap-2 sm:gap-3">
            <label for="hero-keyword" class="sr-only">Keyword</label>
            <input id="hero-keyword" type="search" name="keyword" value="{{ request('keyword') }}"
                placeholder="Keyword"
                class="min-w-0 flex-1 rounded-lg border border-white/20 bg-white/95 px-3 py-2.5 text-sm text-slate-900 shadow-sm placeholder:text-slate-500 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 sm:px-4 sm:text-base">

            <label for="hero-location" class="sr-only">Location</label>
            <input id="hero-location" type="text" name="location" value="{{ request('location') }}"
                placeholder="Location"
                class="min-w-0 flex-1 rounded-lg border border-white/20 bg-white/95 px-3 py-2.5 text-sm text-slate-900 shadow-sm placeholder:text-slate-500 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 sm:px-4 sm:text-base">

            <button type="submit"
                class="shrink-0 rounded-lg bg-linear-to-r from-indigo-600 to-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-slate-900 sm:px-6 sm:text-base">
                Search
            </button>
        </form>
    </div>
</section>
