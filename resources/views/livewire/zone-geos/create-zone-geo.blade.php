<!-- resources/views/livewire/zone-geos/create-zone-geo.blade.php -->
<div class="p-6 bg-white border-b border-gray-200">
    <form wire:submit="create">
        <div class="mb-4">
            <label for="zone_geo_name" class="block text-sm font-medium text-gray-700">{{ __('Nom') }}</label>
            <input type="text" id="zone_geo_name" wire:model="zone_geo_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @error('zone_geo_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="zone_geo_desc" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
            <textarea id="zone_geo_desc" wire:model="zone_geo_desc" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            @error('zone_geo_desc') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="zone_geo_active" class="flex items-center">
                <input type="checkbox" id="zone_geo_active" wire:model="zone_geo_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-600">{{ __('Activer') }}</span>
            </label>
            @error('zone_geo_active') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('zone-geos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                {{ __('Annuler') }}
            </a>
            <x-primary-button type="submit">
                {{ __('Créer') }}
            </x-primary-button>
        </div>
    </form>
</div>