<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- trix editor assets -->
    @trixassets
</head>

<body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{-- notification --}}
            <div
                class="notification pr-4 py-2 rounded-lg shadow-xl flex items-center bg-green-50 fixed top-10 right-10 border-1 border-green-600 opacity-0">
                <span
                    class="w-12 h-12 rounded-full bg-gradient-to-tl from-green-400 to-green-800 grid place-items-center text-gray-200 text-2xl transform -translate-x-6">
                    <i class="icon ion-md-alert"></i>
                </span>
                <div class="-ml-2">
                    <h3 class="notification__title font-semibold text-green-600 mb-0">Notification title</h3>
                    <p class="notification__text text-sm text-gray-500">Notification body goes here</p>
                </div>
            </div>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    <script>
        /* DOM varariables */
        const notification = {
            container: document.querySelector('.notification'),
            title: document.querySelector('.notification__title'),
            text: document.querySelector('.notification__text')
        };

        // Create link to websocket server
        const clientSocket = (config = {}) => {
            let route = config.route || '127.0.0.1';
            let port = config.port || '5000';
            window.Websocket = window.WebSocket || window.MozWebSocket;
            const socketUrl = `ws://${route}:${port}`;
            return new WebSocket(socketUrl);
        }

        const connection = clientSocket();

        /**
         * The event listener that will be disptached
         * to the websocket
         */
        window.addEventListener('event-notification', e => {
            connection.send(JSON.stringify({
                title: event.detail.title,
                message: event.detail.message
            }));
        });

        /* Manage open connection */
        connection.onopen = () => {
            console.log('Connection is open');
        }

        connection.onclose = () => {
            setTimeout(() => {
                console.log('Reconnecting to server after 3 seconds');
            }, 3000);
        }

        connection.onmessage = (message) => {
            const result = JSON.parse(message.data);
            notification.title.textContent = result.title;
            notification.text.textContent = result.message;

            notification.container.classList.add('remove-0');
            notification.container.classList.add('opacity-100');

            window.setTimeout(() => {
                notification.container.classList.remove('opacity-100');
                notification.container.classList.add('opacity-0');
            }, 3000);
        }
    </script>
</body>

</html>
