<img
    src="{{ isset($pl) && $pl->image !== null ? (asset('storage/'.$pl->image)) : asset('assets/img/planetplaceholder.svg') }}"
    class="w-full"
    id="planet-image-view"
>
