@extends('layouts.Base')

@section('content')

   @include('layouts.Heading')

    <div class="row">
        <div id="admin" class="col-md-6 col-md-offset-3 contenedor-login">

                    {!! Form::open(['class' => 'form-horizontal form-cuadrado','id' => 'form-cuadrado','role' => 'form', 'method' => 'POST', 'route' => 'auth/login']) !!}
                        <fieldset>

                            <legend><i class="fa fa-thumbs-up" aria-hidden="true"></i> Iniciar sesión</legend>

                            {!! csrf_field() !!}
                            
                            @include('layouts.Message_error')

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="inputEmail" class="col-md-4 control-label">E-Mail</label>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="inputPassword" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Recordarme.
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in"></i> Login
                                    </button>

                                    <a class="btn btn-link" href="">Olvido su password?</a>
                                </div>
                            </div>
                        </fieldset>
                    {!! Form::close() !!}

        </div>
    </div>

    <hr>
@endsection