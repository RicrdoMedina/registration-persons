<?php

namespace App\Http\Controllers\Admin;

use DB;
use Session;
use Carbon\Carbon;
use App\User;
use App\Rol;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;


class AdminController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        $this->middleware('accessRouteAdmin',['create','store','edit','update']);
    }
     public function home()
    {
        return view('home/index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * View: registrar / Form registrar usuarios
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        $Roles = Rol::lists('rol', 'id');

        return view('admin/registrar_usuario',compact('Roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * View: registrar / Procesa form registrar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if($request->ajax())
        {

            //Guardar user
            $User = new User;
            $User->email = $request['email'];
            $User->nombre = $request['nombres'];
            $User->apellido = $request['apellidos'];
            $User->password = $request['password'];
            $User->rol = $request['rol'];
            $User->status = 1;
                       
            $User->save();
            
            return response()->json(['status' => 1, 'usuario' => $User['nombre'].' '.$User['apellido']]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * View: consultar/usuarios
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {   
        $Roles = Rol::lists('rol', 'id');
        $Status = ['1' => 'Activo', '0' => 'Desactivado'];

        $query = User::listUsers();

        $Users = $query->paginate(10);

        if($request->ajax())
        {
            $mostrar = 10;
            if (! empty($request->mostrar)) {
                $mostrar = $request->mostrar;
            }

            $Users = $query->paginate($mostrar);

            $type_user = $request->param1;
            $value = $request->param2;

            if(! empty($type_user) && ! empty($value)) {
                $Guests = Guest::searchGuests($type_user,$value)->paginate($mostrar);
            }

            if(! empty($request->start) && ! empty($request->end)) {
                //Formateando la fecha para realizar la busqueda
                $date_start = Carbon::createFromFormat('d/m/Y', $request->start)->format('Y-m-d').' '.'00:00:00';
                $date_end = Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d').' '.'23:59:59';

                $Guests = Guest::searchGuestsForDate($type_user,$date_start,$date_end,$value)->paginate($mostrar);   
            }

            return response()->json(view('layouts.Table_users',compact('Users','Roles','Status'))->render());
        }

        return view('admin.consultarUsers', compact('Users','Roles','Status'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * View: consultar/usuarios & consultar/visitas - Modal editar user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   
        if($request->ajax())
        {
            $id = $request['id'];
            $User = User::searchUser($id);
            $Roles = Rol::lists('rol', 'id');
           
            return response()->json(view('layouts.create_user',compact('User','Roles'))->render());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        if($request->ajax())
        {
            $nombres = ucwords(strtolower($request['nombres']));
            $apellidos = ucwords(strtolower($request['apellidos']));

            //Actualizar user
            $User = User::where('id', '=', $request['id'])->update(array('email' => $request['email'],'nombre' =>  $nombres, 'apellido' => $apellidos, 'rol' => $request['rol']));
            
            return response()->json(['status' => 1, 'usuario' => $nombres.' '.$apellidos]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
