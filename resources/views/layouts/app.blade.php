@extends('layouts.base')

@section('body')
    <div class="min-h-screen flex flex-col">
        <livewire:layout.navigation/>
        <div class="flex-1 relative h-full bg-center sm:flex sm:justify-center bg-dots dark:bg-gray-900 selection:bg-indigo-500 selection:text-white">
            @yield('content')
            
            @isset($slot)
                {{ $slot }}
            @endisset
        </div>
    </div>
@endsection
