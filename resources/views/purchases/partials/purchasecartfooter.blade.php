@auth
    @php
    $currentpurchase = Auth::user()->purchases()->latest()->where('status','started');
    @endphp
    <footer class=" bottom-0 fixed inset-x-0 border-t-2 bg-white h-[18vh] flex flex-row overflow-hidden">
        <div class="h-[18vh] shadow-md"></div>
    </footer>
@endauth
