<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4> Usuarios </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Usuario</a>
                    </li>
                    <li class="breadcrumb-item"><a href="/gps/src/private/views/usuario/usuarioView.php"> Gestionar Usuarios </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Basic Form Inputs card start -->
                    <div class="card">
                        
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <div class="card-block">
                                    <div class="row m-b-20">


                                        <div class="col-sm-12 col-xl-3">
                                            <label for=""></label>
                                            <button class=" btn btn-info" id="idModalGuardarEditar">Crear Nuevo Registro</button>
                                        </div>


                                    </div>



                                    <!-- <button id="button">Row count</button> -->
                                    <table id="idListadoUsuarios" class="table table-striped table-bordered nowrap compact responsive">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>N° Documento</th>
                                                <th>Nombre Cliente</th>
                                                <th>Apellido Cliente</th>
                                                <th>Usuario</th>
                                                <th>Correo</th>
                                                <th>Rol</th>
                                                <th>Estado [Usuario]</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>N° Documento</th>
                                                <th>Nombre Cliente</th>
                                                <th>Apellido Cliente</th>
                                                <th>Usuario</th>
                                                <th>Correo</th>
                                                <th>Rol</th>
                                                <th>Estado [Usuario]</th>
                                                <th>Acción</th>
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


<div class="md-modal md-effect-1" id="idModalMostrarGuardarEditar">
    <div class="md-content">
        <h3>Formulario Usuario</h3>
        <div>
            <form action="#" id="idFormNuevoUsuario">

                <input type="hidden" name="" id="idInputIdUsuario" name="" class="form-control" value="0">
                <div class="form-group row  justify-content-center">
                    <div class="col-sm-6">
                        <small>PERSONA NATURAL</small>
                        <select name="idInputIdPersonaNatural" id="idInputIdPersonaNatural" class="form-control">

                        </select>

                    </div>
                </div>
                <hr>
                <div class="form-group row">

                    <div class="col-sm-4">
                        <small>Usuario</small> <br>
                        <input id="idUsuario" name="idUsuario" type="text" class="form-control">
                    </div>

                    <div class="col-sm-4">
                        <small>Contraseña</small> <br>
                        <input id="idContrasena" name="idContrasena" type="password" class="form-control">
                    </div>
                    <div class="col-sm-4">
                    <small>Estado</small> <br>
                          <select class="form-control" id="idEstadoUsuario" name="idEstadoUsuario" id="">
                            <option value="1">Habilitado</option>
                            <option value="0">Deshabilitado</option>
                          </select>
                    </div>

                </div>
                <hr>
                <div class="form-group row  justify-content-center">
                    <div class="col-sm-6">
                        <small>Rol del Usuario</small>
                        <select name="idInputISelectRol" id="idInputISelectRol" name="idInputISelectRol" class="form-control">

                        </select>

                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <button type="button" class="btn btn-primary m-r-10" id="idBtnAgregarEditarUsuario">Agregar Usuario</button>
                    <button type="button" class="btn btn-default waves-effect md-close" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>