<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top"  role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <?php 
                    if (Auth::check()) {
                    ?>
                        <a class="navbar-brand" href="{{URL::to('/home')}}"><i class="fa fa-book link-text"></i> <span class='link-text'>Libro de Visitas</span></a>
                    <?php
                    }else{
                    ?>
                        <a class="navbar-brand" href="{{URL::to('/')}}"><i class="fa fa-book link-text"></i> <span class='link-text'>Libro de Visitas</span></a>
                    <?php
                    }
                ?>

                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                    

                    <?php 
                    if (Auth::check()) {
                    ?>
                    <li class="{{$current['registrar']}}">
                        <a href="{{URL::to('registrar')}}"><i class="fa fa-pencil-square-o"></i> Registrar</a>
                    </li>
                    <li class="dropdown {{$current['consultar']}}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i> Consultar <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{URL::to('consultar/visitas')}}"><i class="fa fa-eye"></i> Visitas</a>
                            </li>
                            <li>
                                <a href="{{URL::to('consultar/usuarios')}}"><i class="fa fa-users"></i> Usuarios</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='acount-user'><i class="fa fa-user"></i> {!! Auth::user()->email !!}<b class="caret"></b></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href=""><i class="fa fa-archive"></i> Mis datos</a>
                            </li>
                            <li>

                                <a href="{{URL::to('auth/logout')}}"><i class="fa fa-sign-out"></i> Salir</a>
                            </li>
                        </ul>
                    </li>
                    <?php
                    }
                    else
                    {
                    ?>
                        <li class="{{$current['login']}}">
                            <a href="{{URL::to('auth/login')}}"><i class="fa fa-user"></i> Login</a>
                        </li>
                    <?php
                     }
                    ?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>