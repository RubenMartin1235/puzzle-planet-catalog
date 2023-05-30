<div class="flex flex-row justify-left gap-4">
    <a href="{{ route('planets.edit', $pl) }}">
        <x-primary-button class="mt-4">{{ __('Edit') }}</x-primary-button>
    </a>
    <x-danger-button class="mt-4">{{ __('Delete') }}</x-danger-button>
</div>
