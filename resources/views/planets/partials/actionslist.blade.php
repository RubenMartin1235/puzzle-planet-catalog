<div class="flex flex-row justify-left gap-4 mt-4">
    <a href="{{ route('planets.edit', $pl) }}">
        <x-primary-button>{{ __('Edit') }}</x-primary-button>
    </a>
    <x-danger-button>{{ __('Delete') }}</x-danger-button>
</div>
