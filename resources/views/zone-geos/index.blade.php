<!-- resources/views/zone-geos/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Zones Géographiques') }}
            </h2>
            @can('add data')
            <a href="{{ route('zone-geos.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ __('Nouvelle zone géographique') }}
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message') || session('success'))
                <x-auto-dismiss-alert 
                    type="success" 
                    :message="session('message') ?? session('success')" 
                    :auto-dismiss="true"
                    :dismiss-after="15000"
                />
            @endif

            @if (session('error'))
                <x-auto-dismiss-alert 
                    type="error" 
                    :message="session('error')" 
                    :auto-dismiss="false"
                />
            @endif

            <livewire:zone-geos.zone-geo-list />
        </div>
    </div>
</x-app-layout>