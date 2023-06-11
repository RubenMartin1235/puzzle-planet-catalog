<img
    src="{{ isset($cd) && $cd->image !== null ? (asset('storage/'.$cd->image)) : asset('assets/img/cardplaceholder.svg') }}"
    class="w-full"
    id="card-image-view"
>
