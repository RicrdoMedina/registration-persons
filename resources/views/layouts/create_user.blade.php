                     <?php if(! isset($User[0])) { ?>
                     <fieldset>

                        <legend><i class="fa fa-user-plus"></i> Agregar usuario</legend>
                    <?php } 
                    if(isset($User[0])){ ?>
                    <div class="contenedor-form">
                        <input type="hidden" id="id" value="{{$User[0]->id}}" name="id">
                    <?php } ?>
                        <input type="hidden" id="token" name="_token" value="{!! csrf_token() !!}">

                        <div id="container-nombres" class="form-group margin-space clear">
                            <label for="names" class="col-sm-3 control-label">Nombres</label>

                            <div class="col-sm-8">
                                <?php if(isset($User[0])){ $nombre = $User[0]->nombre; }else{ $nombre = null; } ?>
                                {!!Form::text('nombres', $nombre, ['id' => 'names','class' => 'form-control clear-input disabled solo-letras', 'placeholder' => 'Ej. Juan', 'required' => 'required']) !!}
                                

                                
                                <span class="help-block">
                                    <strong id="nombres" class="error-msj"></strong>
                                </span>
                                
                            </div>
                        </div>

                        <div id="container-apellidos" class="form-group margin-space clear">
                            <label for="lastNames" class="col-sm-3 control-label">Apellidos</label>
                            <div class="col-sm-8">

                                 <?php if(isset($User[0])){ $apellido = $User[0]->apellido; }else{ $apellido = null; } ?>
                                 {!!Form::text('apellidos', $apellido, ['id' => 'lastNames','class' => 'form-control clear-input disabled solo-letras', 'placeholder' => 'Ej. Perez','required' => 'required']) !!}
 
                                <span class="help-block">
                                    <strong id="apellidos" class="error-msj"></strong>
                                </span>
  
                            </div>
                        </div>

                        <div id="container-rol" class="form-group margin-space clear">
                            <label for="roles" class="col-sm-3 control-label">Rol</label>

                            <div class="col-sm-8">
                                <?php
                                $rol = null;
                                if(isset($User[0]->rol)) {
                                    $rol = $User[0]->rol;
                                }
                                ?>
                                {!! Form::select('rol', $Roles, $rol, ['class'=> 'form-control disabled clear-input', 'id' => 'roles', 'placeholder' => '--- SELECCIONE ---','required' => 'required']); !!}

                                
                                <span class="help-block">
                                    <strong id="rol" class="error-msj"></strong>
                                </span>
                                
                            </div>
                        </div>
                        
                        <div id="container-email" class="form-group margin-space clear">
                            <label for="mail" class="col-sm-3 control-label">E-Mail</label>

                            <div class="col-sm-8">

                                <?php if(isset($User[0])){ $email = $User[0]->email; }else{ $email = null; } ?>
                                {!!Form::email('email', $email, ['id' => 'mail','class' => 'form-control clear-input disabled', 'placeholder' => 'example@domain.com', 'required' => 'required']) !!}

                                <span class="help-block">
                                    <strong id="email" class="error-msj"></strong>
                                </span>

                            </div>
                        </div>
                        <?php if(! isset($User[0])) { ?>
                        <div id="container-password" class="form-group margin-space clear">
                            <label for="pass" class="col-sm-3 control-label">Password</label>

                            <div class="col-sm-8">
                                <input type="password" id="pass" class="form-control clear-input no-spacio" name="password" placeholder = "Ingrese password" required>

                                
                                <span class="help-block">
                                    <strong id="password" class="error-msj"></strong>
                                </span>
                                
                            </div>
                        </div>

                        <div id="container-repita_password" class="form-group margin-space clear">
                            <label for="re_password" class="col-sm-3 control-label">Repita Password</label>
                            <div class="col-sm-8">
      
                                <input type="password" class="form-control clear-input no-spacio" id="re_password" name="repita_password" placeholder = "Repita el password">

                                
                                <span class="help-block">
                                    <strong id="repita_password" class="error-msj"></strong>
                                </span>
                                
                            </div>
                        </div>
                       

                        <div class="form-group margin-space">
                            <div class="col-sm-offset-3 col-sm-8">
                                <button type="button" id="submitRegistrarUser" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </fieldset> 
                    <?php } ?>
                <?php if(isset($User[0])){ ?>
                    </div>
                <?php } ?>