<div class="flex flex-row justify-left gap-4 mt-2">
    <a href="{{ route('cards.edit', $cd) }}">
        <x-primary-button>{{ __('Edit card') }}</x-primary-button>
    </a>
    <x-danger-button
        x-data @click="document.querySelector('input#card_id').value = {{ $cd->id }}"
        x-on:click.prevent="$dispatch('open-modal', 'confirm-card-deletion')"
    >{{ __('Delete card') }}</x-danger-button>
</div>
