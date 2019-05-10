<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.0/trix.css"> 

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
    @yield('header')
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
    <div class="row justify-content-center">
       <div class="col-md-3 padding-0">
          <div class="right-panel">
           Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis ex molestias, corporis et earum enim, voluptas id minima quaerat libero vero cum assumenda suscipit unde fugit, dolorem eveniet ducimus quibusdam quis fuga officia distinctio ad. Reprehenderit dolores necessitatibus voluptatum, ducimus amet iusto repellendus voluptatibus alias maxime neque recusandae aliquam, ab! Eum aspernatur nulla molestias quos magni dolorem, maxime, vel repellendus culpa nobis ipsum similique molestiae placeat repudiandae. Enim, quo nisi inventore accusamus earum ratione aspernatur modi labore sequi incidunt ex tenetur eos ab dolores illum voluptas a, harum culpa, beatae dolorum. Ipsum laborum voluptates voluptatibus perspiciatis veritatis voluptatum, vel explicabo eos doloremque eius in dignissimos aspernatur aliquid dicta labore animi eum iusto illum facilis sint placeat cumque. Officia quisquam, sequi nostrum incidunt quae, ipsam eos, dolore explicabo aliquam, delectus ipsum fuga. Earum voluptas mollitia enim, modi quos neque in asperiores deleniti id. Sequi ducimus, vitae mollitia accusantium temporibus animi explicabo.
           </div>
       </div>
       
        <div class="col-md-7 padding-0">
            @yield('content')
        </div>
        <div class="col-md-2 padding-0">
          <div class="card">
              <div class="card-header">
                  Search Threads
              </div>
              <div class="card-body">
                 <form action="/threads/search" method="get">
                  <div class="form-group">
                      <input type="text" name="q" class="form-control" placeholder="Search for something...">
                  </div>
                  <button type="submit" class="btn btn-primary">Search</button>
                  </form>
              </div>
          </div>
          <hr>
        </div>
    </div>
</div>
           
        <flash message="{{session('flash')}}"></flash>
        </main>
    </div>
</body>
</html>
