<div class="p-6 bg-white border-b border-gray-200">
    <form wire:submit="update">
        <div class="mb-4">
            <label for="product_family_code" class="block text-sm font-medium text-gray-700">{{ __('Code') }}</label>
            <input type="text" id="product_family_code" value="{{ $productFamily->product_family_code }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" disabled>
            <p class="mt-1 text-sm text-gray-500">{{ __('Le code ne peut pas être modifié.') }}</p>
        </div>

        <div class="mb-4">
            <label for="product_family_name" class="block text-sm font-medium text-gray-700">{{ __('Nom') }}</label>
            <input type="text" id="product_family_name" wire:model="product_family_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @error('product_family_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="product_family_desc" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
            <textarea id="product_family_desc" wire:model="product_family_desc" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            @error('product_family_desc') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('Etat') }}</label>
            <div class="mt-1">
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $productFamily->product_family_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $productFamily->product_family_active ? __('Active') : __('Inactive') }}
                </span>
                <p class="mt-1 text-sm text-gray-500">{{ __('L\'état ne peut pas être modifié.') }}</p>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('product-families.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                {{ __('Annuler') }}
            </a>
            <x-primary-button type="submit">
                {{ __('Appliquer') }}
            </x-primary-button>
        </div>
    </form>
</div>