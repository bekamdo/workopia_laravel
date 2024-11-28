<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>{{$title ?? "Workopia | Find and list Jobs"}}</title>
    <link rel="stylesheet" href={{asset('css/style.css')}}>
    @vite('resources/css/app.css')

</head>
<body class="bg-gray-100">
    <x-header/>
    @if(request() -> is('/'))
    <x-hero/>
    <x-top-banner/>
    @endif
    <main class="container mx-auto p-4 mt-4">
      @if (session('success'))
  <x-alert type="success" message="{{ session('success') }}" />
  @endif

  @if (session('error'))
  <x-alert type="error" message="{{ session('error') }}" />
  @endif
  {{$slot}}
    </main> 
    <script src={{asset('js/script.js')}}></script>
    
</body>
</html>