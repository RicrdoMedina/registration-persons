
								<?php
									$id_motive_visit = null;
									$bandera = 0;

									if(isset($Guest)) {
										$id_motive_visit = $visita[0]->id_motive;
									}

									if(isset($visita[0]->motiveOther)) {
										if (empty(!$visita[0]->motiveOther)) {
											$bandera = 1;
										}
									}
								?>
								<?php
								if(isset($visita[0])) { 
								?>
									<input type="hidden" name="id" value="<?php echo $visita[0]->id_description_visits; ?>">
								<?php
								}
								?>
					        	<div id="container-visita" class="form-group margin-space container-input clear">
					                <label>Visita:</label> 
					                <input style="display:inline;" class="sombra" <?php if(! empty($visita[0]->id_type_visit) && $visita[0]->id_type_visit == 1) { echo "checked = checked"; } ?> id="formal" type="radio" name="visita" value="1" required>
					                <label for="formal">formal</label>
					                <input style="display:inline;" class="sombra" <?php if(! empty($visita[0]->id_type_visit) && $visita[0]->id_type_visit == 2) { echo "checked = checked"; } ?> id="particular" type="radio" name="visita" value="2">
					                <label for="particular">particular</label>
									<span class="help-block">
										<strong id="campo-visita" class="error"></strong>					             		  
									</span>
					            </div>
								
								<div id="contenedor-motivo-visitante">
						           <div id="container-motivo" class="form-group margin-space container-input clear">
									    <label for="motivo">Motivo:</label>

										{!! Form::select('motivo', $MotiveVisit, $id_motive_visit, ['class'=> 'form-control clear sombra', 'id' => 'motivo', 'placeholder' => '--- SELECCIONE ---', 'required' => 'required']); !!}
										<span class="help-block">
											<strong id="campo-motivo" class="error"></strong>				             		  
										</span>
								    </div>
								</div>

							    <div <?php if($bandera == 0) { echo "class='oculto'"; } ?> id="contenedor-indique-motivo-visitante">
								    <div id="container-otro_motivo" class="form-group margin-space container-input clear">
								    	<label for="otro_motivo">Otro motivo:</label>
										<input type="text" class="form-control clear sombra" id="otro_motivo" name="otro_motivo" placeholder="Indique motivo" value="<?php if(isset($visita[0])) {echo $visita[0]->motiveOther;} ?>" required>
										<span class="help-block">
											<strong id="campo-otro_motivo" class="error"></strong>				             		  
										</span>
								    </div>
								</div>

							    <div id="container-destino" class="form-group margin-space container-input clear">
							    	<?php
										$id_destination = null;
										if(isset($visita[0]->id_destination)) {
											$id_destination = $visita[0]->id_destination;
										}
									?>
							    	<label for="destino">Destino:</label>
							        {!! Form::select('destino', $Destination, $id_destination, ['class'=> 'form-control clear sombra', 'id' => 'destino', 'placeholder' => '--- SELECCIONE ---', 'required' => 'required' ]); !!}
							        <span class="help-block">
										<strong id="campo-destino" class="error"></strong>				             		  
									</span>
							    </div>
							     <div class="observacion margin-space container-input">
							    	<label for="textarea-observacion">Observación:</label>
							        <textarea class="form-control textarea-observacion clear" name="observacion" >
							        </textarea>
							    </div>
							