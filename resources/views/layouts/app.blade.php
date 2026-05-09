<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col" style="background: transparent !important;">
            @include('layouts.navigation')

            <main class="flex-grow flex items-center justify-center py-12">
                {{ $slot }}
            </main>
        </div>

        <style>
            /* 1. Global Page Lock */
            html, body {
                height: 100vh !important;
                margin: 0;
                padding: 0;
                overflow: hidden !important; /* Keeps the navbar from scrolling away */
                background-color: #1a1a1a !important; 
            }

            body {
                background-image: url("{{ asset('images/finalbg2.png') }}") !important;
                background-size: cover !important;
                background-position: center !important;
                background-attachment: fixed !important;
                background-repeat: no-repeat !important;
                font-family: 'Comic Sans MS', 'Chalkboard SE', 'cursive' !important;
            }

            /* 2. Transparency for Breeze Elements */
            nav, header, main, .bg-white, .bg-gray-100, .dark\:bg-gray-900 {
                background-color: transparent !important;
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
            }

            /* 3. The Chalkboard */
            .chalkboard-container {
                background-image: url("{{ asset('images/BlankChalk.png') }}") !important;
                background-size: 100% 100% !important; 
                background-repeat: no-repeat !important;
                padding: 60px 80px !important; 
                width: 100%;
                max-width: 1100px;
                height: 80vh !important; /* Fits within your 600px height limit */
                overflow-y: auto !important; /* Items scroll inside the board */
                color: white;
                image-rendering: pixelated;
                margin: 0 auto;
                z-index: 10;
            }

            /* 4. Navigation & Buttons */
            nav a, nav button, .nav-link {
                color: #facc15 !important;
                text-shadow: 1px 1px #000;
                font-weight: bold;
            }

            .pixel-btn {
                background: #00ff00;
                color: #000;
                border: 4px outset #ffffff;
                padding: 8px 20px;
                font-weight: bold;
                text-transform: uppercase;
                display: inline-block;
                text-decoration: none;
            }

            .pixel-btn:hover {
                background: #ffffff !important;
                border-style: inset;
            }
        </style>
    </body>
</html>