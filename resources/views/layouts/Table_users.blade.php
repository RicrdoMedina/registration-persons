						
						<div class="row">
							<div class="col-md-3 container-info-pagination">
								<span class="badge">Mostrando página {{ $Users->currentPage() }} de {{ $Users->lastPage() }}</span>
							</div>
							<div class="col-md-9 container-info-total-registros">
								<span class="badge">Total {{ $Users->total() }} registros</span>
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
								<label>registros de {{ $Users->total() }}.</label>
							</div>
						</div>
						<div class="row container-filters">
							{!! Form::open(['id' => 'form-buscar','class' => 'form-inline', 'method' => 'POST', 'route' => 'consultar/usuarios']) !!}
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
													  <option value="1"> Admin </option>
													  <option value="2"> User </option>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">

												<div class="input-group size">
													{!!Form::text('param2', null, ['id' => 'param2','class' => 'form-control ', 'placeholder' => 'Buscar', 'required' => 'required','title' => 'Parametro de busqueda','title' => 'Ingrese palabra clave']) !!}<span class="input-group-btn">
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
						
						@if ($Users->total() === 0)
							<div class="alert alert-warning" role="alert" style="margin:2.5em 0em; text-align:center;">
							    <i class="fa fa-user-times"></i> NO SE ENCONTRARON RESULTADOS!
							</div>
						@else
							<table class="table table-striped">
			  					<thead>
				  					<tr>
								    	<th>Nombres</th>
								    	<th>Apellidos</th>
								    	<th>Email</th> 
								    	<th>Rol</th> 
								    	<th>Status</th>
								    	<th>Acciones</th>
								    </tr>
							    </thead>
							    <tbody>

							    	@foreach ($Users as $User)

									    <tr class="fila-info" id="{{ $User->id }}">
									    	<td>{{ $User->nombre }} </td>
									    	<td>{{ $User->apellido }} </td>
									    	<td>{{ $User->email }} </td>
									    	<td>
									    	<?php echo $Roles[$User->rol]; ?>
									    	</td>
									    	<td><?php echo $Status[$User->status]; ?> </td>
									    	<td>
									    		<!-- Button trigger modal -->
												<button type="button" class="button btn btn-default editarUsuario" data-toggle="modal" data-target="#editarModal" data-view="1" data-whatever="@mdo" data-id="{!! $User->id !!}" title="Editar registro de {!! $User->nombre !!}">
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
								{!! $Users->render() !!}
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 container-info-pagination">
								<span class="badge">Mostrando página {{ $Users->currentPage() }} de {{ $Users->lastPage() }}</span>
							</div>
							<div class="col-md-9 container-info-total-registros">
								<span class="badge">Total {{ $Users->total() }} registros</span>
							</div>
						</div>