<!-- resources/views/product-families/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la Famille de Produits') }}: {{ $family->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:product-families.edit-product-family :family="$family" />
        </div>
    </div>
</x-app-layout>