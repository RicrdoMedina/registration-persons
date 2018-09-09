							<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" id="token"> 
					    	<input type="hidden" id="id" value="" name="id">
							<div <?php if(isset($Guest->id)) { echo "class = 'oculto'"; }else{ echo "class = 'data-user'"; } ?> id="capturar-foto">
								<fieldset>
						        <legend><i class="fa fa-hand-o-right" aria-hidden="true"></i> Foto del usuario</legend>
								<div class="row">
							        <div class="col-md-7 col-sm-7 col-xs-7">
							                <div class="col-md-12 col-sm-8 col-xs-12">
									            <div id="webcam">
									            </div>
									            <div style="margin:5px;">
                              <img src="{{ url('/') }}/js/ScriptCam/webcamlogo.png" style="vertical-align:text-top"/>
									                <select id="cameraNames" size="1" onChange="changeCamera()" style="width:245px;font-size:10px;height:25px;">
									                </select>
									            </div>
									        </div> 
							        </div>
							        <div class="col-md-5 col-sm-5 col-xs-12">
							        	<div class="col-sm-12">
								        	<!-- Button para capturar form-->
								           	<p><input id="imageBase64" type="hidden" name="imageBase64" data-photo="0"/></p>
								           	<p><img id="image"  class="foto-usuario img-thumbnail" alt="Foto de usuario!" style="width:200px;height:153px;"/></p>
								       	</div>
								      
										  	<div class="col-sm-12">
								        	<!-- Button para capturar form-->
								           	<!--<p><button class="btn btn-small" id="btn1" onclick="base64_tofield()">Snapshot to form</button></p>-->
								           	<p><button type="button" class="btn btn-info" id="btn2" onclick="base64_tofield_and_image($.scriptcam.getFrameAsBase64())"><i class="fa fa-camera"></i> Capturar</button></p>
								           	<span id="error-captura" class="msj-captura oculto">
					             		  		Debe capturar la foto del usuario.
					            			</span>
								       	</div>
								        
							        </div>
							    </div>
								</fieldset>
							</div>
						 
						 
							<div class="data-user">
							<fieldset>
					        <legend><i class="fa fa-hand-o-right" aria-hidden="true"></i> Datos del usuario</legend>
					        	@include('layouts.Form_datos_personales')
							</fieldset>
							</div>