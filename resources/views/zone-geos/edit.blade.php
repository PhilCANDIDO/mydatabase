<!-- resources/views/zone-geos/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier une zone géographique') }}: {{ $zoneGeo->zone_geo_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <livewire:zone-geos.edit-zone-geo :zoneGeo="$zoneGeo" />
            </div>
        </div>
    </div>
</x-app-layout>