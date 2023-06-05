<div class="flex flex-row justify-left gap-4 mt-2">
    <a href="{{ route('planets.edit', $pl) }}">
        <x-primary-button>{{ __('Edit') }}</x-primary-button>
    </a>
    <x-danger-button
    class="planetDelBtn"
    data-modal-show="del-pl-popup-modal"
    data-planet="{{ $pl->id }}">{{ __('Delete') }}</x-danger-button>
</div>
