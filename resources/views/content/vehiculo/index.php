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
                                            <label for=""></label>
                                            <button class="btn btn-primary btn-round" id="idBtnModalCrearNuevoVehiculo">Nuevo Vehículo</button>
                                        </div>
                                    </div>
                                    <!-- <button id="button">Row count</button> -->
                                    <table id="idListadoVehiculo" class="table table-striped table-bordered nowrap compact responsive">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Placa</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Año</th>
                                                <th>Modelo [Gps]</th>
                                                <th>IMEI [Gps]</th>
                                                <th>Fecha Creación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Placa</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Año</th>
                                                <th>Modelo [Gps]</th>
                                                <th>IMEI [Gps]</th>
                                                <th>Fecha Creación</th>
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


<div class="md-modal md-effect-1" id="idModalListadoVehiculo">
    <div class="md-content">
        <h3>Vehículo</h3>
        <div>
            <form action="#" id="idFormVehiculo">
                
                <input type="hidden" name="" id="idInputIdVehiculo" name="" class="form-control" value="0">
                
                <div class="form-group row">
                    <div class="col-sm-6">
                        <small>Placa</small>
                        <input type="text" id="idInputPlacaVehiculo" name="idInputPlacaVehiculo" class="form-control" placeholder="Placa" required>
                    </div>
                    <div class="col-sm-6">
                        <small>Año</small>
                        <input type="number" id="idInputAnioVehiculo" name="idInputAnioVehiculo" class="form-control" placeholder="Año" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <small>Marca</small>                        
                        <select name="" id="idInputMarcaVehiculo" class="form-control">
                           
                        </select>
                        
                    </div>
                    <div class="col-sm-6">
                        <small>Modelo Vehículo</small>
                        <input type="text" id="idInputModeloVehiculo" name="idInputModeloVehiculo" class="form-control" placeholder="Modelo Vehículo" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <small>Marca[Gps]</small> 
                        <input type="text" id="idInputMarcaGpsVehiculo" name="idInputMarcaGpsVehiculo" class="form-control" placeholder="Marca" required>
                    </div>
                    <div class="col-sm-6">
                        <small>IMEI [Gps]</small>
                        <input type="text" id="idInputImeiGpsVehiculo" name="idInputImeiGpsVehiculo" class="form-control" placeholder="IMEI" required>
                    </div>
                </div>

                <div class="form-group row">
                    <button type="submit" class="btn btn-primary m-r-10" id="idBtnAgregarNuevoVehiculo">Agregar Vehículo</button>
                    <button type="button" class="btn btn-default waves-effect md-close" data-dismiss="modal">Close</button>
                </div>


            </form>



        </div>
    </div>
</div>