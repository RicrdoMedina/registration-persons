								<div id="datos-personales-usuario-registrado" class="oculto">
					        		<div class="form-group margin-space container-input">
										<input type="hidden" name="ci" value="<?php if(isset($Guest)){ echo $Guest->cedula; } ?>">
										<img <?php if(isset($Guest)){ echo "src = ' $Guest->photo_src '"; } ?> id="foto-usuario-registrado" width='180px' height="140px" alt="Foto del usuario" class="img-thumbnail">
									</div>
													
									<div id="ci-user" class="form-group margin-space">
										<label for="cedula">Cédula:</label>
										<?php if(isset($Guest)){ $cedula = $Guest->cedula; }else{ $cedula = null; } ?>
										{!!Form::text('cedula', $cedula, ['id' => 'cedula','class' => 'form-control solo-numeros disabled', 'placeholder' => 'Ej. 8445332', 'autofocus' => 'autofocus', 'required' => 'required']) !!}
										<span class="help-block">
														             		  
										</span>
									</div>
								</div>
								<div id="input-datos-personales">
									<div class="form-group margin-space">
										<label for="nombres">Nombres:</label>
										<?php if(isset($Guest)){ $names = $Guest->names; }else{ $names = null; } ?>
										{!!Form::text('nombres', $names, ['id' => 'nombres','class' => 'form-control solo-letras clear disabled','placeholder' => 'Ej. Carlos Alberto', 'required' => 'required']) !!}
										<span class="help-block">
											<strong id="campo-nombres" class="error"></strong>	             		  
										</span>
									</div>

									<div class="form-group margin-space">
										<label for="apellidos">Apellidos:</label>
										<?php if(isset($Guest)){ $lastNames = $Guest->lastNames; }else{ $lastNames = null; } ?>
										{!!Form::text('apellidos', $lastNames, ['id' => 'apellidos','class' => 'form-control solo-letras clear disabled','placeholder' => 'Ej. Mendoza Rodriguez', 'required' => 'required']) !!}
										<span class="help-block">
											<strong id="campo-apellidos" class="error"></strong>		             		  
										</span>
									</div>

									 <div class="form-group margin-space" id="comprobar-checkbox">

										<label>Tipo usuario:</label>
										<input style="display:inline;" type="radio" class="" <?php if(isset($Guest->id_type_guest) && $Guest->id_type_guest === 1) { echo 'checked = checked'; } ?> id="cliente" name="tipo_usuario" value="1" required>

										<label for="cliente">cliente</label>
										<input style="display:inline;" id="visita" class="" type="radio" <?php if(isset($Guest->id_type_guest) && $Guest->id_type_guest === 2) { echo 'checked = checked'; } ?> name="tipo_usuario" value="2">
										<label for="visita">visitante</label>

										<span class="help-block">
											<strong id="campo-tipo_usuario" class="error"></strong>           		  
										</span>
									</div>
									
									<div id="info-user-empresa" class="oculto">
										<div class="form-group margin-space">
											<label for="user_empresa">Empresa:</label>
											<?php if(isset($Guest)){ $lastNames = $Guest->lastNames; }else{ $lastNames = null; } ?>
											{!!Form::text('user_empresa', null, ['id' => 'user_empresa','class' => 'form-control solo-letras clear disabled','placeholder' => '', 'required' => 'required']) !!}
											<span class="help-block">
												<strong id="campo-user_empresa" class="error"></strong>     		  
											</span>
										</div>
									</div>

									<div class="info-empresa">
										<div id="contenedor-input-empresa">
											<div class="form-group <?php if(! isset($EnterpriseGuest->enterprise_id)) { echo 'margin-space'; } ?>">
												<label for="empresa">Empresa:</label>			
												<?php
												$enterprise_guest = null;
												if(isset($EnterpriseGuest->enterprise_id)) {
													$enterprise_guest = $EnterpriseGuest->enterprise_id;
												}
												?>
												{!! Form::select('empresa', $Enterprise, $enterprise_guest, ['class'=> 'form-control clear', 'id' => 'empresa', 'placeholder' => '--- SELECCIONE ---', 'required' => 'required']); !!}
												<span class="help-block">
													<strong id="campo-empresa" class="error"></strong>              		  
												</span>
											</div>
										</div>

										<div <?php if(empty($EnterpriseGuest->enterpriseOther)) { echo "class = 'oculto'"; } ?> id="contenedor-indique-empresa">
											<div class="form-group <?php if(! isset($EnterpriseGuest->enterpriseOther)) { echo 'margin-space'; } ?>">
												<label for="otra_empresa">Otra empresa:</label>		    	
												<input type="text" class="form-control clear" id="otra_empresa" name="otra_empresa" value="<?php if(isset($EnterpriseGuest->enterpriseOther)){ echo $EnterpriseGuest->enterpriseOther; } ?>" placeholder="Nombre empresa" required>
												<span class="help-block">
													<strong id="campo-otra_empresa" class="error"></strong>             		  
												</span>
											</div>
										</div>
									</div>
							  	</div>