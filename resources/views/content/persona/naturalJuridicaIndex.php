<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4> Persona Natural / Jurídica </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Clientes</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!"> Persona Natural - Jurídica </a>
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
                            <h5>Persona Natural</h5>
                            <span>La gestión de <code>CLIENTES</code> necesita a su ves la gestion de <code>PERSONAS</code> para el correcto funcionamiento del sistema</span>
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


                                        <div class="col-sm-12 col-xl-3">
                                            <label for=""></label>
                                            <button class=" btn btn-info" id="idModalMostrarGuardarEditar">Crear Nuevo Registro</button>
                                        </div>


                                    </div>



                                    <!-- <button id="button">Row count</button> -->
                                    <table id="idListadoPersonas" class="table table-striped table-bordered nowrap compact responsive">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Nombres</th>
                                                <th>Apellidos</th>
                                                <th>DNI</th>
                                                <th>Dirección</th>
                                                <th>Correo</th>
                                                <th>Creado</th>
                                                <th>Actualizado</th>
                                                <th>Accciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Nombres</th>
                                                <th>Apellidos</th>
                                                <th>DNI</th>
                                                <th>Dirección</th>
                                                <th>Correo</th>
                                                <th>Creado</th>
                                                <th>Actualizado</th>
                                                <th>Accciones</th>
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
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Persona Jurídica</h5>
                            <span>La gestión de <code>CLIENTES</code> necesita a su ves la gestion de <code>PERSONAS JURÍDICA</code> para el correcto funcionamiento del sistema</span>
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


                                        <div class="col-sm-12 col-xl-3">
                                            <label for=""></label>
                                            <button class=" btn btn-info" id="idModalJuridicaMostrarGuardarEditar">Crear Nuevo Registro</button>
                                        </div>


                                    </div>



                                    <!-- <button id="button">Row count</button> -->
                                    <table id="idListadoPersonaJuridica" class="table table-striped table-bordered nowrap compact responsive">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Ruc</th>
                                                <th>Razon Social</th>
                                                <th>Contratos Actuales</th>
                                                <th>Correo</th>
                                                <th>Nombre Representante</th>
                                                <th>Fecha Creación</th>
                                                <th>Fecha Actualización</th>
                                                <th>Accciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Ruc</th>
                                                <th>Razon Social</th>
                                                <th>Contratos Actuales</th>
                                                <th>Correo</th>
                                                <th>Nombre Representante</th>
                                                <th>Fecha Creación</th>
                                                <th>Fecha Actualización</th>
                                                <th>Accciones</th>
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


<div class="md-modal md-effect-1" id="idModalGuardarEditar">
    <div class="md-content">
        <h3>Persona</h3>
        <div>
            <form action="#" id="idFormPersona">

                <input type="hidden" name="" id="idInputIdPersona" name="" class="form-control" value="0">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <small>DNI</small>
                        <input type="text" id="idInputDni" name="idInputDni" class="form-control" placeholder="DNI" required>
                    </div>
                    <div class="col-sm-6">
                        <small>Dirección</small>
                        <input type="text" id="idInputDireccion" name="idInputDireccion" class="form-control" placeholder="Dirección" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <small>Nombres</small>
                        <input type="text" id="idInputNombres" name="idInputNombres" class="form-control" placeholder="Nombres" required>
                    </div>
                    <div class="col-sm-6">
                        <small>Apellidos</small>
                        <input type="text" id="idInputApellidos" name="idInputApellidos" class="form-control" placeholder="Apellidos" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <small>Correo</small>
                        <input type="email" id="idInputCorreo" name="idInputCorreo" class="form-control" placeholder="usuario@correo.net" required>
                    </div>
                    <div class="col-sm-6">
                        <small>Teléfono</small>
                        <input type="text" id="idInputTelefono" name="idInputTelefono" class="form-control" placeholder="952818777" required>
                    </div>
                </div>

                <div class="form-group row">
                    <button type="submit" class="btn btn-primary m-r-10" id="idBtnAgregarEditarPersona">Agregar Persona</button>
                    <button type="button" class="btn btn-default waves-effect md-close" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="md-modal md-effect-1" id="idModalJuridicaGuardarEditar">
    <div class="md-content">
        <h3>Persona Jurídica</h3>
        <div>
            <form action="#" id="idFormPersonaJuridica">
                <hr />
                
                <input type="hidden" name="" id="idInputIdPersonaJuridica" class="form-control" value="0">
                
                <h4 class="sub-title">Persona Jurídica</h4>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <small>RUC</small>
                        <input type="text" id="IdInputRuc" name="IdInputRuc" class="form-control validanumericos" placeholder="Ruc del Nuevo Cliente" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <small>Razón social</small>
                        <input type="text" id="IdInputRazonSocial" name="IdInputRazonSocial" class="form-control" placeholder="Razón Social del Nuevo Cliente" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <small>Correo</small>
                        <input type="correo" id="IdInputCorreoJuridica" name="IdInputCorreoJuridica" class="form-control" placeholder="empresa@correo.com">
                    </div>
                </div>

                <hr />

                <h4 class="sub-title">Representate Legal</h4>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <small>DNI</small>                        
                        <select  id="IdInputDniRepresentanteLegal" name="IdInputDniRepresentanteLegal" class="form-control">
                            
                        </select>
                        
                    </div>
                </div>
                <br>

                <div class="form-group row">
                    <button type="submit" class="btn btn-primary m-r-10" id="idBtnAgregarEditarPersonaJuridica">Agregar Persona</button>
                    <button type="button" class="btn btn-default waves-effect md-close" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

