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
</head>

<body class="font-sans text-gray-900 antialiased">
  <div class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0">
    {{-- <div>
      <a href="/">
        <x-application-logo class="h-20 w-20 fill-current text-gray-500" />
      </a>
    </div> --}}

    <div
      class="mt-6 flex h-full w-full flex-col items-center overflow-hidden bg-white shadow-md sm:max-w-4xl sm:rounded-lg md:flex-row">
      <div class="relative h-96 w-full bg-cover"
        style="background-image: url('{{ asset('assets/img/frontPage.webp') }}')">
        <div class="p-6">
          <h1 class="text-3xl font-bold text-white">Blog <span
              class="duration-300 ease-in-out hover:rotate-6">Poster</span>
          </h1>
          <p class="text-white">Please login to your account</p>
          <p class="mt-8 rounded-lg bg-gray-200 bg-opacity-25 p-4 text-gray-200 shadow-lg backdrop-blur-md">
            This is a simple blog application built with Laravel and TailwindCSS. It is a good starting point for
          </p>
        </div>

      </div>
      <div class="w-full px-8 py-4">
        {{ $slot }}
      </div>

    </div>
  </div>
</body>

</html>
