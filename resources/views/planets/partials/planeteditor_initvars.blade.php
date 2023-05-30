<script>
    var allblocks = {!! json_encode($allblocks->toArray(), JSON_HEX_TAG) !!};
    var planetblocks = {!! json_encode(isset($pl) ? ($pl->blocks->toArray()) : ([]), JSON_HEX_TAG) !!};
</script>
