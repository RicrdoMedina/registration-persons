						
						<div class="row">
							<div class="col-md-3 container-info-pagination">
								<span class="badge">Mostrando página {{ $listVisits->currentPage() }} de {{ $listVisits->lastPage() }}</span>
							</div>
							<div class="col-md-9 container-info-total-registros">
								<span class="badge">Total {{ $listVisits->total() }} registros</span>
							</div>
						</div>
						<div class="row container-show-page">
							<div class="col-md-4">
								<label for="select-mostrar">Mostrar</label>
								<select class="" id="select-mostrar" name="mostrar" data-route="1">
									 <option value="10">10</option>
									 <option value="25">25</option>
									 <option value="50">50</option>
									 <option value="100">100</option>
								</select>
								<label>registros de {{ $listVisits->total() }}.</label>
							</div>
						</div>
						<div class="row container-filters">


							<form id="form-buscar" class="form-inline" method="POST">
								<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" id="token">

								<div class="row">

									<div class="col-md-6 col-sm-6">
									    <div class="input-daterange input-group" id="datepicker">
										    <input type="text" class="input-sm form-control" id="startDate" title="Ingrese fecha de visita" name="start" placeholder="Fecha visita"/>
										    <span class="input-group-addon">Desde - Hasta</span>
										    <input type="text" class="input-sm form-control" id="endDate" title="Ingrese fecha de visita" name="end" placeholder="Fecha visita"/>
										</div>
									</div>									
									<div class="col-md-6 col-sm-6">
										<div class="input-group size">
											{!!Form::text('param2', null, ['id' => 'param2','class' => 'form-control', 'placeholder' => 'Buscar', 'required' => 'required','title' => 'Palabre clave']) !!}<span class="input-group-btn">
												<button class="btn btn-default" id="buscar-usuario" title="Realizar busqueda" type="button"><i class="fa fa-search"></i></button>
											</span>
										</div>
										<button type="button" class="btn btn-default refresh" title="Función actualizar">
											<i class="fa fa-refresh"></i> Refresh
										</button>
									</div>
								</div>

							</form>


							
						</div>
						@if ($listVisits->total() === 0)
							<div class="alert alert-warning" role="alert" style="margin:2.5em 0em; text-align:center;">
							    <i class="fa fa-user-times"></i> NO SE ENCONTRARON RESULTADOS!
							</div>
						@else
							<table class="table table-striped">
			  					<thead>
				  					<tr>
								    	<th>Fecha visita</th>
								    	<th>Tipo visita</th> 
								    	<th>Motivo</th>
								    	<th>Destino</th>
								    	<th>Observación</th>
								    	<th>Acción</th>
								    </tr>
							    </thead>
							    <tbody>

							    	@foreach ($listVisits as $listVisit)
									<tr class="fila-info" id="{!! $listVisit->id_description_visits !!}">
								    	<td>
		       					 			{{ $dt = App\DescriptionVisit::formatDate($listVisit->created_at) }}
	        							</td>
								    	<td>{{ $listVisit->type_visit }}</td>
								    	<td>
								    		<?php
									    		$motive = $listVisit->motive_visit;
									    		

									    		if(!empty($listVisit->motiveOther)) {
										    		$motive = $listVisit->motiveOther;
										    	}

										    	echo $motive;
								    		?>
								    	</td>
								    	<td>{{ $listVisit->destination }}</td>
								    	<td>

								    	</td>
								    	<td>
								    		<!-- Button trigger modal -->
											<button type="button" class="button btn btn-default editarVisita" id="buttonEditar" data-toggle="modal" data-target="#editarModal" data-whatever="@mdo" title="Editar visita" data-id="{!! $listVisit->id_description_visits !!}" data-view="1" data-nombre="{{ $Guest[0]->names }}" data-apellido="{!! $Guest[0]->lastNames !!}">
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
								{!! $listVisits->render() !!}
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 container-info-pagination">
								<span class="badge">Mostrando página {{ $listVisits->currentPage() }} de {{ $listVisits->lastPage() }}</span>
							</div>
							<div class="col-md-9 container-info-total-registros">
								<span class="badge">Total {{ $listVisits->total() }} registros</span>
							</div>
						</div>