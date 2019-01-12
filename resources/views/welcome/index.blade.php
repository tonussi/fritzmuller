@php
$config = [
    'appName' => config('app.name')
];

$polyfills = [
    'Promise',
    'Object.assign',
    'Object.values',
    'Array.prototype.find',
    'Array.prototype.findIndex',
    'Array.prototype.includes',
    'String.prototype.includes',
    'String.prototype.startsWith',
    'String.prototype.endsWith',
];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

  <meta name="Description" content="Author: Maria Cristina Pagotto Tonussi, Illustrator: Maria C. P. T. et al., Category: Educational, Area: Plants and Biology, About: Fritz Müller ponto Org. Esse site é uma uma simples homenagem ao legado científico de Fritz Müller.">

  <title>{{ config('app.name') }}</title>

  <link rel="dns-prefetch" href="https://fonts.gstatic.com">

  <link href='//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i|Material+Icons'
        rel="stylesheet" type="text/css">

  @include('welcome.favicon')

  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer></script>
</head>
<body>
  <div id="app"></div>

  {{-- Global configuration object --}}
  <script>window.config = @json($config);</script>

  {{-- Polyfill JS features via polyfill.io --}}
  <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ implode(',', $polyfills) }}"></script>

  {{-- Load the application scripts --}}
  @if (app()->isLocal())
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    @include('welcome.analytics')
  @endif
</body>
</html>
