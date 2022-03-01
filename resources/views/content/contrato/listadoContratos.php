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
                            <div class="dt-responsive table-responsive">
                                <div class="card-block">
                                    <div class="row m-b-20">


                                        <div class="col-sm-12 col-xl-3 m-b-30">
                                            <label>Desde : Fecha Inicio</label>
                                            <input class="form-control" type="date" id="idContratoFechaInicioDesde">
                                        </div>


                                        <div class="col-sm-12 col-xl-3 m-b-30">
                                            <label>Hasta : Fecha Inicio</label>
                                            <input class="form-control" type="date" id="idContratoFechaInicioHasta">
                                        </div>

                                        <div class="col-sm-12 col-xl-3 m-b-30">
                                            <label>Estado Contrato</label>
                                            <select name="" class="form-control" id="idContratoEstado">
                                                <option value="1">ACTIVO</option>
                                                <option value="0">DESACTIVO</option>
                                                <option value="">TODOS</option>

                                            </select>

                                        </div>

                                        <div class="col-sm-12 col-xl-3 m-b-30">
                                            <label for=""></label>
                                            <button class=" btn btn-inverse btn-round form-control" id="idContratoVehiculoPagosBuscar">Filtrar Registros</button>
                                        </div>


                                    </div>



                                    <!-- <button id="button">Row count</button> -->
                                    <table id="idListadoContratos" class="table table-striped table-bordered nowrap compact">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Nombre</th>
                                                <th>Mensualidad</th>
                                                <th>Fecha inicio</th>
                                                <th>Fecha fin</th>
                                                <th>Creado</th>
                                                <th>Contrato</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Nombre</th>
                                                <th>Mensualidad</th>
                                                <th>Fecha inicio</th>
                                                <th>Fecha fin</th>
                                                <th>Creado</th>
                                                <th>Contrato</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="md-modal md-effect-1" id="idModalListadoVehiculoContrato">
    <div class="md-content">
        <h3>Listado De Vehículos del Contrato</h3>
        <div>
            <p id="modalNombreCliente"></p>
            <div id="idModalListadoContrato" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Placa</th>
                            <th>Mensualidad</th>
                            <th>ultimo Pago</th>
                            <th>Fecha Instalacion</th>
                            <th>Fecha Termino</th>
                            <th>IMEI</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-primary waves-effect md-close">Close</button>
        </div>
    </div>
</div>