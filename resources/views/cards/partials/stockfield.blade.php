<div class="flex flex-col w-4/6">
    <label for="stock">{{ __('Units in stock:') }}</label>
    <input type="number" name="stock" min="1" value={{ old('stock',$cd->stock) }} class="">
</div>
