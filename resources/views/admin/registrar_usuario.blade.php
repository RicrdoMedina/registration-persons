@extends('layouts.Base')

@section('content')

   @include('layouts.Heading')

	<div class="row">
		<div class="col-md-6 contenedor-img-registro-user">
			<img src="http://laravel.dev:8000/images/seguridad.png" alt="Seguridad de sistemas" class="img-rounded fade-img img-registro-user">
		</div>
		<div class="col-md-6">
			<div id="admin" class="col-md-10 ">
                
                {!! Form::open(['class' => 'form-horizontal form-cuadrado','id' => 'formRegistrarUser', 'method' => 'POST', 'route' => 'guardar/usuario']) !!}
                   
                   @include('layouts.create_user')
                   
                {!! Form::close() !!}
            </div>
		</div>
            
    </div>

@endsection