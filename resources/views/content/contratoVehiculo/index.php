<div class="main-body user-profile">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4 class="text-success" id="idContratoVehiculoNombreContrato">--</h4>
            </div>

            <input type="checkbox" id="idContratoVehiculoNombreContratoCheckbox" checked />
            <input type="text" name="" id="idTextPlacaVehiculo" readonly>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Social</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Fb Wall</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page header end -->
        <!-- Page body start -->
        <div class="page-body">
            <!--profile cover start-->
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card-block">
                                <div class="row m-b-20">


                                    <div class="col-sm-12 col-xl-4 m-b-30">
                                        <p>Fecha Inicio</p>
                                        <input class="form-control" type="date" id="idContratoVehiculoFechaInicio">
                                    </div>


                                    <div class="col-sm-12 col-xl-4 m-b-30">
                                        <p>Fecha Fin</p>
                                        <input type="date" class="form-control" id="idContratoVehiculoFechaFin">

                                    </div>

                                    <div class="col-sm-12 col-xl-4 m-b-30">
                                        <p>Tipo Pago</p>
                                        <select name="" class="form-control" id="idContratoVehiculoTipoPago">
                                            <option value="0">TODOS</option>
                                        </select>

                                    </div>

                                    <div class="col-sm-12 col-xl-4">
                                        <button class=" btn btn-inverse btn-round" id="idContratoVehiculoPagosBuscar">Filtrar Registros</button>
                                        <button class="btn btn-success btn-outline-success waves-effect md-trigger btn-round" id="idModalNuevoPagoVehiculo" data-modal="idModalNuevoPago">Nuevo Pago</button>
                                    </div>


                                </div>

                            </div>



                            <div class="card-block bg-white">
                                <div class="dt-responsive table-responsive">
                                    <button id="button" class="invisible">Row count</button>
                                    <table id="idListadoPagoVehiculo" class="table table-striped table-bordered nowrap compact">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Tipo Pago</th>
                                                <th>Mensualidad</th>
                                                <th>Fecha Pago</th>
                                                <th>Fecha Creación de Registro</th>
                                                <th>Observacion</th>
                                                <th>Acciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Tipo Pago</th>
                                                <th>Mensualidad</th>
                                                <th>Fecha Pago</th>
                                                <th>Fecha Creación de Registro</th>
                                                <th>Observacion</th>
                                                <th>Acciones</th>

                                            </tr>
                                        </tfoot>

                                    </table>
                                </div>
                            </div>

                            <div class="card-block">
                                <div class="row m-b-20">

                                    <div class="col-sm-12 col-xl-2 m-b-30">
                                        <p>Pago total</p>
                                        <input class="form-control bg-success  text-dark" only type="text" id="idSumaTotalPagoVehiculo" readonly>
                                    </div>

                                </div>

                            </div>



                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="fb-timeliner" id="idDivMesesActual">
                        <h2 id="idTitleAnioActual" class="recent-highlight bg-danger"></h2>
                        <ul id="idUlMesesActual">
                        
                        </ul>
                    </div>
                    <div class="fb-timeliner" id="idDivMesesPasado">
                        <h2 id="idTitleAnioPasado"></h2>
                        <ul id="idUlMesesPasado">
                           
                        </ul>
                    </div>
                </div>
            </div>
            <!--profile cover end-->
        </div>
        <!-- Page body end -->
    </div>
</div>




<div class="md-modal md-effect-1" id="idModalNuevoPago">
    <form action="#" id="idFormNuevoPagoVehiculo">

        <div class="md-content">
            <h3 id="idTituloAccionModal">Nuevo Pago</h3>

            <input type="hidden" name="" id="idInputIdPago" class="form-control" value="0">

            <div>
                <div class="row">
                    <div class="col-sm-12 col-xl-6">
                        <p>Pago</p>
                        <input type="number" name="" id="idInputMontoPago" class="form-control" value="" required="required" pattern="" title="" placeholder="S/." required>

                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <p>Tipo Pago</p>
                        <select name="" class="form-control" id="idSelectTipoPagoModalNuevoPago">
                        </select>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-xl-12">
                        <p>Observación</p>
                        <textarea rows="5" cols="5" class="form-control" id="idTextObservacion" placeholder="Observacion de Pago" required></textarea>

                    </div>

                </div>


                <div class="row">
                    <div class="col-sm-12 col-xl-12">
                        <p>Fecha Pago</p>
                        <input type="date" name="" id="idInputFechaPago" class="form-control" value="" required="required">

                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12 col-xl-6">
                        <p>Archivo</p>
                        <input type="file" id="idInputFile" accept="image/*" onchange="cargarImagen(event)">
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12 col-xl-12 text-center">

                        <img id="output" width="20%" />

                    </div>

                </div>
                <br>

                <div class="row">
                
                    <button type="submit" id="idBtnGuardarNuevoPago" class="btn btn-primary waves-effect">Guardar</button>
                    <button type="submit" id="idBtnEditarPago" class="btn btn-secondary waves-effect d-none">Editar</button>
                    <button type="button" class="btn btn-warning waves-effect md-close btn-cerrar-modal">Cerrar</button>
                </div>



            </div>
        </div>
    </form>

</div>