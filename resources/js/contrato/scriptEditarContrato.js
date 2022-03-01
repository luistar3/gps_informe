$(document).ready(function () {


    fncListarMarcasVehiculos();
    fncObtenerContrato();
    fncRenderDatatableListadoVehiculo();


    $("#idInputPlacaVehiculo").bind("change paste keyup", function () {
        $(this).val($(this).val().replace(/ /g, ""));
        var sizeInput = $(this).val().length;
        var placa = $(this).val();
        console.log(sizeInput);
        var characterPlaca = 7;
        if (sizeInput >= characterPlaca) {
            $("#idDivBusquedaPlaca").removeClass("d-none");
            fncBuscarPlacaDisponible(idContrato, placa);
        } else {
            $("#idDivBusquedaPlaca").addClass("d-none");
        }
    });

    fncBuscarPlacaDisponible2();

});

function fncBuscarPlacaDisponible2() {
    $("#idInputSelectPlacaAgregar").html('');
    var data = {
        "idContrato": idContrato
    }
    $.ajax({
        type: "GET",
        url: "/gps/src/private/ContratoVehiculoPLacaDisponibleListar2.php",
        data: data,
        success: function (response) {
            var jsonData = JSON.parse(response);
            $("#idInputSelectPlacaAgregar").append('<option value="0">Seleccione Una Placa</option>');
            $.each(jsonData.data, function (indexInArray, value) {
                var option = '<option value="' + value.idVehiculo + '">' + value.placa + '    ->    ' + value.marca + '</option>'

                $("#idInputSelectPlacaAgregar").append(option);
            });
        }
    });
}

function fncBuscarPlacaDisponible(idContrato, placa) {
    var data = {
        "idContrato": idContrato,
        "placa": placa
    }
    $.ajax({
        type: "GET",
        url: "/gps/src/private/ContratoVehiculoPLacaDisponibleListar.php",
        data: data,
        success: function (response) {
            var jsonData = JSON.parse(response);
            if (!(jsonData.error)) {
                var vehiculo = jsonData.data[0];
                if (jsonData.data.length > 0) {
                    $("#idTextPlacaSmall").text(vehiculo.marca + '- - vehiculo ingresado en ' + vehiculo.otrosContratos + ' contratos ->' + vehiculo.nombres);
                } else {
                    $("#idTextPlacaSmall").text("Vehiculo no existe o ya esta registrado en el contrato");
                }

            }
        }
    });
}

function fncListarMarcasVehiculos() {

    $.ajax({
        type: "GET",
        url: "/gps/src/private/MarcaVehiculoListar.php",
        data: "data",
        success: function (response) {

            var jsonData = JSON.parse(response);
            for (let index = 0; index < jsonData.data.length; index++) {
                $('.selectMarcaVehiculo').append($('<option>', {
                    value: jsonData.data[index].idMarcaVehiculo,
                    text: jsonData.data[index].marca
                }));

            }
            $.duplicate();

        }

    });

}

function fncObtenerContrato() {

    $.ajax({
        type: "GET",
        url: "/gps/src/private/ContratoObtener.php",
        data: { id: idContrato },  //constante creada en controllador
        success: function (response) {
            var dataReturn = JSON.parse(response);
            fncSetDataInputs(dataReturn.data);
        }
    });
}

function fncSetDataInputs(data) {
    $("#idInputCliente").val(data.nombre);
    $("#idInputMensualidadContrato").val(data.mensualidad);
    $("#idInputFechaInicioContrato").val(data.fechaInicio);
    $("#idInputFechaFinContrato").val(data.fechaFin);
    if (data.contrato == null || data.contrato == "") {
        $("#idInputVerArchivoContrato").addClass("intro");
        $("#idInputVerArchivoContrato").html("Contrato no cargado");
    } else {
        $("#idInputVerArchivoContrato").prop("href", '../../' + data.contrato)
    }

}
$("#idInputVerArchivoContrato").click(function (e) {

});

function fncRenderDatatableListadoVehiculo() {

    var table = $('#idListadoVehiculos').DataTable();
    table.clear();
    table.destroy();
    var table = $('#idListadoVehiculos').DataTable({
        'destroy': true,
        responsive: true,
        "ajax": {
            type: "GET",
            "url": "/gps/src/private/ContratoListarVehiculo.php",
            "data": { idContrato: idContrato } //constante creada en controllador
        },
        "dataSrc": function (json) {
            var result = JSON.parse(json);
            return result.data;
        },
        "pageLength": 10,
        "processing": true, // Si se muestra el estado de procesamiento (al ordenar, una gran cantidad de datos lleva mucho tiempo, esto también se mostrará)
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [[1, 'asc']],
        "language": {
            url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json'
        },
        "columns": [
            { "defaultContent": '' },
            { "data": "frecuenciaPago" },
            { "data": "montoPago" },
            { "data": "marca" },
            { "data": "placa" },
            { "data": "modelo" },
            { "data": "anio" },
            { "data": "gps" },
            { "data": "imei" },
            { "data": "fechaInstalacion" },
            { "data": "fechaTermino" },
            {
                "defaultContent": "",
                render: function (data, type, row) {
                    return '<button id="idBtnEditarContratoVehiculo" class="btn btn-mini btn-warning btn-round">Editar Datos</button> '+
                    '<button id="idBtnEliminarContratoVehiculo" class="btn btn-mini btn-danger btn-round">Eliminar</button>';
                }
            }

        ],
        initComplete: function () { //opcion de busqueda parte inferior
            this.api().columns("1,2").every(function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }

    });
    $('#idListadoVehiculos tbody').off('click');
    table.on('order.dt search.dt', function () { //numeracion para la tabla
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
    $('#idListadoVehiculos tbody').on('click', 'tr', function () { //seleccionar fila
        //$(this).toggleClass('selected');
    });
    $('#button').click(function () { //click event filas seleccionadas

        table.rows('.selected').data().map((row) => {
            console.log(row);
        });
    });
    $('#idListadoVehiculos tbody').on('click', '#idBtnEditarContratoVehiculo', function () {

        var data = table.row($(this).parents('tr')).data();
        var modal = document.getElementById("idModalEditarVehiculoContrato");
        maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 3 });
        classie.add(modal, 'md-show');

        $("#idInputEditarFrecuenciaPago").val(data.frecuenciaPago);
        $("#idInputEditarFechaInicio").val(data.fechaInstalacion);
        $("#idInputEditarFechaFin").val(data.fechaTermino);
        $("#idInputEditarMontoPago").val(data.montoPago);
        $("#idInputEditarIdVehiculo").val(data.idContratoVehiculo);

    });
    $('#idListadoVehiculos tbody').on('click', '#idBtnEliminarContratoVehiculo', function () {

        var data = table.row($(this).parents('tr')).data();
        //maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 3 });
        fncEnviarEliminarContratoVehiculo(data.idContratoVehiculo);

        // $("#idInputEditarFrecuenciaPago").val(data.frecuenciaPago);
        // $("#idInputEditarFechaInicio").val(data.fechaInstalacion);
        // $("#idInputEditarFechaFin").val(data.fechaTermino);
        // $("#idInputEditarMontoPago").val(data.montoPago);
        // $("#idInputEditarIdVehiculo").val(data.idContratoVehiculo);

    });
    


}
$(".md-close").click(function (e) {
    var modal = document.getElementById("idModalEditarVehiculoContrato");
    classie.remove(modal, 'md-show');
    maskOff(document.getElementsByClassName("main-body"));

    var modal2 = document.getElementById("idModalAgregarVehiculoContrato");
    classie.remove(modal2, 'md-show');

    $("#idInputAgregarFechaFin").removeClass("form-control-danger");
    $("#idInputAgregarFechaInicio").removeClass("form-control-danger");
    $("#idInputAgregarMontoPago").removeClass("form-control-danger");
    $("#idInputAgregarMontoPago").val('');
    $("#idInputEditarMontoPago").removeClass("form-control-danger");
    $("#idInputEditarMontoPago").val('');
    $("#idInputAgregarFechaFin").val('');
    $("#idInputAgregarFechaInicio").val('');
    $("#idInputEditarIdVehiculo").val('0');


    

});

function fncActivarInputsContratos() {
    $("#idBtnEditarContrato").removeClass("d-none");

    $("#idBtnActivarEditarContrato").addClass("d-none");
    $("#idBtnCancelarEditarContrato").removeClass("d-none");
    $("#idInputMensualidadContrato").removeAttr('disabled');
    $("#idInputFechaInicioContrato").removeAttr('disabled');
    $("#idInputFechaFinContrato").removeAttr('disabled');
    $("#idInputArchivoContrato").removeAttr('disabled');

}
function fncDesactivarInputsContrato() {
    $("#idBtnActivarEditarContrato").removeClass("d-none");
    $("#idBtnEditarContrato").addClass("d-none");
    $("#idBtnCancelarEditarContrato").addClass("d-none");


    $("#idInputMensualidadContrato").prop('disabled', true);
    $("#idInputFechaInicioContrato").prop('disabled', true);
    $("#idInputFechaFinContrato").prop('disabled', true);
    $("#idInputArchivoContrato").prop('disabled', true);

}

$("#idBtnActivarEditarContrato").click(function (e) {
    fncActivarInputsContratos();

});

$("#idBtnEditarContrato").click(function (e) {
    fncValidarData();
    var data = new FormData();
    data.append('fechaInicio', $('#idInputFechaInicioContrato').val());
    data.append('fechaFin', $('#idInputFechaFinContrato').val());
    data.append('mensualidadContrato', $('#idInputMensualidadContrato').val());
    data.append('archivo', $('#idInputArchivoContrato')[0].files[0]);
    data.append('idContrato', idContrato);


    if (fncValidarData()) {
        swal({
            title: "Estas seguro?",
            text: "Los datos seran enviados para edicion del Contrato!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, enviar",
            cancelButtonText: "No, cancelar",
            closeOnConfirm: false,
            closeOnCancel: false,

        },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        data: data,
                        url: '/gps/src/private/ContratoGuardar.php',
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function (response) {
                            var jsonData = JSON.parse(response);
                            if (jsonData.error == false) {
                                swal("Registrado", jsonData.mensaje, "success");
                                $("#idInputVerArchivoContrato").html("PDF");
                                $("#idInputVerArchivoContrato").prop("href", '../../' + jsonData.data.contrato)
                                fncDesactivarInputsContrato();
                            }

                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            var jsonData = JSON.parse(XMLHttpRequest.responseText);
                            swal("Error", jsonData.mensaje, "error");
                        }
                    });

                } else {
                    swal("Cancelado", "Los datos no se enviaron", "error");
                }
            });
    } else {

    }

});

$("#idBtnCancelarEditarContrato").click(function (e) {
    fncDesactivarInputsContrato();
});

function fncValidarData() {
    var valido = true;
    var startDate = new Date($('#idInputFechaInicioContrato').val());
    var endDate = new Date($('#idInputFechaFinContrato').val());
    var montoMensualidad = $('#idInputMensualidadContrato').val();



    if (startDate > endDate) {
        swal("Dato no admitidos", "Fecha Inicio debe que ser menor a Fecha Fin", 'error');
        valido = false;
    }
    if (montoMensualidad <= 0) {
        swal("Dato no admitidos", "Mensualidad debe ser positivo", 'error');
        $("#idInputMensualidadContrato").addClass("form-control-danger");
        valido = false;
    } else {
        $("#idInputMensualidadContrato").removeClass("form-control-danger");
    }
    return valido;

}

$("#idBtnModalAgregarPlaca").click(function (e) {

    var idVehiculo = $("#idInputSelectPlacaAgregar").val();
    if (idVehiculo != 0) {
        var modal = document.getElementById("idModalAgregarVehiculoContrato");
        maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 3 });
        classie.add(modal, 'md-show');

    } else {
        swal("Datos no admitidos", "Debe seleccionar una placa", 'error');
    }

});

$("#idBtnAgregarContratoVehiculo").click(function (e) {

    var valido = true;
    var startDate = new Date($('#idInputAgregarFechaInicio').val());
    var endDate = new Date($('#idInputAgregarFechaFin').val());
    var montoMensualidad = $('#idInputAgregarMontoPago').val();
    var frecuenciPago = $("#idInputAgregarFrecuenciaPago").val();

    
    if (isNaN(startDate.getTime())) {  // d.valueOf() could also work
        // date is not valid
      } else {
        // date is valid
      }
  
    if ((startDate > endDate) || (isNaN(startDate.getTime())&&isNaN(endDate.getTime()))) {
        swal("Dato no admitidos", "Fecha Inicio debe que ser menor a Fecha Fin", 'error');
        $("#idInputAgregarFechaFin").addClass("form-control-danger");
        $("#idInputAgregarFechaInicio").addClass("form-control-danger");
        valido = false;
    } else {
        $("#idInputAgregarFechaFin").removeClass("form-control-danger");
        $("#idInputAgregarFechaInicio").removeClass("form-control-danger");
    }
    if (montoMensualidad <= 0) {
        swal("Dato no admitidos", "Mensualidad debe ser positivo", 'error');
        $("#idInputAgregarMontoPago").addClass("form-control-danger");
        valido = false;
    } else {
        $("#idInputAgregarMontoPago").removeClass("form-control-danger");
    }
    if (valido) {
        var idVehiculo = $("#idInputSelectPlacaAgregar").val();
        console.log("valido");
        var data = {
            "fechaInstalacion": $('#idInputAgregarFechaInicio').val(),
            "fechaTermino": $('#idInputAgregarFechaFin').val(),
            "montoPago": montoMensualidad,
            "frecuenciaPago": frecuenciPago,
            "idContrato": idContrato,
            "idVehiculo": idVehiculo
        }
        fncEnviarGuardarContratoVehiculo(data);
    }

});

$("#idBtnEditarContratoVehiculo").click(function (e) {

    var valido = true;
    
    var endDate = new Date($('#idInputEditarFechaFin').val());
    var montoMensualidad = $('#idInputEditarMontoPago').val();
    var idContratoVehiculo = $('#idInputEditarIdVehiculo').val();
    var startDate = new Date($('#idInputEditarFechaInicio').val());
    
    

  
    if ((startDate > endDate) || (isNaN(endDate.getTime()))) {
        swal("Dato no admitidos", "Fecha Inicio debe que ser menor a Fecha Fin", 'error');
        $("#idInputEditarFechaFin").addClass("form-control-danger");
        valido = false;
    } else {
        $("#idInputEditarFechaFin").removeClass("form-control-danger");
        $("#idInputAgregarFechaInicio").removeClass("form-control-danger");
    }
    if (montoMensualidad <= 0) {
        swal("Dato no admitidos", "Mensualidad debe ser positivo", 'error');
        $("#idInputEditarMontoPago").addClass("form-control-danger");
        valido = false;
    } else {
        $("#idInputEditarMontoPago").removeClass("form-control-danger");
    }
    if (valido) {
      
        var data = {
            
            "fechaTermino": $('#idInputEditarFechaFin').val(),
            "montoPago": montoMensualidad,
            "idContratoVehiculo": idContratoVehiculo
        }
        fncEnviarGuardarContratoVehiculo(data);
    }

});



function fncEnviarGuardarContratoVehiculo(data) {


    swal({
        title: "Estas seguro?",
        text: "Los datos seran enviados para edicion del Contrato!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, enviar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: false,

    },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: '/gps/src/private/ContratoVehiculoGuardar.php',
                    data: data,
                    success: function (response) {
                        var jsonData = JSON.parse(response);
                        fncRenderDatatableListadoVehiculo();
                        fncBuscarPlacaDisponible2();
                        swal("Registrado", jsonData.mensaje, "success");
                        var modal = document.getElementById("idModalAgregarVehiculoContrato");
                        classie.remove(modal, 'md-show');
                        var modal = document.getElementById("idModalEditarVehiculoContrato");
                        classie.remove(modal, 'md-show');
                        maskOff(document.getElementsByClassName("main-body"));
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                            var jsonData = JSON.parse(XMLHttpRequest.responseText);
                            swal("Error", jsonData.mensaje, "error");
                    }
                });

            } else {
                swal("Cancelado", "Los datos no se enviaron", "error");
            }
        });



}

function fncEnviarEliminarContratoVehiculo(idContratoVehiculo) {

    var data ={
        "idContratoVehiculo":idContratoVehiculo
    }
    swal({
        title: "Estas seguro?",
        text: "Los datos seran enviados para Eliminacion del Vehículo en el contrato!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, enviar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: false,

    },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: '/gps/src/private/ContratoVehiculoEliminar.php',
                    data: data,
                    success: function (response) {
                        var jsonData = JSON.parse(response);
                        fncRenderDatatableListadoVehiculo();
                        fncBuscarPlacaDisponible2();
                        swal("Eliminado", jsonData.mensaje, "success");
                        
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                            var jsonData = JSON.parse(XMLHttpRequest.responseText);
                            swal("Error", jsonData.mensaje, "error");
                            
                    }
                });

            } else {
                swal("Cancelado", "El dato no se eliminó", "error");
                
            }
        });



}





