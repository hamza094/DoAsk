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
          @if(!auth()->check())
          <button class="btn btn-default"  @click="$modal.show('login')">Log In To Post</button>
            @endif
          <div class="threads">
              <p class="threads-heading"><b>Browse</b></p>
              <ul>
                  <li><a href="/threads" >All Threads</a></li>
                  @if(auth()->check())
                  <li><a href="/threads?by={{auth()->user()->name}}">My Threads</a></li>
                  @endif
                  <li><a href="/threads?popular=1">Popular Threads</a></li>
                  <li><a href="/threads?unanswered=1">Unanswered Threads</a></li>
              </ul>
          </div>
           <div class="trending">
              <p class="trending-heading"><b>Trending</b></p>
              @if(count($trending ))
              <ul>
                  @foreach($trending as $thread)
                    <li>
                        <a href="{{url($thread->path)}}">{{$thread->title}}</a>
                    </li>
                    @endforeach
                  </ul>
                  @endif
          </div>
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
            @include('modals.all')
        <flash message="{{session('flash')}}"></flash>
        </main>
    </div>
</body>
</html>
