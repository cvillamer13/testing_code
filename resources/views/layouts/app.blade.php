<!DOCTYPE html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        @include('partials.head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ERP System') }}</title>

    </head>
    <body class="h-100">
        {{-- <div class="min-h-screen bg-gray-100 dark:bg-gray-900"> --}}
            {{-- @include('layouts.navigation') --}}

            <!-- Page Heading -->
            @if (isset($header))
                {{-- <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header> --}}
            @endif
            <div id="preloader">
                <div class="sk-three-bounce">
                    <div class="sk-child sk-bounce1"></div>
                    <div class="sk-child sk-bounce2"></div>
                    <div class="sk-child sk-bounce3"></div>
                </div>
            </div>
            <!-- Page Content -->
            <div id="main-wrapper">
                @include('partials.header_logo')
                @include('partials.header')
                @include('partials.sidebar')
                <div class="content-body">
                    {{ $slot }}
                </div>
                
            </div>
                
       
        {{-- </div> --}}

       
    </body>
   
    @include('partials.toastr')
    @include('partials.script')
    @include('partials.footer')
</html>
