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
                                    <label class="col-sm-1 col-form-label">Cliente</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="idInputCliente" placeholder="Cliente" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label">Mensualidad</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control" id="idInputMensualidadContrato" placeholder="Monto mensualidad según contrato" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label">Fecha Inicio</label>
                                    <div class="col-sm-3">
                                        <input id="idInputFechaInicioContrato" class="form-control" type="date" placeholder="Selecione fecha inicio" disabled />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-1 col-form-label">Fecha Fin</label>
                                    <div class="col-sm-3">
                                        <input id="idInputFechaFinContrato" class="form-control" type="date" placeholder="Selecione fecha fin" disabled />
                                    </div>
                                    <label class="col-sm-1 col-form-label">Cargar Contrato</label>
                                    <div class="col-sm-3">
                                        <input id="idInputArchivoContrato" class="form-control" type="file" placeholder="Selecione fecha inicio" disabled />
                                    </div>
                                    <label class="col-sm-1 col-form-label">Contrato</label>
                                    <div class="col-sm-3">
                                        <a type="button" href="#" class="btn btn-default form-control" id="idInputVerArchivoContrato">PDF <i class="ti-download"></i></a>
                                    </div>
                                    <label class="col-sm-1"></label>
                                    <div class="col-sm-2">
                                        <input type="button" class="btn btn-warning " id="idBtnActivarEditarContrato" value="EDITAR">
                                        <div class="btn-group">
                                            <input type="button" class="btn btn-primary d-none" id="idBtnEditarContrato" value="ACTUALIZAR">
                                            <button type="button" class="btn btn-secondary d-none" id="idBtnCancelarEditarContrato"><i class="icofont icofont-close-circled"></i></button>
                                        </div>

                                    </div>
                                </div>


                                <div class="form-group row" data-duplicate="vehiculos" data-duplicate-min="1">

                                    <!-- <div class="col-sm-6 input-group-sm mb-4 offset-md-3  bg-dark">
                                        <small>Placa</small>
                                        <input type="text" name="placa" id="idInputPlacaVehiculo" class="form-control" placeholder="PLACA">
                                    </div> -->
                                    <!-- <div class="col-sm-1 input-group-sm mb-3">
                                        <small>Pago</small>
                                        <input type="number" name="pagoContrato" id="idInputPagoContrato" class="form-control" placeholder="Pago s/.">
                                    </div>
                                    <div class="col-sm-2 input-group-sm mb-3">
                                        <small>Frecuencia de Pago</small>
                                        <select name="pagoFrecuencia" class="form-control" id="idInputPagoFrecuencia">
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
                                        <small>Marca</small>
                                        <select name="marcaVehiculo" class="form-control selectMarcaVehiculo">
                                        </select>
                                    </div>

                                    <div class="col-sm-1 input-group-sm mb-3">
                                        <small>Modelo</small>
                                        <input type="text" name="modelo" class="form-control" placeholder="MODELO">
                                    </div>
                                    <div class="col-sm-1 input-group-sm mb-3">
                                        <small>Año</small>
                                        <input type="text" name="anio" class="form-control" placeholder="AÑO">
                                    </div>
                                    <div class="col-sm-1 input-group-sm mb-3">
                                        <small>Modelo GPS</small>
                                        <input type="text" name="gps" class="form-control" placeholder="GPS">
                                    </div>
                                    <div class="col-sm-1 input-group-sm mb-3">
                                        <small>IMEI GPS</small>
                                        <input type="text" name="imei" class="form-control" placeholder="IMEI">
                                    </div>
                                    <div class="col-sm-2 input-group-sm mb-3">
                                        <small>Fecha de Instalación</small>
                                        <input type="date" name="fechaInstalacion" class="form-control">
                                    </div>
                                    <a id="idBtnGuardarVehiculo" class="btn btn-success btn-icon">+</a> -->

                                </div>

                            </form>

                            <div class="form-group d-none" id="idDivBusquedaPlaca">
                                <i class="ti-reload rotate-refresh"></i> <small id="idTextPlacaSmall" class="text-muted">Buscando...</small>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block row">
                            <div class="col-md-10">
                                <table id="idListadoVehiculos" class="table table-striped table-bordered nowrap compact resposive" width="100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>F.Pago</th>
                                            <th>Pago</th>
                                            <th>Marca</th>
                                            <th>Placa</th>
                                            <th>Modelo</th>
                                            <th>Año</th>
                                            <th>Modelo GPS</th>
                                            <th>IMEI GPS</th>
                                            <th>Fecha de Instalación/Inicio</th>
                                            <th>Fecha de Termino</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Frecuencia Pago</th>
                                            <th>Pago</th>
                                            <th>Marca</th>
                                            <th>Placa</th>
                                            <th>Modelo</th>
                                            <th>Año</th>
                                            <th>Modelo GPS</th>
                                            <th>IMEI GPS</th>
                                            <th>Fecha de Instalación/Inicio</th>
                                            <th>Fecha de Termino</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-2">
                                <div class="from-control bg-dark">
                                        <input type="text" name="placa" id="idInputPlacaVehiculo" class="form-control" placeholder="PLACA" autocomplete="off">
                                </div>
                                <br>
                              
                                <input type="button" value="Elegir Placa" class="btn btn-info form-control" id="idBtnModalAgregarPlaca">
                                <select class="js-example-basic-single form-control"  id="idInputSelectPlacaAgregar">
                                   
                                <select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="md-modal md-effect-1" id="idModalEditarVehiculoContrato">
    <div class="md-content">
        <h3>Editar Informació del vehículo y el contrato</h3>
        <div class="modal-content">

            <div class="modal-body">
                <div class="card">
                    <div class="card-block">
                        <div class="form-group row">
                            <label>Frecuencia Pago</label>
                            <div class="col-sm-12">
                                        <select name="pagoFrecuencia" class="form-control" id="idInputEditarFrecuenciaPago" readonly>
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
                        </div>
                        <div class="form-group row">
                            <label>Fecha Inicio</label>
                            <div class="col-sm-12">
                                <input type="date" name="inicio" id="idInputEditarFechaInicio" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Fecha Fin</label>
                            <div class="col-sm-12">
                                <input type="date" name="fin" id="idInputEditarFechaFin" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Monto Pago</label>
                            <div class="col-sm-12">
                                <input type="number" name="fin" id="idInputEditarMontoPago" min="1" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="hidden" id="idInputEditarIdVehiculo" value="0">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer btn-group">
                        <button type="submit" class="btn btn-primary " id="idBtnEditarContratoVehiculo">Editar</button>
                        <button type="button" class="btn btn-default waves-effect  float-right md-close" data-dismiss="modal">Cerrar</button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>



<div class="md-modal md-effect-1" id="idModalAgregarVehiculoContrato">
    <div class="md-content">
        <h3>Agregar Vehículo en el Contrato</h3>
        <div class="modal-content">

            <div class="modal-body">
                <div class="card">
                    <div class="card-block">
                        <div class="form-group row">
                            <label>Frecuencia Pago</label>
                            <div class="col-sm-12">
                                
                                <select name="pagoFrecuencia" class="form-control" id="idInputAgregarFrecuenciaPago">
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
                        </div>
                        <div class="form-group row">
                            <label>Fecha Inicio</label>
                            <div class="col-sm-12">
                                <input type="date"  id="idInputAgregarFechaInicio" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Fecha Fin</label>
                            <div class="col-sm-12">
                                <input type="date"  id="idInputAgregarFechaFin" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label>Monto Pago</label>
                            <div class="col-sm-12">
                                <input type="number"  id="idInputAgregarMontoPago" min="1" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">


                            </div>
                        </div>
                    </div>

                    <div class="card-footer btn-group">
                        <button type="submit" class="btn btn-primary " id="idBtnAgregarContratoVehiculo">Agregar</button>
                        <button type="button" class="btn btn-default waves-effect  float-right md-close" data-dismiss="modal">Cerrar</button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>