@props(['title', 'description'])

<div class="min-h-[calc(100vh-4rem-6rem)] flex items-center justify-center">
    <div class="w-full max-w-sm">
        <h1 class="text-2xl font-bold">{{ $title }}</h1>
        <p class="text-sm opacity-70 mt-1 mb-6">{{ $description }}</p>

        {{ $slot }}
    </div>
</div>
