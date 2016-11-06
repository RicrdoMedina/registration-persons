<?php

namespace App\Http\Controllers\Admin\User;

use DB;
use Session;
use Carbon\Carbon;
use App\Guest;
use App\TypeGuest;
use App\TypeVisit;
use App\MotiveVisit;
use App\MotiveClient;
use App\Destination;
use App\DescriptionVisit;
use App\Enterprise;
use App\EnterpriseGuest;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\EditarVisitaRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    public function home()
    {
        return view('home/index');
    }
    public function noAccess()
    {
        return view('errors/no_access');
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
        $query = Guest::listGuests();
        $Clients = Guest::where('id_type_guest', '=', 1)->count();
        $Visits = Guest::where('id_type_guest', '=', 2)->count();

        $Guests = $query->paginate(10);

        if($request->ajax())
        {
            $mostrar = 10;
            if (! empty($request->mostrar)) {
                $mostrar = $request->mostrar;
            }

            $Guests = $query->paginate($mostrar);

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

            return response()->json(view('layouts.Table_guests',compact('Guests','Visits','Clients'))->render());
        }

        return view('user.consultarUsuarios', compact('Guests','Visits','Clients'));
    }
    /**
     * Display a listing of the resource.
     *
     * View: consultar/visitas
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function visits(Request $request)
    {
        $query = DescriptionVisit::listVisits();

        $MotiveVisit = MotiveVisit::lists('motive_visit', 'id');

        $Guests = $query->paginate(10);

        if($request->ajax())
        {
            $mostrar = 10;
            if (! empty($request->mostrar)) {
                $mostrar = $request->mostrar;
            }

            $Guests = $query->paginate($mostrar);

            $type_user = $request->param1;
            $value = $request->param2;

            if(! empty($type_user) && ! empty($value)) {
                $Guests = DescriptionVisit::searchVisits($type_user,$value)->paginate($mostrar);
            }

            if(! empty($request->start) && ! empty($request->end)) {
                //Formateando la fecha para realizar la busqueda
                $date_start = Carbon::createFromFormat('d/m/Y', $request->start)->format('Y-m-d').' '.'00:00:00';
                $date_end = Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d').' '.'23:59:59';
                $Guests = DescriptionVisit::searchVisitsForDate($type_user,$date_start,$date_end,$value)->paginate($mostrar); 
            }

            return response()->json(view('layouts.Table_visits',compact('Guests','MotiveVisit','MotiveClient'))->render());
        }

        return view('user.consultarVisitas', compact('Guests','MotiveVisit','MotiveClient'));
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
        $MotiveVisit = MotiveVisit::lists('motive_visit', 'id');
        $Destination = Destination::lists('destination', 'id');
        $Enterprise = Enterprise::lists('enterprise', 'id_enterprise');

        return view('user.registrar',compact('MotiveVisit','MotiveClient','Destination','Enterprise'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * View: registrar / Procesa form registrar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax())
        {
        
            if(! empty($request['cedula'])) {
            //Verificar si el usuario ya esta registrado

                $cedula = trim($request['cedula']);//Eliminar espacios

                //Obtener el registro del usuario mediante la cedula ingresada
                $Persona = Guest::where( 'cedula' , '=' , $cedula)->get()->first();
                if (! empty($Persona->id)) {
                    $EnterpriseGuest = EnterpriseGuest::where( 'guest_id' , '=' , $Persona->id)->get()->first();
                    $Enterprise = Enterprise::find($EnterpriseGuest->enterprise_id);
                }
                
                if(count($Persona) > 0) {
                    $result = 1;
                    return response()->json(['status' => $result, 'cedula' => $Persona['cedula'], 'nombres' => $Persona['names'], 'apellidos' => $Persona['lastNames'],'foto' => $Persona['photo_src'], 'tipo' => $Persona['id_type_guest'],'empresa' => $Enterprise['enterprise'],'empresaOtra' => $EnterpriseGuest['enterpriseOther']]);
                }else{
                    $result = 0;
                    return response()->json(['status' => $result, 'cedula' => $cedula]);
                }
            }

            if(! empty($request['id'])) {

                $cedula = $request['id'];

                //Obtener el registro del usuario mediante la cedula ingresada
                $Persona = Guest::where( 'cedula' , '=' , $cedula)->get()->first();
                if(count($Persona) > 0) {
                //Si el usuario esta registrado solo se registra datos de la visita
                
                    //Guardar datos visita del invitado en la bd
                    $DescriptionVisit = new DescriptionVisit;
                    $DescriptionVisit->id_guest_description = $Persona->id;
                    $DescriptionVisit->id_destination = $request['destino'];
                    $DescriptionVisit->id_type_visit = $request['visita'];
                    $DescriptionVisit->id_motive = $request['motivo'];
                    $DescriptionVisit->motiveOther = $request['otro_motivo'];
                       
                    $DescriptionVisit->save();

                    return response()->json(['status' => 1, 'usuario' => $Persona->names.' '.$Persona->lastNames]);
  
                }else{//usuario no esta registrado

                    //Decodificar el base64.
                    $foto = base64_decode($request['imageBase64']);
                    //Asignar el directorio donde se guardara la imagen
                    $directorio = $_SERVER['DOCUMENT_ROOT'].'/images/photo/';
                    //Guardar la fecha y hora actual
                    $fecha = date("d.m.y-h.i.s");
                    //Asignar nombre a la imagen formato cedula-fecha actual y hora.png 
                    $nombre_photo = $cedula.'-'.$fecha.'.png';
                    //Generar la ruta completa de la imagen
                    $ruta_photo = $directorio.$nombre_photo;
                    $url = \URL::to('/').'/images/photo/';
                    
                    DB::beginTransaction();
                    try
                    {
                        //Guardar datos personales del invitado en la bd
                        $Guest = new Guest;
                        $Guest->cedula = $cedula;
                        $Guest->names =  $request['nombres'];
                        $Guest->lastNames = $request['apellidos'];
                        $Guest->photo_src = $url.$nombre_photo;
                        $Guest->id_type_guest = $request['tipo_usuario'];
                        $Guest->save();

                        $CompanyGuest = new EnterpriseGuest;
                        $CompanyGuest->guest_id = $Guest->id;
                        $CompanyGuest->enterprise_id = $request['empresa'];
                        $CompanyGuest->enterpriseOther = $request['otra_empresa'];
                        $CompanyGuest->save();
            
                        //Guardar datos visita del invitado
                        $DescriptionVisit = new DescriptionVisit;
                        $DescriptionVisit->id_guest_description = $Guest->id;
                        $DescriptionVisit->id_destination = $request['destino'];
                        $DescriptionVisit->id_type_visit = $request['visita'];
                        $DescriptionVisit->id_motive = $request['motivo'];
                        $DescriptionVisit->motiveOther = $request['otro_motivo'];
                       
                        $DescriptionVisit->save();

                        DB::commit();

                        //Escribir la imagen capturada
                        file_put_contents($ruta_photo, $foto);

                        return response()->json(['status' => 1, 'usuario' => $Guest->names.' '.$Guest->lastNames]);
                    }
                    catch(Exception $ex) 
                    {
                        DB::rollback();

                        throw $ex;
                    }
                }
            }
        }
         
    }

     /**
     * Save in sesion a user.
     *
     * View: consultar/usuarios
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     **/
    public function searchUser(Request $request)
    {
        if($request->ajax())
        {
            Session::put('id_user', $request['id']);
            $result = 1; 
            return response()->json(['status' => $result]);
        }
    }
     /**
     * Show total of users.
     *
     * 
     * @return \Illuminate\Http\Response
     **/
    public function totalRegistros()
    {
       $Guest = Guest::all()->count();
       $DescriptionVisit = DescriptionVisit::all()->count();
       return response()->json(['total_usuarios' => $Guest,'total_visitas' => $DescriptionVisit]);

        // $value = '2015-12-27 06:07:06';

        // $p = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d/m/Y');
    }
   
     /**
     * Show the form for editing the specified resource.
     *
     * View: consultar/usuarios & consultar/visitas - Modal editar user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editUser(Request $request)
    {   
        if($request->ajax())
        {
            $id = $request['id'];
            $Guest = Guest::where('id', '=', $id)->get()->first();
            $Enterprise = Enterprise::lists('enterprise', 'id_enterprise');
            $EnterpriseGuest = EnterpriseGuest::where( 'guest_id' , '=' , $Guest->id)->get()->first();
            
            return response()->json(view('layouts.Form_datos_personales',compact('Guest','Enterprise','EnterpriseGuest'))->render());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * View: usuario/{user} & consultar/visitas - Modal editar visitas
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editVisit(Request $request)
    {   
        if($request->ajax())
        {   
            $id = $request->id;
            $DescriptionVisit = DescriptionVisit::find($id);
            $Guest = Guest::find($DescriptionVisit->id_guest_description);
            $visita = DescriptionVisit::editVisit($id);

            $MotiveVisit = MotiveVisit::lists('motive_visit', 'id');
            $Destination = Destination::lists('destination', 'id');

        return response()->json(view('layouts.Description_visits',compact('Guest','visita','MotiveVisit','Destination'))->render());
        }
    }

    /**
     * Display a listing of the resource for a user.
     *
     * View: usuario/{user}
     *
     * @param  int  $id string
     * @return \Illuminate\Http\Response
     */
    public function userVisits(Request $request)
    {   
        $id = Session::get('id_user');
        $TypeGuest = TypeGuest::lists('type_guest', 'id');
        $Guest = Guest::searchGuest($id);
        $mostrar = 10;
        $query = Guest::listVisits($Guest[0]->id);

            if($request->ajax())
            {   
                if(! empty($request->mostrar)) {
                    $mostrar = $request->mostrar;
                }
                $listVisits = $query->paginate($mostrar);
                $value = $request->param2;
                if(!empty($value)) {
                    
                    $listVisits = Guest::searchVisit($Guest[0]->id,$value)->paginate();
                }
                if(! empty($request->start) && ! empty($request->end)) {
                    //Formateando la fecha para realizar la busqueda
                    $date_start = Carbon::createFromFormat('d/m/Y', $request->start)->format('Y-m-d').' '.'00:00:00';
                    $date_end = Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d').' '.'23:59:59';

                    $listVisits = Guest::searchVisitForDate($Guest[0]->id,$date_start,$date_end,$value)->paginate($mostrar);   
                }

                return response()->json(view('layouts.Table_description_visits',compact('Guest','listVisits','TypeGuest'))->render());
            }

        $listVisits = $query->paginate(10);
        return view('user.visitas',compact('Guest','listVisits','TypeGuest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->ci;
            $Guest = Guest::where('cedula', '=', $id)->get()->first();
            $EnterpriseGuest = EnterpriseGuest::where('guest_id', '=', $Guest->id)->get()->first();
            
            DB::beginTransaction();
            try
            {
                /*$Guest->fill($request->all());
                $Guest->push();*/

                $Guest->cedula = $request['cedula'];
                $Guest->names =  $request['nombres'];
                $Guest->lastNames = $request['apellidos'];
                $Guest->id_type_guest = $request['tipo_usuario'];
                $Guest->save();

                /*$affectedRows = EnterpriseGuest::where('id_enterprise_guest', '=', $Guest->id)->update(['enterprise_id' => $request['empresa'], 'enterpriseOther' => ucfirst($request['otra_empresa'])]);*/
                
                $EnterpriseGuest->enterprise_id = $request['empresa'];
                $EnterpriseGuest->enterpriseOther = ucfirst($request['otra_empresa']);
                $EnterpriseGuest->save();

                $result = 1;
                DB::commit();
            }
            catch(Exception $ex) 
            {
                DB::rollback();

                throw $ex;
            }

            return response()->json(['status' => $result, 'usuario' => $Guest->names.' '.$Guest->lastNames]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateVisit(EditarVisitaRequest $request)
    {
        if($request->ajax())
        {
            $id = $request->id;
            $DescriptionVisit = DescriptionVisit::findOrFail($id);
            $DescriptionVisit->id_destination = $request['destino'];
            $DescriptionVisit->id_type_visit = $request['visita'];
            if( empty($request['motive_client'])) {
                $DescriptionVisit->id_motive = $request['motivo'];
                $DescriptionVisit->motiveother = $request['otro_motivo'];
            }else{
                $DescriptionVisit->id_motive = $request['motive_client'];
                $DescriptionVisit->motiveother = $request['motive_other_client'];
            }
            $DescriptionVisit->save();
            $Guest = Guest::findOrFail($DescriptionVisit->id_guest_description);
            $result = 1;

            return response()->json(['status' => $result,'usuario' => $Guest->names.' '.$Guest->lastNames]);
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
