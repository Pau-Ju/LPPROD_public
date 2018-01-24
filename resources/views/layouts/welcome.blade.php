<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Netflux">

        <title>Netflux</title>


                                                <!--Feuilles CSS-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/style.css">


    </head>

    <body>
        <div id="app">
            <nav class="navbar navbar-default" role="navigation">
                <!--Nom du site-->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <!--Contenu de la navBar-->
                <div class="navbar-collapse collapse">
                    <!--A gauche-->
                    <ul class="nav navbar-nav navbar-left">
                        <li class="nav-item "><a  href=""> Top séries</a></li>
                        @auth
                            <li class="nav-item"><a href=""> Favoris </a></li>
                        @endauth

                    </ul>


                    <div class=" nav-item col-sm-3 col-md-3">
                        <form class="navbar-form" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" name="q">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fa fa-search" style="color:cornflowerblue;"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>


                    <!--A droite-->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item "><a href="{{ route('login') }}">
                                    <i class="fa fa-user-circle-o fa-2x" style="color: cornflowerblue" aria-hidden="true"></i>
                                </a>
                            </li>
                        @else
                            <li class="nav-item ">
                                <a class="nav-link" href=""> <i class="fa fa-bell-o fa-2x" style="color: cornflowerblue" aria-hidden="true"></i><span class="badge" style="background-color: cornflowerblue">5</span></a>
                            </li>

                            <li class="dropdown show">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="color: cornflowerblue" >
                                            Déconnexion
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>



        @if(session('success'))
                <div class="container">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="container">
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
        </div>

        @yield('content')


        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
    </body>

    <footer class="footer">
        <div class="container">
            <span class="text-muted">Copyright© 2018</span>
        </div>
    </footer>
</html>