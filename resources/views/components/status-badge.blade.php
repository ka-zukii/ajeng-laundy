@props(['color' => 'default', 'label'])

@php
    $warnaTailwind = match($color) {
        'success' => 'bg-green-100 text-green-700',
        'warning' => 'bg-yellow-100 text-yellow-700',
        'danger'  => 'bg-red-100 text-red-700',
        default   => 'bg-gray-100 text-gray-700'
    };
@endphp

<span class="px-3 py-1 text-xs font-bold rounded-full flex items-center gap-1 w-max {{ $warnaTailwind }}">
    @if($color === 'success')
        <x-heroicon-s-check-circle class="w-4 h-4" /> 
    @elseif($color === 'warning')
        <x-heroicon-s-clock class="w-4 h-4" />
    @elseif($color === 'danger')
        <x-heroicon-s-x-circle class="w-4 h-4" />
    @else
        <x-heroicon-s-information-circle class="w-4 h-4" />
    @endif
    
    {{ $label }}
</span>