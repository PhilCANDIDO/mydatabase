<div class="p-6">
    <h2 class="text-lg font-medium text-gray-900">{{ __('Confirmer la suppression') }}</h2>
    
    <p class="mt-3 text-sm text-gray-600">
        {{ __('Êtes-vous sûr de vouloir supprimer le produit') }} <span class="font-medium">{{ $productName }}</span> ?
        {{ __('Cette action est irréversible.') }}
    </p>
    
    <div class="mt-6 flex justify-end space-x-2">
        <button type="button" wire:click="$dispatch('closeModal')" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
            {{ __('Annuler') }}
        </button>
        
        <button type="button" wire:click="delete" class="px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
            {{ __('Supprimer') }}
        </button>
    </div>
</div>