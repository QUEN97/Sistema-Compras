@props(['disabled' => false, 'withicon' => false])

@php
$withiconClasses = $withicon ? 'pl-11 pr-4' : 'px-4'
@endphp

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
'class' => $withiconClasses . 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 
rounded-md shadow-sm1 
dark:border-gray-600 dark:bg-dark-eval-0
dark:text-black dark:focus:ring-offset-dark-eval-1',
])
!!}>