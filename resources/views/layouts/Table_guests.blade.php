						
						<div class="row">
							<div class="col-md-3 container-info-pagination">
								<span class="badge">Mostrando página {{ $Guests->currentPage() }} de {{ $Guests->lastPage() }}</span>
							</div>
							<div class="col-md-9 container-info-total-registros">
								<span class="badge">Visitantes {{ $Visits }}</span>
								<span class="badge">Clientes {{ $Clients }}</span>
								<span class="badge">Total {{ $Guests->total() }} registros</span>
							</div>
						</div>
						<div class="row container-show-page">
							<div class="col-md-4">
								<label for="select-mostrar">Mostrar</label>
								<select class="" id="select-mostrar" name="mostrar" data-route="0">
									 <option value="10">10</option>
									 <option value="25">25</option>
									 <option value="50">50</option>
									 <option value="100">100</option>
								</select>
								<label>registros de {{ $Guests->total() }}.</label>
							</div>
						</div>
						<div class="row container-filters">
							{!! Form::open(['id' => 'form-buscar','class' => 'form-inline', 'method' => 'POST', 'route' => 'consultar/visitantes']) !!}
								    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" id="token"> 

	
										<div class="row">	
											<div class="col-md-6 col-sm-7 col-xs-8 buscadores">
											    <div class="input-daterange input-group" id="datepicker">
												    <input type="text" class="input-sm form-control" id="startDate" title="Ingrese fecha de registro del usuario" name="start" placeholder="Fecha registro"/>
												    <span class="input-group-addon">Desde - Hasta</span>
												    <input type="text" class="input-sm form-control" id="endDate" title="Ingrese fecha de registro del usuario" name="end" placeholder="Fecha registro"/>
												</div>
											</div>
																				
											<div class="col-md-6 col-sm-5 col-xs-7 buscadores">
												<div class="form-group">
													<select class="form-control select-param1 select-users" title="Seleccione tipo de usuario" id="select-param1" name="param1">
													  <option value="1"> Clientes </option>
													  <option value="2"> Visitantes </option>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">

												<div class="input-group size">
													{!!Form::text('param2', null, ['id' => 'param2','class' => 'form-control ', 'placeholder' => 'Buscar', 'required' => 'required','title' => 'Parametro de busqueda' ,'title' => 'Ingrese palabra clave']) !!}<span class="input-group-btn">
														<button class="btn btn-default" id="buscar-usuario" title="Realizar busqueda" type="button"><i class="fa fa-search"></i></button>
													</span>
												</div>

												<button type="button" class="btn btn-default refresh buscadores" title="Función actualizar">
													<i class="fa fa-refresh"></i> 
													Refresh
												</button>
											</div>
										</div>
								
								{!! Form::close() !!}
							</div>
						
						@if ($Guests->total() === 0)
							<div class="alert alert-warning" role="alert" style="margin:2.5em 0em; text-align:center;">
							    <i class="fa fa-user-times"></i> NO SE ENCONTRARON RESULTADOS!
							</div>
						@else
							<table class="table table-striped">
			  					<thead>
				  					<tr>
								    	<th>Foto</th>
								    	<th>Fecha registro</th>
								    	<th>Cédula</th> 
								    	<th>Tipo usuario</th> 
								    	<th>Nombres y apellidos</th>
								    	<th>Empresa</th>
								    	<th>Ultima visita</th>
								    	<th>Acciones</th>
								    </tr>
							    </thead>
							    <tbody>

							    	@foreach ($Guests as $Guest)

									    <tr class="fila-info" id="{{ $Guest->id }}">
									    	<td><img src="{{ $Guest->photo_src }}" class="img-circle" width="75" height="60" alt="{{ $Guest->names.' '.$Guest->lastNames }}"></td>
									    	<td>{{ $dt = App\DescriptionVisit::formatDate($Guest->created_at) }} </td>
									    	<td>{{ $Guest->cedula }} </td>
									    	<td>
									    		<?php 
										    		$type_guest = 'Visitante';

											    	if($Guest->id_type_guest == 1) {
											    		$type_guest = 'Cliente';
											    	}
											    	echo $type_guest;
										    	?>
									    	</td>
									    	<td>{{ $Guest->names.' '.$Guest->lastNames }}</td>
									    	<td>
										    	<?php 
										    		$enterprise = $Guest->enterprise;

										    		if(!empty($Guest->enterpriseOther)) {
										    			$enterprise = $Guest->enterpriseOther;
										    		}

										    		echo $enterprise;
			 									?>
		 									</td>
		 									<td>
		 										<?php
		 											$lastVisit = App\DescriptionVisit::where('id_guest_description', '=', $Guest->id)->get()->last();
		 											echo $dt = App\DescriptionVisit::getLastVisit($lastVisit->created_at);
		 										?>
		 									</td>
									    	<td>
									    		<button type="button" class="button btn btn-default visitas" title="Ver visitas de {!! $Guest->names !!}" data-cedula="{!! $Guest->cedula !!}" data-nombre="{!! $Guest->names !!}" data-apellido="{{ $Guest->lastNames }}">
									    			<i class="fa fa-eye"></i>
									    		</button>

									    		<!-- Button trigger modal -->
												<button type="button" class="button btn btn-default editar" data-view="1" data-cedula="{!! $Guest->id !!}" title="Editar registro de {!! $Guest->names !!}" data-nombre="{!! $Guest->names !!}" data-apellido="{{ $Guest->lastNames }}">
													<i class="fa fa-pencil"></i>
												</button>
									    	</td>
									    </tr>
								    @endforeach
							    </tbody>
								
							</table>

							@endif
						<div class="row">
							<div class="col-md-12">
								{!! $Guests->render() !!}
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 container-info-pagination">
								<span class="badge">Mostrando página {{ $Guests->currentPage() }} de {{ $Guests->lastPage() }}</span>
							</div>
							<div class="col-md-9 container-info-total-registros">
								<span class="badge">Visitantes {{ $Visits }}</span>
								<span class="badge">Clientes {{ $Clients }}</span>
								<span class="badge">Total {{ $Guests->total() }} registros</span>
							</div>
						</div>