<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Poliklinik' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/js/app.js','resources/css/app.css'])
</head>
<body>
    <div class="app-wrapper">
        {{-- SIDEBAR --}}
        <div id="appSidebar" class="sidebar-fixed">
            @include('components.partials.sidebar')
        </div>

        {{-- MAIN CONTENT --}}
        <div class="main-content">
            @include('components.partials.header')

            <div class="main-scroll">
                @if(session('success'))
                <div class="alert alert-success mb-4 rounded-xl shadow-sm">
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @yield('content')
                {{ $slot ?? '' }}
            </div>

            @include('components.partials.footer')
        </div>
    </div>

    @stack('scripts')
</body>
</html>