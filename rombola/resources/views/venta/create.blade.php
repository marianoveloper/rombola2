@extends('adminlte::layouts.app')


@section('seccion1')
<div class="container-fluid spark-screen">
    {!! Form::open(['route'=>'pre-venta.store','method'=>'post','class'=>'form-group']) !!}
    {!! Html::script('js/venta.js') !!}
    <div class="row">
        <div class="col-md-14 col-md-offset-0">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Inicio de Operación</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-xs btn-success" onclick="history.back(1);">
                            <i class="fa fa-chevron-left"></i> VOLVER</a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 col-lg-offset-2 col-lg-3">
                            <div class="form-group">
                                <div class='input-group date'>
                                    @php
                                    $fecha = date("d-m-Y");
                                    @endphp
                                    <input type="text" class="form-control" id="fecha_oper" name="fecha_oper" value="{{$fecha}}"
                                        disabled>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-offset-2 col-lg-3">
                            <input type="text" maxlength="125" class="form-control" id="nom_vendedor" disabled="disabled"
                                value="{{ Auth::user()->name }}">
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>



    <div class="row">
        <div class="col-md-14 col-md-offset-0">
            <div class="box box-primary">
                <div ALIGN="left" class="box-header with-border">
                    <h3 class="box-title">Información del Cliente</h3>
                </div>

                <div class="box-body">

                    <input type="text" id="cancer" name="cancer" style="display:none">
                    <input type="text" id="tipodni" name="tipodni" style="display:none">
                    <div class="row margenBoot-25">
                        <div class="col-xs-14 col-lg-6">
                            <button onclick="enable_buscar()" type="button" class="btn btn-primary btn-block" style="margin-bottom: 10%;">Buscar
                                Cliente</button>
                            <section id="buscar" style="display:none">
                                <select id="dnis" onchange="obtenervalue()" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-size="2">
                                    @foreach ($nombapell as $item)
									<option value="{{$item}}">{{$item}}</option>
									@endforeach
                                </select>

                                <br><br><br><br><br><br><br>
                            </section>
                        </div>
                        <div class="col-xs-14 col-lg-6">
                            <button onclick="enable_nuevo()" type="button" class="btn btn-primary btn-block" style="margin-bottom: 10%;">Nuevo
                                Cliente</button>
                        </div>
                    </div>
                    <section id="nuevo" style="display:none">
                        <div class="row margenBoot-25">
                            <div class="col-xs-12 col-lg-6">
                                <div class="form-group">
                                    <label><strong>*DNI</strong></label>
                                    <input type="number" class="form-control" id="nuevo_dni" name="dni" required>
                                </div>
                                <div class="form-group">
                                    <label><strong>*Nombres</strong></label>
                                    <input type="text" class="form-control" id="nuevo_nombre" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label><strong>*Apellidos</strong></label>
                                    <input type="text" class="form-control" id="nuevo_apellido" name="apellido" required>
                                </div>
 <div class="form-group">
                                        <label><strong>*Fecha de Nacimiento</strong></label>
                                        <input type="date" class="form-control" id="nuevo_garante_fecha_nac" name="garante_fecha_nac">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>*Estado Civil</strong></label>
                                        <select id="estado_civil" name="nuevo_estado_civil" class="form-control form-control-sm">
                                            <option>Soltero</option>
                                            <option>Convive</option>
                                            <option>Casado</option>
                                            <option>Divorciado</option>
                                            <option>Viudo</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-xs-12 col-lg-6">
                                <div class="form-group">
                                    <label><strong>*Correo Electrónico</strong></label>
                                    <input type="email" placeholder="email@gmail.com" class="form-control" id="nuevo_email"
                                        name="nuevo_email" required>
                                </div>
                                <div class="form-group">
                                    <label><strong>*Celular</strong></label>
                                    <input type="text" class="form-control" id="nuevo_cel_1" name="nuevo_cel_1" required>
                                </div>
                                <div class="form-group">
                                        <label><strong>Otro</strong>(tel. fijo o celular)</label>
                                        <input type="text" class="form-control" id="garante_cel_2" name="garante_cel_2">
                                    </div>
                                    
                                        <div class="form-group">
                                            <label><strong>*Domicilio</strong></label>
                                            <input type="text" class="form-control" id="garante_domicilio" name="garante_domicilio">
                                        </div>
                                <div class="form-group">
                                    <label><strong>*Actividad/Empresa</strong></label>
                                    <input type="text" class="form-control" id="nuevo_act_empresa" name="nuevo_act_empresa"
                                        required>
                                </div>
                            </div>
                        </div>


                </div>
                <div class="box-footer">

                    <div class="box box-default">
                        <div ALIGN="left" class="box-header with-border">
                            <h4 class="box-title">¿Convive? </h4>
                            <input id="check_conyuge" onchange="validar_check_conyuge(this);" type="checkbox" data-style="slow" data-toggle="toggle" data-size="mini" data-on="Si" data-off="No">
                        </div>
                        <section id="conyuge" style="display:none" class="box box-primary">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row margenBoot-25">
                                <div class="col-xs-12 col-lg-6">
                                    <div class="form-group">
                                        <label><strong>*DNI</strong></label>
                                        <input type="number" class="form-control" id="conyuge_dni" name="conyuge_dni">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>*Nombres</strong></label>
                                        <input type="text" class="form-control" id="conyuge_nombre" name="conyuge_nombre">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>*Apellidos</strong></label>
                                        <input type="text" class="form-control" id="conyuge_apellido" name="conyuge_apellido">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>*Fecha de Nacimiento</strong></label>
                                        <input type="date" class="form-control" id="conyuge_fecha_nac" name="conyuge_fecha_nac">
                                    </div>

                                </div>
                                <div class="col-xs-12 col-lg-6">
                                    <div class="form-group">
                                        <label><strong>*Celular</strong></label>
                                        <input type="text" class="form-control" id="conyuge_cel_1" name="conyuge_cel_1">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Otro</strong>(tel. fijo o celular)</label>
                                        <input type="text" class="form-control" id="conyuge_cel_2" name="conyuge_cel_2">
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label><strong>*Domicilio</strong></label>
                                            <input type="text" class="form-control" id="conyuge_domicilio" name="conyuge_domicilio">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>*Actividad/Empresa</strong></label>
                                            <input type="text" class="form-control" id="conyuge_act_empresa" name="conyuge_act_empresa">
                                        </div>

                                    </div>
                                </div><!-- /.modal-content -->
                            </div>
                        </section>
                    </div>


                    <div class="box box-default">
                        <div ALIGN="left" class="box-header with-border">
                            <h4 class="box-title">Información del Garante</h4>
                                <input id="ingarante" onchange="validar_check_garante(this);" type="checkbox" data-style="slow" data-toggle="toggle" data-size="mini" data-on="Si" data-off="No">


                        </div>
                        <section id="garante" style="display:none" class="box box-primary">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row margenBoot-25">
                                <div class="col-xs-12 col-lg-6">
                                    <div class="form-group">
                                        <label><strong>*DNI</strong></label>
                                        <input type="number" class="form-control" id="garante_dni" name="garante_dni">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>*Nombres</strong></label>
                                        <input type="text" class="form-control" id="garante_nombre" name="garante_nombre">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>*Apellidos</strong></label>
                                        <input type="text" class="form-control" id="garante_apellido" name="garante_apellido">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>*Fecha de Nacimiento</strong></label>
                                        <input type="date" class="form-control" id="garante_fecha_nac" name="garante_fecha_nac">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>*Estado Civil</strong></label>
                                        <select id="estado_civil" name="estado_civil" class="form-control form-control-sm">
                                            <option>Soltero</option>
                                            <option>Convive</option>
                                            <option>Casado</option>
                                            <option>Divorciado</option>
                                            <option>Viudo</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-xs-12 col-lg-6">
                                    <div class="form-group">
                                        <label><strong>*Celular</strong></label>
                                        <input type="text" class="form-control" id="garante_cel_1" name="garante_cel_1">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Otro</strong>(tel. fijo o celular)</label>
                                        <input type="text" class="form-control" id="garante_cel_2" name="garante_cel_2">
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label><strong>*Domicilio</strong></label>
                                            <input type="text" class="form-control" id="garante_domicilio" name="garante_domicilio">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>*Actividad/Empresa</strong></label>
                                            <input type="text" class="form-control" id="garante_act_empresa" name="garante_act_empresa">
                                        </div>

                                    </div>
                                </div><!-- /.modal-content -->
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-14">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Vehículo que Adquiere</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row margenBoot-25">
                        <div class="col-xs-14 col-lg-6">
                            <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-0km" style="margin-bottom: 10%;">0 KM</button>
                        </div>
                        <div class="col-xs-14 col-lg-6">
                            <button onclick="enable_usado()" type="button" class="btn btn-success btn-block" style="margin-bottom: 10%;">USADO</button>
                            
                            <section id="buscar_usados" style="display:none">
                                    <select id="select_marcas" onchange="obtenervalue()" class="selectpicker" data-live-search="true" data-width="100%" data-size="2">
                                               <!-- @foreach ($nombapell as $item)
                                                <option value="{{$item}}">{{$item}}</option>
                                                @endforeach -->
                                    </select>
                                    <br><br><br><br><br><br><br>
                                    <input type="text" id="modelousado" name="modelousado" style="display:none">
                                    </section>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.col -->
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Forma de Pago</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-lg-4">
                                <div class="row margenBoot-25">
                                    <div class="col-xs-12 col-lg-10">
                                        <div class="form-group">
                                            <label><strong>Seña</strong></label>
                                            <input type="text" maxlength="150" class="form-control" id="inp-senna"
                                                placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row margenBoot-25">
                                    <div class="col-xs-12 col-lg-10">
                                        <div class="form-group">
                                            <label><strong>Valor de Auto que entrega</strong></label>
                                            <input type="text" maxlength="150" class="form-control" id="inp-vehiculo"
                                                placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row margenBoot-25">
                                    <div class="col-xs-12 col-lg-10">
                                        <div class="form-group">
                                            <label><strong>Contado</strong></label>
                                            <input type="text" maxlength="150" class="form-control" id="inp-contado"
                                                placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row margenBoot-25">
                                    <div class="col-xs-12 col-lg-10">
                                        <div class="form-group">
                                            <br>
                                            <label><strong>Cheques   </strong></label>
                                            <input id="check_conyuge" onchange="validar_check_cheque(this);" type="checkbox" data-style="slow" data-toggle="toggle" data-size="mini" data-on="Si" data-off="No">
                                            <br>
                                            <input type="text" style="display:none;" maxlength="20" class="form-control" id="inp-cheques"
                                                placeholder="$">
                                            
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row margenBoot-25">
                                    <div class="col-xs-12 col-lg-10">
                                        <div class="form-group">
                                            <label><strong>Financiación</strong></label>
                                            <input id="check_conyuge" onchange="validar_check_financiera(this);" type="checkbox" data-style="slow" data-toggle="toggle" data-size="mini" data-on="Si" data-off="No">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row margenBoot-25">
                                    <div class="col-xs-12 col-lg-10">
                                        <div class="form-group">
                                            <label>Observaciones Financiación Externa:</label>
                                            <textarea class="form-control" id="inp-observacionesFinanciacion" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row margenBoot-25">
                                    <div class="col-xs-12 col-lg-10">
                                        <div class="form-group">
                                            <label><strong>Total</strong></label>
                                            <input type="text" maxlength="150" class="form-control" id="inp-total"
                                                placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div id="alerta-nosonigualesImportes" class="row margenBoot-25 hidden">
                                    <div class="col-xs-12 col-lg-10"> </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-8">
                                <div id="contenedorVehiculosEntrega">
                                    <div name="entradaAuto" class="row">
                                        <div class="col-sm-12">
                                            <div class="box box-default collapsed-box">
                                                <div class="box-header with-border">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                            class="fa fa-plus" style="color:blue;font-size: 1.8em;"></i></button>
                                                    <h3 class="box-title" name="tituloAutoEntrega">Datos del auto que entrega :</h3>
                                                    <div class="box-tools pull-right">
                                                        <!--minimizar o maximizar-->
                                                    </div>
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body">
                                                    <div class="row margenBoot-25">
                                                        <div class="col-xs-12 col-lg-6">
                                                            <div class="form-group">
                                                                <label><strong>Nombre de Titular</strong></label>
                                                                <input type="text" class="form-control" id="nomb_titular">
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-12 col-lg-3">
                                                                <label><strong>Patente Mercosur</strong></label>
                                                                <input id="check_patente" onchange="validar_check_patente(this);" type="checkbox" data-style="slow" data-toggle="toggle" data-size="normal" data-on="Si" data-off="No">
                                                        </div>
                                                        <div class="col-xs-12 col-lg-3">
                                                            <div class="form-group">
                                                                <label><strong>Dominio</strong></label>
                                                                <input type="text" style="text-transform: uppercase;"
                                                                    maxlength="10" class="form-control" id="inp-dominio2"
                                                                    name="inp-dominio2[]" placeholder="" data-toggle="popover"
                                                                    title="Requerido" data-content="Este campo es obligatorio completar.">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row margenBoot-25">
                                                        <div class="col-xs-12 col-lg-3">
                                                            <div class="form-group">
                                                                <label><strong>Marca</strong></label>
                                                                <select onchange="verificarOtroElement(this,'');" class="form-control"
                                                                    id="sel-marca2" name="sel-marca2[]">
                                                                    <option value="BMW">BMW</option>
                                                                    <option value="CHEVROLET">CHEVROLET</option>
                                                                    <option value="CITROEN">CITROEN</option>
                                                                    <option value="DODGE">DODGE</option>
                                                                    <option value="FORD">FORD</option>
                                                                    <option value="FIAT">FIAT</option>
                                                                    <option value="MERCEDES BENZ">MERCEDES BENZ</option>
                                                                    <option value="PEUGEOT">PEUGEOT</option>
                                                                    <option value="RENAULT">RENAULT</option>
                                                                    <option value="TOYOTA">TOYOTA</option>
                                                                    <option value="SUZUKI">SUZUKI</option>
                                                                    <option value="VOLKSWAGEN">VOLKSWAGEN</option>
                                                                    <option value="Otro">Otro</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-lg-6">
                                                            <div class="form-group">
                                                                <label><strong>Modelo</strong></label>
                                                                <input type="text" maxlength="150" class="form-control"
                                                                    id="inp-modelo2">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-lg-3">
                                                            <div class="form-group">
                                                                <label><strong>Año</strong></label>
                                                                <input type="text" maxlength="65" class="form-control"
                                                                    id="inp-anno2" name="inp-anno2[]" placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row margenBoot-25">
                                                        <div class="col-xs-12 col-lg-3">
                                                            <div class="form-group">
                                                                <label><strong>Color</strong></label>
                                                                <input type="text" maxlength="65" class="form-control"
                                                                    id="inp-color2" name="inp-color2[]" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-lg-5">
                                                            <div class="form-group">
                                                                <label><strong>N° Motor</strong></label>
                                                                <input type="text" maxlength="255" class="form-control"
                                                                    id="inp-numMotor2" name="inp-numMotor2[]"
                                                                    placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-lg-4">
                                                            <div class="form-group">
                                                                <label><strong>N° Chasis</strong></label>
                                                                <input type="text" maxlength="255" class="form-control"
                                                                    id="inp-numChasis2" name="inp-numChasis2[]"
                                                                    placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row margenBoot-25">
                                                        <div class="col-xs-12 col-lg-12">
                                                            <div class="form-group">
                                                                <label><strong>Documentación Entregada</strong></label>
                                                                <textarea class="form-control" id="inp-observacion2"
                                                                    name="inp-observacion2[]" rows="5" maxlength="21844">CÉDULA DE IDENTIFICACIÓN DEL VEHÍCULO, CÉDULA DE AUTORIZADO, VTV EN VIGENCIA, CONSTANCIA DE LIBRE DEUDA MUNICIPAL DE IMPUESTOS Y MULTAS, INFORME DE DOMINIO, F12 CONFECCIONADO POR POLICÍA O GENDARMERÍA NACIONAL CON FECHA ACTUAL, TÍTULO Y F08 DEBIDAMENTE FIRMADO.</textarea>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- ./box-body -->
                                                <div class="box-footer" align="center">
                                                    <!--
                                                    <button type="button" onclick="limpiarAutoEntrega(this);" name="btn-limpiarAutoEntrega"
                                                        class="btn btn-sm btn-warning"> <i class="fa fa-recycle"></i>
                                                        LIMPIAR DATOS </button>
                                                    <button type="button" onclick="eliminarOpcionAuto(this);" name="btn-BorrarVehiculo"
                                                        class="btn btn-sm btn-danger hidden"> <i class="fa fa-minus"></i>
                                                        BORRAR VEHÍCULO</button>
                                                    <button type="button" onclick="generarNuevaOpcionVehiculo(this);"
                                                        name="btn-NuevoVehiculo" class="btn btn-sm btn-primary"><i
                                                            class="fa fa-plus"></i> AGREGAR
                                                        VEHÍCULO </button>
                                                    -->
                                                </div>
                                                <!-- /.box-footer -->
                                            </div>
                                            <!-- /.box -->
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </div>


                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h3 style="margin:5px;"><small>Detalles de financiacion con documentos:</small></h3>
                                        <div id="div-cuotas">
                                            <div name="rows" class="row margenBoot-25">
                                                <div class="col-xs-12 col-lg-2">
                                                    <input id="idDocumentos" name="inp-idDocumentos[]" type="hidden"
                                                        value="0">
                                                    <div class="form-group">
                                                        <label for="inp-plazo">Cantidad:</label>
                                                        <input type="text" maxlength="150" class="form-control" name="inp-plazo[]"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="inp-montoCuota">Monto Cuota:</label>
                                                        <input type="text" maxlength="65" class="form-control" onblur="darFormato(this);"
                                                            name="inp-montoCuota[]" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="inp-vencimiento">Primer vencimiento:</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control" name="inp-vencimiento[]">
                                                            <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span>
                                                            </span> </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">

                                                        <button type="button" onclick="generarNuevaOpcionCuota();" name="btn-NuevaCuota"
                                                            class="btn btn-primary" style="margin-top:25px;">
                                                            <span class="glyphicon glyphicon glyphicon-plus"
                                                                aria-hidden="true"></span> </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="detalle_cheque" style="display:none;" class="panel panel-default">
                                    <div class="panel-body">
                                        <h3 style="margin:5px;"><small>Detalles de cheques:</small></h3>
                                        <div class="div-cheques">
                                            <div name="rows" class="row margenBoot-25">
                                                <div class="col-xs-12 col-lg-2">
                                                    <input id="idCheques" name="inp-idCheques[]" type="hidden" value="0">
                                                    <div class="form-group">
                                                        <label><strong>Banco</strong></label>
                                                        <input type="text" maxlength="150" class="form-control" name="inp-banco[]"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-lg-3">
                                                    <div class="form-group">
                                                        <label><strong>Número</strong></label>
                                                        <input type="text" maxlength="65" class="form-control" name="inp-numCheque[]"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-lg-3">
                                                    <div class="form-group">
                                                        <label><strong>Fecha</strong></label>
                                                        <div class="input-group date" name="date-fechaPagCheque[]">
                                                            <input type="text" class="form-control">
                                                            <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span>
                                                            </span> </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-lg-3">
                                                    <div class="form-group">
                                                        <label><strong>Importe</strong></label>
                                                        <input type="text" maxlength="65" class="form-control" name="inp-importe[]"
                                                            onblur="darFormato(this);" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-lg-1" style="padding:0;">
                                                    <div class="form-group">
                                                        <button type="button" onclick="cheques();"
                                                            name="btn-NuevoCheque" class="btn btn-primary" style="margin-top:25px;">
                                                            <span class="glyphicon glyphicon glyphicon-plus"
                                                                aria-hidden="true"></span> </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.row -->
                    </div>
                    <!-- ./box-body -->
                    <div class="box-footer">
                        <div style="margin-top:25px;">
                            <div class="col-sm-12 col-lg-12">
                                <div id="alerta" style="display:none;" class="alert alert-success" role="alert"><strong>Operacion
                                        Guardada Correctamente!</strong></div>
                            </div>
                        </div>
                        <div class="row margenBoot-25" style="margin-top:25px;">
                            <div class="col-xs-12 col-lg-12" style="text-align:center;">
                                <button type="button" id="btn-guardar" data-loading-text="GUARDANDO..." class="btn btn-success"
                                    onclick="comenzarAGuardar();">GUARDAR</button>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>

        <!--Modal 0KM-->
					<div class="modal fade" id="modal-0km" tabindex="-1" role="dialog" aria-labelledby="modal-0km"
					 aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">
											<font style="vertical-align: inherit;">
												<font style="vertical-align: inherit;">×</font>
											</font>
										</span></button>
									<h4 class="modal-title">
										<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">Cargar 0 KM </font>
											
										</font>
									</h4>
								</div>
								<div class="modal-body">
										<div class="row margenBoot-25">
											<div class="col-xs-12 col-lg-12">
                                                    <div class="form-group">
                                                            <label><strong>*Marca</strong></label>
                                                            <select id="marca" name="marca" class="form-control form-control-sm">
                                                                <option>Soltero</option>
                                                                <option>Convive</option>
                                                                <option>Casado</option>
                                                                <option>Divorciado</option>
                                                                <option>Viudo</option>
                                                            </select>
                                                        </div>
												<div class="form-group">
													<label><strong>*Modelo</strong></label>
													<input type="text" class="form-control" id="modelo" name="modelo" required>
                                                </div>
                                                <div class="form-group">
                                                        <label><strong>*Versión</strong></label>
                                                        <input type="text" class="form-control" id="version" name="version" required>
                                                    </div>
                                                    <div class="form-group">
                                                            <label><strong>*Precio</strong></label>
                                                            <input type="text" class="form-control" id="precio" name="precio" required>
                                                        </div>
											</div>
											
										</div><!-- /.modal-dialog -->
										<div class="modal-footer">
											<button  type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
											<button  type="submit" onclick="realizaProceso($('#estado_civil').val())" class="btn btn-primary">Continuar</button>
										</div>
                                </div>
                                
							</div>
						</div>
                    </div>

                    <!--Modal Financiera-->

                    <div class="modal fade" id="modal-financiera" tabindex="-1" role="dialog" aria-labelledby="modal-financiera"
					 aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">
											<font style="vertical-align: inherit;">
												<font style="vertical-align: inherit;">×</font>
											</font>
										</span></button>
									<h4 class="modal-title">
										<font style="vertical-align: inherit;">
											<font style="vertical-align: inherit;">FINANCIERAS</font>
											
										</font>
									</h4>
								</div>
								<div class="modal-body">
										<!--<div class="row margenBoot-25">
											<div class="col-xs-12 col-lg-12">
                                                <div class="form-group">
                                                            <label><strong>*Marca</strong></label>
                                                            <select id="marca" name="marca" class="form-control form-control-sm">
                                                                <option>Soltero</option>
                                                                <option>Convive</option>
                                                                <option>Casado</option>
                                                                <option>Divorciado</option>
                                                                <option>Viudo</option>
                                                            </select>
                                                        </div>
												<div class="form-group">
													<label><strong>*Modelo</strong></label>
													<input type="text" class="form-control" id="modelo" name="modelo" required>
                                                </div>
                                                <div class="form-group">
                                                        <label><strong>*Versión</strong></label>
                                                        <input type="text" class="form-control" id="version" name="version" required>
                                                    </div>
                                                    <div class="form-group">
                                                            <label><strong>*Precio</strong></label>
                                                            <input type="text" class="form-control" id="precio" name="precio" required>
                                                        </div>
											</div>
											
										</div><!-- /.modal-dialog -->
										<div class="modal-footer">
											<button  type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
											<button  type="submit" onclick="realizaProceso($('#estado_civil').val())" class="btn btn-primary">Continuar</button>
                                        </div> 
                                    
                                </div>
                                
							</div>
						</div>
                    </div>
                    
        {!! Form::close() !!}

    </div>

    @endsection