<div>
    <form wire:submit.prevent="save" class="w-full md:w-1/2 mx-auto">
        <div class="grid gap-4">
            {{-- Product SKU --}}
            <div class="flex flex-col md:flex-row text-xs md:text-sm items-center">
                <label class="w-full md:w-1/3" for="product_sku">{{__('Product SKU')}}</label>
                <div class="flex flex-col space-y-2 w-full md:w-2/3 mt-1 md:mt-0">
                    <input wire:model.defer="product.sku" id="product_sku" class="input block @error('product.sku') border-error @enderror" type="text" placeholder="{{__('Product SKU')}}" required />
                    @error('product.sku')
                        <div class="text-error">{{$message}}</div>
                    @enderror
                </div>
            </div>
            {{-- Product Price --}}
            <div class="flex flex-col md:flex-row text-xs md:text-sm items-center">
                <label class="w-full md:w-1/3" for="product_price">{{__('Product Price')}}</label>
                <div class="flex flex-col space-y-2 w-full md:w-2/3 mt-1 md:mt-0">
                    <input wire:model.defer="product.price" id="product_price" class="input block @error('product.price') border-error @enderror" type="text" pattern="\d+(\.\d{1,2})?" placeholder="{{__('Product Price')}}" required />
                    @error('product.price')
                        <div class="text-error">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="flex justify-end items-center space-x-2">
                <button type="submit" class="btn-sm btn-primary">{{__('Save Product')}}</button>
                <button type="button" class="btn-sm btn-warning" wire:click="cancel" id="cancel">{{__('Cancel')}}</button>
            </div>
        </div>
    </form>
</div>
