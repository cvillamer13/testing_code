<!DOCTYPE html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        @include('partials.head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Asset Management System') }}</title>

    </head>
    <body class="h-100">
            <!-- Page Heading -->
            @if (isset($header))
                {{-- <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header> --}}
            @endif
      
                {{ $slot }}
    </body>

    @include('partials.script')
</html>
