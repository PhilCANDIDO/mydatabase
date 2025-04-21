<!-- resources/views/components/auto-dismiss-alert.blade.php -->
@props([
    'type' => 'success',
    'message',
    'dismissible' => true,
    'autoDismiss' => true,
    'dismissAfter' => 15000
])

@php
    $bgColor = match($type) {
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'error' => 'bg-red-100 border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-400 text-blue-700',
        default => 'bg-green-100 border-green-400 text-green-700',
    };
@endphp

<div 
    x-data="{ show: true }" 
    x-show="show" 
    x-init="@if($autoDismiss) setTimeout(() => { show = false }, {{ $dismissAfter }}) @endif"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="{{ $bgColor }} px-4 py-3 rounded relative border mb-4"
    role="alert"
>
    <span class="block sm:inline">{{ $message }}</span>
    @if($dismissible)
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="show = false">
        <svg class="fill-current h-6 w-6 {{ str_replace('text', 'text', $bgColor) }}" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <title>{{ __('Close') }}</title>
            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
        </svg>
    </span>
    @endif
</div>