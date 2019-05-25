<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DoAsk - Seek to find</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    
    <script>
    window.App={!! json_encode([
                'csrfToken'=>csrf_token(),
                'user'=>Auth::user(),
                'signedIn'=>Auth::check()
                ]) !!};
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.0/trix.css"> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

<link rel="shortcut icon" type="image/png" href="https://i.ibb.co/c8FkbP7/doask.png">
    
    
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
        
           <div class="container screen">
    <div class="row justify-content-center">
       <div class="col-md-3 padding-0">
          <div class="left-sidebar">
          @if(!auth()->check())
          <button class="btn btn-default"  @click="$modal.show('login')">Log In To Post</button>
           @elseif(Route::is('threads'))
           <button class="btn btn-default"  @click="$modal.show('create-thread')">Create New Thread</button>
            @endif
          <div class="threads">
              <p class="threads-heading"><b>Browse</b></p>
              <ul>
                  <li><i class="fab fa-adn"></i><a href="/threads" class="{{ Route::is('threads') && empty(Request::query()) ? 'text-blue' : '' }}"> All Threads</a></li>
                  @if(auth()->check())
                  <li><i class="fas fa-user-secret"></i><a href="/threads?by={{auth()->user()->name}}" class="{{ request()->has('by') ? 'text-blue' : '' }}"> My Threads</a></li>
                  @endif
                  <li><i class="fas fa-star"></i><a href="/threads?popular=1" class="{{ request()->has('popular') ? 'text-blue' : '' }}"> Popular Threads</a></li>
                  <li><i class="fas fa-question-circle red"></i><a href="/threads?unanswered=1" class="{{ request()->has('unanswered') ? 'text-blue' : '' }}"> Unanswered Threads</a></li>
              </ul>
          </div>
                   @if(Route::is('threads'))
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
          @endif
           </div>
       </div>
       
        <div class="col-md-7 padding-0">
           <div class="main-panel">
            @yield('content')
            </div>
        </div>
        <div class="col-md-2 padding-0">
       <div class="right-sidebar">
                <div class="channels">
              <p class="channels-heading">Channels</p>
              <ul>
                  @foreach($allchannels as $channel)
                    <li>
        <span
        style="background-color:{{$channel->color}};
        width: 1.3rem;
        height: 1.3rem;
        margin-right: .9rem;
        border-radius: 50%;
        display: inline-block;">
            
        </span><a href="/threads/{{$channel->slug}}">{{$channel->name}}</a>
                    </li>
                    @endforeach
                  </ul>
                 </div>
            </div>
        </div>
    </div>
</div>
            @include('modals.all')
        <flash message="{{session('flash')}}"></flash>
        
    </div>
</body>
</html>