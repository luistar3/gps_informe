<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4> Clientes </h4>
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
                    <li class="breadcrumb-item"><a href="#!"> Gestionar Clientes </a>
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
                            <h5>Clientes</h5>
                            <span>Módulo de gestion de <code>CLIENTES</code> Agregar - Actualizar</span>
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
                                    <table id="idListadoCliente" class="table table-striped table-bordered nowrap compact responsive">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>N° Documento</th>
                                                <th>Nombre Cliente</th>
                                                <th>Tipo Cliente</th>
                                                <th>Ultimo Pago</th>
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
                                                <th>N° Documento</th>
                                                <th>Nombre Cliente</th>
                                                <th>Tipo Cliente</th>
                                                <th>Ultimo Pago</th>
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
    </div>
</div>


<div class="md-modal md-effect-1" id="idModalGuardarEditar">
    <div class="md-content">
        <h3>Formulario Cliente</h3>
        <div>
            <form action="#" id="idFormNuevoCliente">

                <input type="hidden" name="" id="idInputIdcliente" name="" class="form-control" value="0">
                <div class="form-group row  justify-content-center">
                    <div class="col-sm-6" id="idDivPersonaNatural" >
                        <small>PERSONA NATURAL</small>
                        <select name="idInputIdPersonaNatural" id="idInputIdPersonaNatural" class="form-control">

                        </select>

                    </div>
                    <div class="col-sm-6 d-none" id="idDivPersonaJuridica">
                        <small>PERSONA JURIDICA</small>

                        <select name="idInputIdPersonaJuridica" id="idInputIdPersonaJuridica" class="form-control">

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12   form-control form-control-center">
                        
                        <small>Tipo Persona</small> <br>
                        
                            <label>
                                <input id="idRadioNatural" type="radio" value="natural" name="tipoPersona" checked>
                                <i class="helper"></i>Natural
                            </label>
                            <label>
                                <input id="idRadioJuridica" type="radio" value="juridica" name="tipoPersona" >
                                <i class="helper"></i>Jurídico
                            </label>
                       
                    </div>
                    
                </div>             

                <div class="form-group row">
                    <button type="button" class="btn btn-primary m-r-10" id="idBtnAgregarCliente">Agregar Cliente</button>
                    <button type="button" class="btn btn-default waves-effect md-close" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>