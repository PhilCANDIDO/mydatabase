<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier une famille olfactive') }}: {{ $olfactiveFamily->olfactive_family_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <livewire:olfactive-families.edit-olfactive-family :olfactiveFamily="$olfactiveFamily" />
            </div>
        </div>
    </div>
</x-app-layout>