<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Dashboard</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Pages</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Basic Form Inputs</h5>
                            <span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                                <i class="icofont icofont-close-circled"></i>
                            </div>
                        </div>
                        <div class="card-block">

                            <form id="idFormContratoVehiculo">
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label">Ciente</label>
                                    <div class="col-sm-5 input-group input-group-success">
                                        <span id="idBtnNuevoCliente" class="input-group-addon waves-effect" data-toggle="modal" data-target="#modalLargeNuevoCliente">
                                            <i class="icofont icofont-contact-add"></i>
                                        </span>
                                        <select id="idSelectCliente" class="input-sm">
                                            <option value="" selected="selected">Busque un cliente</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-1 col-form-label">Mesnualidad</label>
                                    <div class="col-sm-5">
                                        <input type="number" class="form-control" id="idInputMensualidadContrato" placeholder="Monto mensualidad según contrato">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label">Fecha Inicio</label>
                                    <div class="col-sm-5">
                                        <input id="idInputFechaInicioContrato" class="form-control" type="text" placeholder="Selecione fecha inicio" />
                                    </div>
                                    <label class="col-sm-1 col-form-label">Fecha Fin</label>
                                    <div class="col-sm-5">
                                        <input id="idInputFechaFinContrato" class="form-control" type="text" placeholder="Selecione fecha fin" />
                                    </div>
                                </div>

                                <div class="form-group row" data-duplicate="vehiculos" data-duplicate-min="1">


                                    <a id="asd" class="btn btn-success btn-icon" data-duplicate-add="vehiculos">+</a>
                                    <a class="btn btn-danger btn-icon" data-duplicate-remove="vehiculos">-</a>
                                    <div class="col-sm-1 input-group-sm mb-3">
                                        <label>Pago</label>
                                        <input type="number" name="pagoContrato[]"  class="form-control" placeholder="Pago s/.">
                                    </div>
                                    <div class="col-sm-2 input-group-sm mb-3">
                                        <label>Frecuencia de Pago</label>
                                        <select name="pagoFrecuencia[]"class="form-control">
                                            <option value="1">1 MES</option>
                                            <option value="2">2 MES</option>
                                            <option value="3">3 MES</option>
                                            <option value="4">4 MES</option>
                                            <option value="5">5 MES</option>
                                            <option value="6">6 MES</option>
                                            <option value="7">7 MES</option>
                                            <option value="8">8 MES</option>
                                            <option value="9">9 MES</option>
                                            <option value="10">10 MES</option>
                                            <option value="11">11 MES</option>
                                            <option value="12">12 MES</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1 input-group-sm mb-3">
                                        <label>Marca</label>
                                        <select name="marcaVehiculo[]"  class="form-control selectMarcaVehiculo">                                                                                  
                                        </select>
                                    </div>
                                    <div class="col-sm-1 input-group-sm mb-3">
                                        <label>Placa</label>
                                        <input type="text" name="placa[]" class="form-control" placeholder="PLACA">
                                    </div>
                                    <div class="col-sm-1 input-group-sm mb-3">
                                    <label>Modelo</label>
                                        <input type="text" name="modelo[]" class="form-control" placeholder="MODELO">
                                    </div>
                                    <div class="col-sm-1 input-group-sm mb-3">
                                    <label>Año</label>
                                        <input type="text" name="anio[]" class="form-control" placeholder="AÑO">
                                    </div>
                                    <div class="col-sm-1 input-group-sm mb-3">
                                    <label>Modelo GPS</label>
                                        <input type="text" name="gps[]" class="form-control" placeholder="GPS">
                                    </div>
                                    <div class="col-sm-1 input-group-sm mb-3">
                                    <label>IMEI GPS</label>
                                        <input type="text" name="imei[]" class="form-control" placeholder="IMEI">
                                    </div>
                                    <div class="col-sm-2 input-group-sm mb-3">
                                    <label>Fecha de Instalación</label>
                                        <input type="date" name="fechaInstalacion[]" class="form-control" >
                                    </div>



                                </div>
                                <div class="form-group row">
                                   <input type="button" class="btn btn-primary m-r-10" id="idBtnGuardarContrato" value="GUARDAR">
                                </div>
                            </form>
                           
                        </div>
                    </div>
               
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalLargeNuevoCliente" role="dialog" style='z-index:10000;'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Nuevo Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="checkbox" id="idCheckNaturalJuridica" checked />
                <span id="idTituloNaturalJuridica">Tipo De Cliente a Agregar</span>
            </div>
            <div class="modal-body">
                <div class="card" id="idFormularioNatural">
                    <div class="card-header">
                        <h5>Crear Persona Natural</h5>

                    </div>
                    <div class="card-block">
                        <form action="#" id="idFormPersonaNatural">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" id="IdInputDni" class="form-control validanumericos" maxlength="8" placeholder="Dni del Nuevo Cliente" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="text" id="idInputNombrePersonaNatural" class="form-control" placeholder="Nombres">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" id="idInputApellidoPersonaNatural" class="form-control" placeholder="Apellidos">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="email" id="idInputCorreoPersonaNatural" class="form-control" placeholder="cliente@email.com">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="text" id="idInputTelefonoPersonaNatural" class="form-control validanumericos" placeholder="Teléfono">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" id="idInputDireccionPersonaNatural" class="form-control" placeholder="Dirección">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 text-right">
                                    <button type="submit" class="btn btn-primary m-r-10" id="idBtnAgregarNuevoClienteNatural">Agregar Cliente</button>
                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>
                <div class="card" id="idFormularioJuridica" hidden>
                    <div class="card-header">
                        <h5>Crear Persona Juridica</h5>

                    </div>
                    <div class="card-block">

                        <form action="#" id="idFormPersonaJuridica">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" id="IdInputRuc" class="form-control validanumericos" placeholder="Ruc del Nuevo Cliente">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" id="IdInputRazonSocial" class="form-control" placeholder="Razón Social del Nuevo Cliente">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="correo" id="IdInputCorreoJuridica" class="form-control" placeholder="Correo del Cliente">
                                </div>
                            </div>


                            <hr />
                            <h4 class="sub-title">Representate Legal</h4>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" id="IdInputDniRepresentanteLegal" class="form-control validanumericos" placeholder="Dni del Nuevo Cliente" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="text" id="idInputNombreRepresentanteLegal" class="form-control" placeholder="Nombres">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" id="idInputApellidoRepresentanteLegal" class="form-control" placeholder="Apellidos">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="email" id="idInputCorreoRepresentanteLegal" class="form-control" placeholder="representante@empresa.com">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="text" id="idInputTelefonoRepresentanteLegal" class="form-control validanumericos" placeholder="Teléfono">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" id="idInputDireccionRepresentanteLegal" class="form-control" placeholder="Dirección">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 text-right">
                                    <button type="submit" class="btn btn-primary m-r-10" id="idBtnAgregarNuevoClienteJuridica">Agregar Cliente</button>
                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>

                        </form>


                    </div>

                </div>
            </div>

        </div>
    </div>
</div>