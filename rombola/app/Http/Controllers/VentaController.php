<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoFinanciera;
use App\Persona;
use App\Cliente;
use App\Telefono;
use App\Automovile;
use App\Marca;
use App\Operaciones;
use App\Conyuge;
use App\Garante;
use App\Autocero;
use App\Autosusado;
use App\Estadocero;
use App\Estadousado;
use DB;


class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $venta_operac = DB::table('operaciones')
      ->join('ventas','operaciones.id_operacion','ventas.operacion_venta')
      ->join('personas','operaciones.persona_operacion','personas.idpersona')
      ->join('clientes','personas.idpersona','clientes.cliente_persona')
      ->get();

        return view('venta',compact('venta_operac'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $tipo_finan = TipoFinanciera::pluck('nombretipo');
      $nombapell = Persona::pluck('nombre_apellido');

      $autos=Automovile::select("*")   
      ->join('marcas','marcas.id_marca','automoviles.marca_id')
      ->join('autoceros','autoceros.auto_id','automoviles.id_auto')
      ->paginate(5);
      

     $auto_usado=Automovile::select("*")     
     ->join('marcas','marcas.id_marca','automoviles.marca_id')
     ->join('autosusados','autosusados.auto_id','automoviles.id_auto')
     ->paginate(5);
     

     $marcas=Marca::All();

      return view('venta.create',compact('tipo_finan','nombapell','autos','marcas','auto_usado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
      public function store(Request $request)
    {
      
      $nombre = $request->get('nuevo_nombre');
      $apellido = $request->get('nuevo_apellido');

      $can = $request->get('cancer');

      if ($can == 'nuevo') {
        
      //insert Persona-Cliente
      $share = new Persona([
        'dni' => $request->get('nuevo_dni'),
        'nombre' => $request->get('nuevo_nombre'),
        'apellido'=> $request->get('nuevo_apellido'),
        'nombre_apellido'=> $nombre." ".$apellido,
        'email'=> $request->get('nuevo_email'),
        'act_empresa'=> $request->get('nuevo_act_empresa'),
        'domicilio_empleo'=> $request->get('nuevo_domicilio_empleo'),
        'profesion'=> $request->get('nuevo_profesion')

      ]);
      $share->save();

      $dni=$request->get('nuevo_dni');
      
      $pers = Persona::where("dni","=",$dni)->select("idpersona")->get();
    
      foreach ($pers as $item) {}

      $relacion= $request->get('check_dependencia');
      if ($request->get('check_dependencia') == "on") {
        $relacion = 0;
      }

      $idpers=$item->idpersona;
      $cliente = new Cliente([
        'cliente_persona' => $idpers,
        'fecha_nacimiento' => $request->get('nuevo_fecha_nac'),
        'domicilio'=> $request->get('nuevo_domicilio'),
        'estado_civil'=> $request->get('nuevo_estado_civil'),
        'relacion_dependencia'=> $request->get('check_dependencia'),
        'antiguedad'=> $request->get('nuevo_antiguedad'),
        'ingresos_mensuales'=> $request->get('nuevo_ingresos_mensuales'),
        'nombre_padre'=> $request->get('nuevo_nombre_padre'),
        'nombre_madre'=> $request->get('nuevo_nombre_madre'),
        'estado_ficha'=> "Completa",
        'visible'=> true,
        'id_user'=> $request->get('id_user'),
        'fecha'=> date("d-m-Y")
      ]);
      $cliente->save();
      //--/insert Persona-Cliente
      if($request->get('nuevo_cel_1') != null)
      {
      $tel = new Telefono([
        'personas_telefono' => $idpers,
        'num_tel' => $request->get('nuevo_cel_1'),
        'tipo' => '2'
      ]); 
      $tel->save();
      }
     
      $fecha_oper=$request->get('fecha_oper');
      $operacion = new Operaciones([
        'persona_operacion' => $idpers,
        'estado' => "En Negociación",
        'fecha_oper'=> $fecha_oper,
        'aviso'=> 0,
        'visible' => 1,
      ]);
      $pers = Persona::where("dni","=",$dni)->select("idpersona")->get();
      $operacion->save();
      }
      else
      {

        $nya = $request->get('nya_cliente');
        $idpersona = Persona::where("nombre_apellido","=",$nya)->select("idpersona","dni")->get();
        
        foreach ($idpersona as $items) {
        }
        $idpersona = $items->idpersona;
        $dni=$items->dni;

        $fecha_oper=$request->get('fecha_oper');
        $operacion = new Operaciones([
        'persona_operacion' => $idpersona,
        'estado' => "En Negociación",
        'fecha_oper'=> $fecha_oper,
        'aviso'=> false,
        'visible' => true,
        ]);
       $operacion->save();

      }
    
      
     //--insert Persona-Conyuge

       $nombre_conyuge = $request->get('conyuge_nombre');
       $apellido_conyuge = $request->get('conyuge_apellido');

       $can = $request->get('input_conyuge');
       if ($can == 'si') {

       $share = new Persona([
          'dni' => $request->get('conyuge_dni'),
          'nombre' => $request->get('conyuge_nombre'),
          'apellido'=> $request->get('conyuge_apellido'),
          'nombre_apellido'=> $nombre_conyuge." ".$apellido_conyuge,
          'email'=> "",
          'act_empresa'=> $request->get('conyuge_act_empresa'),
          'domicilio_empleo'=> $request->get('conyuge_domicilio_empleo'),
          'profesion'=> $request->get('conyuge_profesion')
        ]);
        $share->save();

        $dni_conyuge=$request->get('conyuge_dni');
        
        $pers = Persona::where("dni","=",$dni_conyuge)->select("idpersona")->get();
      
        foreach ($pers as $item) {
          //echo "$item->idpersona";
        }
        $idpers=$item->idpersona;
        //insert Persona-Conyuge
        $conyuge = new Conyuge([
          'idconyuge_persona' => $idpers,
          'fecha_nacimiento' => $request->get('conyuge_fecha_nac'),
          'domicilio'=> $request->get('conyuge_domicilio'),
          'estado_civil'=> $request->get('conyuge_estado_civil'),
          'visible'=> 1,
        ]);
        $conyuge->save();

        if($request->get('conyuge_telefono_trabajo') != null)
        {
        $tel = new Telefono([
          'personas_telefono' => $idpers,
          'num_tel' => $request->get('conyuge_telefono_trabajo'),
          'tipo' => '3'
        ]);
        $tel->save();
        }

      }
      
      //--/insert Persona-Garante
      
      $nombre_garante = $request->get('garante_nombre');
      $apellido_garante = $request->get('garante_apellido');

      $can = $request->get('input_garante');
      if ($can == 'si') {

        $share = new Persona([
            'dni' => $request->get('garante_dni'),
            'nombre' => $request->get('garante_nombre'),
            'apellido'=> $request->get('garante_apellido'),
            'nombre_apellido'=> $nombre_garante." ".$apellido_garante,
            'email'=> "",
            'act_empresa'=> $request->get('garante_act_empresa')
          ]);
          $share->save();
  
          $dni=$request->get('garante_dni');
          
          $pers = Persona::where("dni","=",$dni)->select("idpersona")->get();
        
          foreach ($pers as $item) {
            //echo "$item->idpersona";
          }
          $idpers=$item->idpersona;
          //insert Persona-Garante
          $garante = new Garante([
            'idgarante_persona' => $idpers,
            'fecha_nacimiento' => $request->get('garante_fecha_nac'),
            'domicilio'=> $request->get('garante_domicilio'),
            'estado_civil'=> $request->get('garante_estado_civil'),
            'visible'=> 1
          ]);
          $garante->save();

          if($request->get('garante_cel_1') != null)
          {
          $tel = new Telefono([
            'personas_telefono' => $idpers,
            'num_tel' => $request->get('garante_cel_1'),
            'tipo' => '2'
          ]);
          $tel->save();
          }

          }

          /*insert Auto 0 KM -------*/

          $idauto0km=null;
          if ($request->get('estado_toggle')=="stock") {
            
          $idauto0km = $request->get('select_cero');

          } else {

            if ($request->get('estado_toggle')=="lista") {
      
            $idmarca=$request->get('marca');
                  

            $marca = Marca::where("nombre","=",$idmarca)->select("id_marca")->get();
            
            foreach ($marca as $item) {}   
                  
            $idmarcas=$item->id_marca;

            $automovil = new Automovile([
              'marca_id' => $idmarcas, 
              'modelo' => $request->input('modelo'),
              'version'=> $request->input('version'),
              'color'=> '',      
              'precio'=> 0,  
              'ficha' => 'Incompleta',
              'visible'=> 1
               ]);
              
              $automovil->save();
            
              $id0km = DB::table('automoviles')
              ->select('id_auto')
              ->orderBy('created_at','DESC')
              ->take(1)
              ->get();  

            foreach ($id0km as $key) {}

            $marca = Estadocero::where("nombreEstado","=","En Camino")->select("id_estadoCero")->get();
            foreach ($marca as $marc) {}
            
            $auto_cero = DB::table('autoceros')
            ->insertGetId([
            'vin' => null,
            'auto_id' => $key->id_auto, 
            'estadoCero_id'=> $marc->id_estadoCero
             ]);
            // dd($save);

            $idauto0km = $auto_cero;
          }
        }

          /*insert Auto Usado -------*/
          $idusado=null;
        if ($request->get('check_usado')=="si") {
          $idusado = $request->get('check_select_usado');
          $consulta = Automovile::where("dominio","=",$idusado)->select("id_auto")->get();
          foreach ($consulta as $item) {}
          $idusado = $item->id_auto;
          }
          else{
            $idusado = null;
          }

           /*insert Auto Entregado -------*/

           if($request->get('valor_entregado')=="si"){

            $marca_entregado=$request->get('marca_entregado');
            
            $idmarca = Marca::where("nombre","=",$marca_entregado)->select("idmarca")->get();
        
            foreach ($idmarca as $item) {}         
            $idmarcas=$item->idmarca;

            $usado = new Automovile([
              'idmarca' => $idmarcas, 
              'modelo' => $request->get('modelo_entregado'),
              'descripcion'=> "",
              'color'=> $request->get('color_entregado'),
              'precio'=>0,         
              'estado'=> "A Designar",
              'dominio' => $request->get('dominio_entregado'),
              'visible'=> 1
            ]);
            $usado->save();

          $dominio=$request->get('dominio');
          $car = Automovile::where("dominio","=",$dominio)->select("id_auto")->get();
                       
          foreach ($car as $item) {}
            
            $idauto=$item->id_auto;
            $nuevo = new Autosusado([
              'id_auto' => $idauto,            
              'titular'=> $request->get('nomb_titular_entregado'),
              'anio' => $request->get('anio_entregado'),
              'kilometros' => 0,
              'chasis_num'=> $request->get('chasis_num_entregado'),
              'motor_num'=> $request->get('motor_num_entregado'),
            ]);
            $nuevo->save(); 

            $id_autoentragado = $nuevo;

            }
            else{
              $id_autoentragado=null;
            }

            //insert Venta -------
            $p = DB::table('ventas')
            ->select('codigo','cod_part1','cod_part2')
            ->orderBy('created_at','DESC')
            ->take(1)
            ->get();
            $cant=count($p);

            if ($cant==0) {
        
            $part1 = '000';
            $part2 = '001';
            $codigo = "V-".$part1."-".$part2 ;
            }
            else {
            foreach ($p as $itemcod) {}
            $part1 = $itemcod->cod_part1;
            $part2 = (int)$itemcod->cod_part2;

            if ($part2 <100) {
                $part2 = "00".($part2+1);
            }
            else {
                $part2 = (string)($part2+1);
            }

            $codigo = "V-"."000"."-".$part2 ;
            }

          
          $venta_operac = DB::table('operaciones')
          ->select('id_operacion')
          ->join('personas','operaciones.persona_operacion','personas.idpersona')
          ->where('personas.dni','=', $dni)
          ->orderBy('id_operacion','DESC')
          ->take(1)
          ->get();
          
          $total = $request->get('restotal');
          $valor_auto = $request->get('valor_auto_vendido');
          $resto = $total - $valor_auto;
          
          foreach ($venta_operac as $item) {}
            
            $venta = DB::table('ventas')
            ->insertGetId([
            'operacion_venta' => $item->id_operacion,
            'idventa_autousado' => $idusado,
            'idventa_auto0km' => $idauto0km,
            'idventa_autoentregado' => $id_autoentragado,
            'precio_auto_vendido' => $request->get('valor_auto_vendido'),
            'efectivo' => $request->get('inpefectivo'),
            'cod_part1' => $part1,
            'cod_part2' => $part2,
            'codigo' => $codigo,
            'resto' =>$resto,
            'resto_financ' =>$request->get('resto_financ'),
            'cant_cuotas' =>$request->get('cant_cuotas'),
            'monto_cuota' =>$request->get('monto'),
            'visible' =>1,
            'estado' =>'En Negociacion',
            'id_user'=> $request->get('id_user'),
            'tipo'=>"financiacion"
            ]);
         
          //insert Cheque -------
          $cheque = $request->get('valor_cheque');
          if ($cheque == 'si') {

            $chequenuevo = DB::table('cheques')
            ->insertGetId([
              'cheque_venta' => $venta,
              'numero' => $request->get('numero_cheque'),
              'fecha' => $request->get('fecha_cheque'),
              'banco' => $request->get('banco'),
              'importe' => $request->get('importe_cheque'),
              'estado' => "",
              ]);
          }
          /*   dd("HOLA");*/

      return redirect('/venta')->with('success', 'Venta Guardada');
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeEstado(Request $request)
    {
      $idventa= $request->get('state');
      $estado = $request->get('estado');

      DB::table('ventas')
            ->where('idventa',"=",$idventa)
            ->update([
                'estado'=>$estado
        ]);
      
      $resultado= "cargado";
      return response()->json($resultado);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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