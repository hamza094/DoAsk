<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    
       <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    
    <script>
    window.App={!! json_encode([
                'csrfToken'=>csrf_token(),
                'user'=>Auth::user(),
                'signedIn'=>Auth::check()
                ]) !!};
    </script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
       <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

 <link rel="shortcut icon" type="image/png" href="{{asset('images/doask.png')}}">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        .level{
            display: flex;
            align-items: center;
        }
        .flex{
            flex: 1;
        }
        [v-cloak]{display: none;}
        .ais-highlight > em{
            background: yellow;
            font-style: normal;
        }
    </style>
    
</head>
<body>
   
    <div id="app">
   @include('layouts.nav')
    @if(auth()->check())
    @if(auth()->user()->email_verified_at==null)
   <div class="alert alert-danger" role="alert">
       <p class="text-center"><b>Important Notice!</b> Email <a href="/home">confirmation</a> required</p>
   </div>
       @endif
       @endif
        <main class="py-4">
           <div class="container">
           
   <div class="row">
    <div class="col-md-3">
 <h4>Manage</h4>
   <div class="list-group">
  <a href="/admin/dashboard" class="list-group-item list-group-item-action {{ Route::is('admin.dashboard') ? 'active' : '' }}">
    DashBoard
  </a>
  <a href="/admin/channels" class="list-group-item list-group-item-action {{ Route::is('admin.channels') ? 'active' : '' }}">Channels</a>
  
</div>
    </div>
    <div class="col-md-9">
         @yield('administration-content')
    </div>
    </div>

</div>
           
        <flash message="{{session('flash')}}"></flash>
        </main>
    </div>
</body>
</html>