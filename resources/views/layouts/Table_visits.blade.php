						
						<div class="row">
							<div class="col-md-3 container-info-pagination">
								<span class="badge">Mostrando página {{ $Guests->currentPage() }} de {{ $Guests->lastPage() }}</span>
							</div>
							<div class="col-md-9 container-info-total-registros">
	
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
							{!! Form::open(['id' => 'form-buscar','class' => 'form-inline', 'method' => 'POST', 'route' => 'consultar/visitas']) !!}
								    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" id="token"> 
									
									<div class="row">	
										<div class="col-md-6 col-sm-7 col-xs-8 buscadores">
											<div class="input-daterange input-group space" id="datepicker">
												<input type="text" class="input-sm form-control" id="startDate" name="start" placeholder="Fecha visita" title="Ingrese fecha de visita"/>
												<span class="input-group-addon">Desde - Hasta</span>
												<input type="text" class="input-sm form-control" id="endDate" name="end" placeholder="Fecha visita" title="Ingrese fecha de visita"/>
											</div>
										</div>

										<div class="col-md-6 col-sm-5 col-xs-7 buscadores">
											<div class="form-group">
												<select class="form-control select-param1 select-users" id="select-param1" name="param1" title="Seleccione tipo de usuario">
											  		<option value="1"> Clientes </option>
											  		<option value="2"> Visitantes </option>
												</select>
											</div>
										</div>
									</div>
																		
									<div class="row">
										<div class="col-md-12">
											<div class="input-group size">
												{!!Form::text('param2', null, ['id' => 'param2','class' => 'form-control', 'placeholder' => 'Buscar', 'required' => 'required','title' => 'Ingrese palabra clave']) !!}<span class="input-group-btn">
													<button class="btn btn-default" id="buscar-usuario" title="Realizar busqueda" type="button"><i class="fa fa-search"></i></button>
												</span>
											</div>
                      <input type="hidden" id="refresh" name="refresh" value="0"/>
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
								    	<th>Fecha visita</th>
								    	<th>Nombres y apellidos</th>
								    	<th>Destino</th>
								    	<th>Motivo</th>
								    	<th>Observación</th>
								    	<th>Acciones</th>
								    </tr>
							    </thead>
							    <tbody>
									
							    	
							    	@foreach ($Guests as $Guest)
							    	
								    <tr class="fila-info" id="{{ $Guest->id_description_visits }}">
								    	<td>
								    		<img src="{{ $Guest->photo_src }}" class="img-circle" width="75" height="60" title="{{ $Guest->names.' '.$Guest->lastNames }}">
								    	</td>
								    	<td>
								    		{{ $dt = App\DescriptionVisit::formatDate($Guest->created_at) }}
								    	</td>
								    	<td>
								    		{{ $Guest->names.' '.$Guest->lastNames }}
								    	</td>
	 									<td>
	 										{{ $Guest->destination }}
	 									</td>
	 									<td>
	 										<?php
								    			
									    		$id_motive = $Guest->id_motive;
									    		$motive = $MotiveVisit[$id_motive];

									    		if(!empty($Guest->motiveOther)) {
										    		$motive = $Guest->motiveOther;
										    	}

												echo $motive;
								    		?>
	 									</td>
	 									<td>
	 									</td>
								    	<td>
								    		<!-- Button trigger modal -->
											<button type="button" class="button btn btn-default editarVisita" title="Editar visita {!! $Guest->names !!}" id="buttonEditar" data-toggle="modal" data-target="#editarModal" data-whatever="@mdo" data-view="0" data-id="{!! $Guest->id_description_visits !!}" data-nombre="{{$Guest->names}}" data-apellido="{!! $Guest->lastNames !!}">
												<i class="fa fa-pencil"></i>
											</button>

											<button type="button" class="button btn btn-default editar" title="Editar usuario {!! $Guest->names !!}" data-cedula="{!! $Guest->id !!}" data-view="0" data-nombre="{{ $Guest->names }}" data-id="{!! $Guest->id_description_visits !!}" data-apellido="{!! $Guest->lastNames !!}">
								    			<i class="fa fa-user"></i>
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
				
								<span class="badge">Total {{ $Guests->total() }} registros</span>
							</div>
						</div>