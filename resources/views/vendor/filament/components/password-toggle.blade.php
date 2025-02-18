@php
    // Konversi array attribute ke string HTML secara manual.
    $extraAttributes = '';
    foreach ($getExtraAttributes() as $key => $value) {
        $extraAttributes .= $key . '="' . e($value) . '" ';
    }
@endphp

<div x-data="{ show: false }" class="flex items-center">
    <input
        {!! $extraAttributes !!}
        x-bind:type="show ? 'text' : 'password'"
        {!! $getId() ? 'id="' . e($getId()) . '"' : '' !!}
        {!! $getStatePath() ? 'name="' . e($getStatePath()) . '"' : '' !!}
        value="{{ $getState() }}"
        {!! $getExtraInputAttributeBag()->class([
            'filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm',
        ]) !!}
    >
    <button type="button" x-on:click="show = !show" class="ml-2 focus:outline-none">
        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.373-4.182M6.318 6.318a9.956 9.956 0 014.182-2.373M3 3l18 18"/>
        </svg>
    </button>
</div>
