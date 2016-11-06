@extends('layouts.Base')

@section('content')

	@include('layouts.Heading')

        <div class="row">

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4 col-md-push-8 col-sm-6">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4><i class="fa fa-user-plus"></i> Ingrese cédula </h4>
                    {!! Form::open(['class' => 'form', 'id' => 'buscar-registro', 'method' => 'POST', 'route' => 'guardar/visita']) !!}
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" id="token"> 
                    <div class="input-group">
                        {!!Form::text('cedula', null, ['id' => 'cedula', 'class' => 'form-control solo-numeros', 'placeholder' => 'Ej. 8445332', 'required' => 'required']) !!}
                        <span class="input-group-btn">
                            <button class="btn btn-default" id="buscar" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                    <span id="msj-error-buscar">
             		  
                    </span>
                    {!! Form::close() !!}
                </div>

            </div>

            <div class="col-md-8 col-md-pull-4 col-sm-12">
				
				<div id="pasos-realizar">
		            <div class="col-lg-12">
		                <h2 class="page-header">Realizar los siguientes pasos:</h2>
		            </div>
		            <div class="col-md-6 col-sm-6">
		                <div class="panel panel-default text-center">
		                    <div class="panel-heading">
		                        <span class="fa-stack fa-5x">
		                              <i class="fa fa-circle fa-stack-2x text-primary"></i>
		                              <i class="fa fa-pencil-square fa-stack-1x fa-inverse"></i>
		                        </span>
		                    </div>
		                    <div class="panel-body">
		                        <h4>Paso 1</h4>
		                        <p>Ingresar el N° de cédula del usuario.</p>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-6 col-sm-6">
		                <div class="panel panel-default text-center">
		                    <div class="panel-heading">
		                        <span class="fa-stack fa-5x">
		                              <i class="fa fa-circle fa-stack-2x text-primary"></i>
		                              <i class="fa fa-file-text-o fa-stack-1x fa-inverse"></i>
		                        </span>
		                    </div>
		                    <div class="panel-body">
		                        <h4>Paso 2</h4>
		                        <p>Llenar los datos solicitados en el formulario.</p>
		                    </div>
		                </div>
		            </div>

		            <div class="col-md-6 col-sm-6" style="margin:0 auto;">
		                <div class="panel panel-default text-center">
		                    <div class="panel-heading">
		                        <span class="fa-stack fa-5x">
		                              <i class="fa fa-circle fa-stack-2x text-primary"></i>
		                              <i class="fa fa-floppy-o fa-stack-1x fa-inverse"></i>
		                        </span>
		                    </div>
		                    <div class="panel-body">
		                        <h4>Paso 3</h4>
		                        <p>Presionar el boton guardar.</p>
		                    </div>
		                </div>
		            </div>
	               
	            </div>

	            <div id="form-registar-visitantes" class="oculto">

						{!! Form::open(['class' => 'form-inline form-cuadrado', 'id' => 'form', 'method' => 'POST', 'files' => true,'role' => 'form', 'route' => 'guardar/visita']) !!}
					    	
							@include('layouts.Info_guests')
							
							<div class="data-user" id="descripcion-visita">
								<fieldset>
					        	<legend><i class="fa fa-hand-o-right" aria-hidden="true"></i> Descripción de la visita</legend>
									@include('layouts.Description_visits')
								</fieldset>
							</div>

						  <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
						{!! Form::close() !!}

	            </div>
	        </div>

        </div>
        <!-- /.row -->

        <hr>
    
@endsection

