<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PixelPro3 - Agência Digital</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    @if (file_exists(public_path('hot')))
        <script type="module" src="http://localhost:5173/@vite/client"></script>
        <script type="module" src="http://localhost:5173/src/main.tsx"></script>
    @else
        <link rel="stylesheet" href="{{ asset('build/assets/app-L6-oVGfG.css') }}">
        <script type="module" src="{{ asset('build/assets/main.js') }}"></script>
    @endif
  </head>
  <body>
    <div id="root"></div>
  </body>
</html>
