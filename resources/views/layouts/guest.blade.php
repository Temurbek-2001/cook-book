<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .bubble {
                position: absolute;
                border-radius: 50%;
                opacity: 0.4;
                animation: float 8s ease-in-out infinite;
                z-index: 1;
            }
            
            .bubble:nth-child(1) {
                width: 60px;
                height: 60px;
                left: 15%;
                top: 20%;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                animation-delay: 0s;
            }
            
            .bubble:nth-child(2) {
                width: 80px;
                height: 80px;
                left: 80%;
                top: 10%;
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                animation-delay: 2s;
            }
            
            .bubble:nth-child(3) {
                width: 50px;
                height: 50px;
                left: 70%;
                top: 70%;
                background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                animation-delay: 4s;
            }
            
            .bubble:nth-child(4) {
                width: 70px;
                height: 70px;
                left: 10%;
                top: 80%;
                background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
                animation-delay: 1s;
            }
            
            @keyframes float {
                0%, 100% {
                    transform: translateY(0px) translateX(0px);
                }
                25% {
                    transform: translateY(-20px) translateX(10px);
                }
                50% {
                    transform: translateY(-10px) translateX(-15px);
                }
                75% {
                    transform: translateY(-25px) translateX(5px);
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Background with bubbles -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-100 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-indigo-900 relative overflow-hidden">
            <!-- Animated bubbles -->
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            
            <div class="relative z-10">
                <a href="/">
                    <x-application-logo class="fill-current text-gray-500" style="height: 20rem; margin-bottom:-6rem; margin-top:-6rem;" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white/20 dark:bg-gray-800/20 backdrop-blur-md border border-white/30 dark:border-gray-700/30 shadow-xl overflow-hidden sm:rounded-lg relative z-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
