<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        header {
            background-color: #333;
            color: white;
            padding: 1em;
            text-align: center;
        }

        nav {
            background-color: #444;
            color: white;
            padding: 1em;
            text-align: center;
        }

        nav a {
            text-decoration: none;
            color: white;
            padding: 1em;
            margin: 0 1em;
            font-weight: bold;
            text-transform: uppercase;
        }

        section {
            padding: 2em;
        }

        section img {
            max-width: 100%;
            height: auto;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1em;
        }
    </style>
</head>
<body>
<div id="app">
    <header>
        <h1>Flames & Flavours</h1>
    </header>

    <nav>
        <a href="#">Home</a>
        <a href="/order/create">Menu</a>
        <a href="/orders/detail">Orders</a>
        <a href="#">Contact</a>
    </nav>

    <section>
        @yield('content')
    </section>

    

    <footer>
        <p>&copy; 2023 Flames & Flavours. All rights reserved.</p>
    </footer>
</div
</body>
</html>
