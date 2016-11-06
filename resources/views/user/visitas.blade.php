@extends('layouts.Base')

@section('content')
	
	@include('layouts.Heading')
	
    <div class="row">
    	<div class="row container-info-user">
			<div class="col-md-2 col-sm-2">
				<img src = "<?php echo $Guest[0]->photo_src; ?>" id="foto-usuario-registrado" width='140px' height="140px" alt="Foto del usuario" class="img-circle text-center">
			</div>
			<div class="col-md-10 col-sm-10 info-user-visitas">
				<form class="form-inline">
					<div class="form-group margin-space">
						<label for="tipo">Usuario</label>
						{!! Form::select('tipo', $TypeGuest, $Guest[0]->id_type_guest, ['class'=> 'form-control', 'disabled'=>'disabled']); !!}
					</div>
					<div class="form-group margin-space">
						<label for="cedula">Cédula</label>
						<input type="text" class="form-control" id="cedula" value="{{$Guest[0]->cedula}}" disabled>
					</div>
					<div class="form-group margin-space">
						<label for="names">Nombres</label>
						<input type="text" class="form-control" id="names" value="{{$Guest[0]->names}}" disabled>
					</div>
					<div class="form-group margin-space">
						<label for="lastNames">Apellidos</label>
						<input type="text" class="form-control" id="lastNames" value="{{$Guest[0]->lastNames}}" disabled>
					</div>
					<div class="form-group margin-space">
						<label for="empresa">Empresa</label>
						<?php 
							$enterprise = $Guest[0]->enterprise;

							if(!empty($Guest[0]->enterpriseOther)) {
								$enterprise = $Guest[0]->enterpriseOther;
							}
		 				?>
						<input type="text" class="form-control" id="empresa" value="{{ $enterprise }}" disabled>
					</div>
				</form>
			</div>
		</div>
		<div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h4 class="text-center">Lista de visitas.</h4></div>
                <div class="panel-body">
                	
					<div id="clientes-visitantes">
						@include('layouts.Table_description_visits')
					</div>

				</div> 
            </div>
        </div>
	</div>

	<!-- /.row -->
	
	@include('layouts.Modal')

    <hr>
    
@endsection

