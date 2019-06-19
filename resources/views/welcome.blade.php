<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DoAsk - Seek to find</title>
         <link rel="shortcut icon" type="image/png" href="{{asset('images/doask.png')}}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
           <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title > a{
                font-size: 84px;
                 color: #ffffff;
                text-decoration: none;
                font-weight: 700;
            }
            .title > i{
             font-size: 4rem;
                color:seagreen;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .home_layout{
         background-image: linear-gradient(to right,mediumseagreen,cornflowerblue);
      }
        </style>
    </head>
    <body>
       <div class="home_layout"> 
        <div class="flex-center position-ref full-height">
                <div class="top-right links">
                        <a href="{{ url('/threads') }}">Threads</a>
                    </div>
            <div class="content">
                <div class="title">
                    <i class="fab fa-old-republic"></i>
                    <br>
                    <a href="/threads">DoAsk</a>
                </div>
                <span class="m-b-md">Seek To Find</span>
                <div class="links">
                    <a href="/threads">Join Discussion</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>
