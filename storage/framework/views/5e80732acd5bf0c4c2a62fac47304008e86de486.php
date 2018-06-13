<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="LPProdSéries">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title>LP Prod Séries</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>"/>



        <!--Feuilles CSS-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/style.css">

        <!-- Scripts -->
        <script src="<?php echo e(asset('js/app.js')); ?>"></script>
        <?php echo $__env->yieldContent('script'); ?>


    </head>

    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <!--Nom du site-->
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                            
                            <img src="<?php echo e(asset('favicon.PNG')); ?>" class="img-responsive">
                        </a>
                    </div>
                    <!--Contenu de la navBar-->
                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!--A gauche-->
                        <ul class="nav navbar-nav navbar-left">
                            <li class="nav-item "><a  href="<?php echo e(url('/top')); ?>"> Top séries </a></li>
                            <li class="nav-item "><a  href="<?php echo e(url('/last')); ?>"> Nouvelles Séries </a></li>
                            <?php if(auth()->guard()->check()): ?>
                                <li class="nav-item"><a href="<?php echo e(url('/advise')); ?>"> Recommandations </a></li>
                                <li class="nav-item"><a href="<?php echo e(url('/favorites')); ?>"> Favoris </a></li>
                            <?php endif; ?>

                        </ul>


                        <div class=" nav-item col-sm-3 col-md-3">
                            <?php echo $__env->make('search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>

                        <!--A droite-->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            <?php if(auth()->guard()->guest()): ?>
                                <li class="nav-item "><a href="<?php echo e(route('login')); ?>">
                                        <i class="fa fa-user-circle-o fa-2x" style="color: cornflowerblue" aria-hidden="true"></i>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="dropdown show">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();" style="color: cornflowerblue" >
                                                Déconnexion
                                            </a>
                                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                                <?php echo e(csrf_field()); ?>

                                            </form>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>


            <?php if(session('success')): ?>
                <div class="container">
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="container">
                    <div class="alert alert-danger">
                        <?php echo e(session('error')); ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php echo $__env->yieldContent('content'); ?>




        <?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </body>
</html>