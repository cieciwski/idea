<x-layout :title="$idea->title">
    <div class="max-w-3xl mx-auto px-4 py-8">

        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('ideas.index') }}" class="flex items-center gap-1 text-sm font-bold">
                Back to Ideas
            </a>

            <div class="flex items-center gap-2">
                <button x-data class="btn btn-outline" data-test="edit-idea-button"
                    @click="$dispatch('open-modal', 'edit-idea')">
                    Edit Idea
                </button>

                <form action="{{ route('idea.destroy', $idea) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline text-red-500">Delete</button>
                </form>
            </div>
        </div>

        @if ($idea->image_path)
            <div class="w-full h-64 overflow-hidden rounded-xl mb-6">
                <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}"
                    class="w-full h-full object-cover">
            </div>
        @endif

        <div>
            <h1 class="font-bold text-3xl mb-4">
                {{ $idea->title }}
            </h1>

            <div class="flex items-center gap-4 text-sm mb-8">
                <x-idea.status-lable :status="$idea->status->value">
                    {{ $idea->status->label() }}
                </x-idea.status-lable>

                <span class="opacity-60">
                    {{ $idea->updated_at->diffForHumans() }}
                </span>
            </div>
        </div>

        <div class="card text-foreground max-w-none cursor-pointer mt-6 mb-8">
            {{ $idea->description }}
        </div>

        @if ($idea->steps->count())
            <h3 class="font-bold mt-8 mb-4">Actionable Steps</h3>

            <div class="space-y-3">
                @foreach ($idea->steps as $step)
                    <div class="card flex items-center gap-4">
                        <form action="{{ route('steps.update', $step) }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PATCH')

                            <button type="submit" role="checkbox" class="focus:outline-none flex items-center justify-center">
                                @if ($step->completed)
                                    <svg class="size-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg class="size-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                                    </svg>
                                @endif
                            </button>
                        </form>

                        <span class="{{ $step->completed ? 'line-through opacity-50' : '' }}">
                            {{ $step->description }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($idea->links?->count())
            <h3 class="font-bold mt-8 mb-4">Links</h3>

            <div class="space-y-3">
                @foreach ($idea->links as $link)
                    <a href="{{ $link }}" class="card flex items-center gap-3 text-primary hover:opacity-80 transition-opacity"
                        target="_blank" rel="noopener noreferrer">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>

                        <span>{{ $link }}</span>
                    </a>
                @endforeach
            </div>
        @endif
        <x-idea.modal :idea="$idea" />
    </div>
</x-layout>
