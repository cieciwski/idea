@props(['idea' => new \App\Models\Idea])
<x-modal name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}"
    title="{{ $idea->exists ? 'Edit Idea' : 'New Idea' }}">
    <form x-data="{
                    status: @js(old('status', $idea->status->value)),
                    newLink: '',
                    links:  @js(old('links', $idea->links ?? [])),
                    newStep: '',
                    steps: @js(old('steps', $idea->steps->map->only(['id', 'description', 'completed'])))
                    }" method="POST" action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
        enctype="multipart/form-data">

        @csrf

        @if ($idea->exists)
            @method('PATCH')
        @endif

        <div class="space-y-6">
            <x-forms.field label="Title" name="title" placeholder="Enter an idea for your title" autofocus required
                :value="$idea->title" />

            <div class="space-y-2">
                <label for="status" class="label">Status</label>

                <div class="flex gap-x-3">
                    @foreach (App\IdeaStatus::cases() as $status)
                        <button type="button" @click="status = @js($status->value)"
                            data-test="button-status-{{ $status->value }}" class="btn flex-1 h-10"
                            :class="{'btn-outline': status !== @js($status->value)}">
                            {{ $status->label() }}
                        </button>
                    @endforeach

                    <input type="hidden" name="status" :value="status" class="input">
                </div>
                <x-forms.error name="status" />
            </div>

            <x-forms.field label="Description" name="description" type="textarea" placeholder="Describe your idea..."
                :value="$idea->description" />

            <div class="space-y-2">
                <label for="image" class="label">Featured Image</label>

                @if ($idea->image_path)
                    <div class="space-y-2">
                        <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}"
                            class="w-full h-48 object-cover rounded-lg">

                        <button class="btn btn-outlined h-10 w-full" form="delete-image-form">Remove Image</button>
                    </div>
                @endif

                <input type="file" name="image" accept="image/*" class="w-full">
                <x-forms.error name="image" />
            </div>

            <div>
                <h3 class="font-bold">Steps</h3>

                <template x-for="(step, index) in steps" :key="index">
                    <div class="flex gap-x-2 items-center mb-2">
                        <input :name="`steps[${index}][description]`" x-model="step.description" class="input flex-1">

                        <input type="hidden" :name="`steps[${index}][completed]`" :value="step.completed ? '1' : '0'">

                        <button type="button" aria-label="Remove step" @click="steps.splice(index, 1)"
                            class="form-muted-icon">
                            &times;
                        </button>
                    </div>
                </template>

                <div class="flex gap-2 mt-2">
                    <input type="text" id="new-step" x-model="newStep" placeholder="What needs to be done?"
                        autocomplete="off" spellcheck="false" class="input">
                    <button type="button" :disabled="!newStep" @click="
                        steps.push({ description: newStep.trim(), completed: false });
                        newStep = '';
                    " class="btn btn-outline">
                        Add
                    </button>
                </div>
            </div>

            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Links</legend>

                    <template x-for="(link, index) in links">
                        <div class="flex gap-x-2 items-center">
                            <input class="input" name="links[]" x-model="link">
                            <button type="button" aria-label="Remove link" @click="links.splice(index, 1)">
                                DEL
                            </button>
                        </div>
                    </template>

                    <div class="flex gap-x-2 items-center">
                        <input x-model="newLink" type="url" id="new-link" data-test="new-link"
                            placeholder="http://example.com" autocomplete="url" class="input flex-1" spellcheck="false">

                        <button type="button" data-test="submit-new-link-button"
                            @click="links.push(newLink.trim()); newLink = '';" :disabled="newLink.trim().length === 0"
                            aria-label="Add link button">
                            ADD
                        </button>
                    </div>
                </fieldset>
            </div>


            <div class="flex justify-end gap-x-5">
                <button type="button" @click="$dispatch('close-modal')">Cancel</button>
                <button type="submit" class="btn">{{ $idea->exists ? 'Update' : 'Create' }}</button>
            </div>
        </div>
    </form>
    @if ($idea->image_path)
        <form method="POST" action="{{ route('idea.image.destroy', $idea) }}" id="delete-image-form">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>
