<?php
    $vista = Route::currentRouteName();
    $aditional = 'Visitas';
    if( $vista == 'auth/login') {
         $current = 'Login';
         $aditional = 'de usuarios';
    }
    else if( $vista == 'registrar/visita') {
         $current = 'Registrar';
    }
    else if( $vista == 'consultar/visitantes') {
         $current = 'Consultar';
         $aditional = 'Visitantes';
    }
     else if( $vista == 'consultar/visitas') {
         $current = 'Consultar';
         $aditional = 'Visitas';
    }
    else if( $vista == 'usuarioVisitas') {
         $current = 'Usuario';
         $aditional = $Guest[0]->names.' '.$Guest[0]->lastNames;
    }
     else if($vista == 'registrar/usuario') {
         $current = 'Registrar';
         $aditional = 'Usuarios';
    }
    else if($vista == 'consultar/usuarios') {
         $current = 'Consultar';
         $aditional = 'Usuarios';
    }
    else if($vista == 'access') {
         $current = 'Acceso';
         $aditional = 'Restringido';
    }
?>

 <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><i class="fa fa-arrow-circle-right"></i> {{ $current }}
                    <small>{{$aditional}}</small>
                </h1>
                <?php 
                if(  $vista == 'usuarioVisitas' ) { ?>

                    <ol class="breadcrumb">
                        <li><a href="{{URL::to('/home')}}">Home</a></li>
                        <li><a href="{{URL::to('/consultar/visitantes')}}">Consultar</a></li>
                        <li class="active"><?php echo $aditional; ?></li> 
                    </ol>
                <?php 
                }
                if(  $vista == 'consultar/visitantes' ) { ?>

                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/home')}}">Home</a></li>
                    <li class="active">{{ $current }} Visitantes <?php if($current == 'Consultar') { ?><span class="badge" id="totalUsuarios"></span><?php } ?> </li>
                </ol>
                <?php } ?>
               <?php if(  $vista == 'consultar/visitas' ) { ?>

                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/home')}}">Home</a></li>
                    <li class="active">{{ $current }} Visitas <?php if($current == 'Consultar') { ?><span class="badge" id="totalVisitas"></span><?php } ?> </li>
                </ol>
                <?php } ?>
                <?php if(  $vista == 'access' ) { ?>

                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/home')}}">Home</a></li>
                    <li class="active">{{ $current }} restringido</li>
                </ol>
                <?php } ?>
            </div>
        </div>