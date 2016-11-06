<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Redirect;
use App\Http\Requests;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest',['except' => 'logout']);
    }
    public function index()
    {
        return view('auth/login');
    }
    public function store(LoginRequest $request)
    {
        //Validar las credenciales ingresadas por el usuario
        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password'],'rol' => 1,'status' => 1],$request->has('remember'))) {
            //Si el usuario es valido redireccionar 
            return Redirect::to('registrar/usuario');
        }
        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password'],'rol' => 2,'status' => 1],$request->has('remember'))) {
            //Si el usuario es valido redireccionar 
            return Redirect::to('registrar/visita');
        }

        //Sino enviar msj con los errores
        Session::flash('message_error', 'Su email o password es invalido!');
        return redirect('auth/login')->withInput($request->except('password'));
    }
    public function logout()
    {
        Auth::logout();
        return Redirect::to('auth/login');
    }
}
