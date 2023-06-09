<img
    src="{{ isset($cd) && $cd->image !== null ? (asset('storage/'.$cd->image)) : asset('assets/img/planetplaceholder.svg') }}"
    class="w-full"
    id="card-image-view"
>
