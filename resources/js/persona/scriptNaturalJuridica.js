$(document).ready(function () {
    $('#idBtnAgregarEditarPersona').on('click', (e) => {
        e.preventDefault();
        $('#idFormPersona').submit();
        return false;
    });
    $('#idBtnAgregarEditarPersonaJuridica').on('click', (e) => {
        e.preventDefault();
        $('#idFormPersonaJuridica').submit();
        return false;
    });

    fncRenderizarDataTable();
    fncRenderizarDataTableJuridico();
});


$(".md-close").click(function (e) {
    /* PERSONA NATURAL */
    maskOff(document.getElementsByClassName("main-body"));
    $("#idBtnAgregarEditarPersona").html("Agregar Persona");
    var modal = document.getElementById("idModalGuardarEditar");
    classie.remove(modal, 'md-show')
    $("#idFormPersona").validate().resetForm();
    $("#idInputNombres").val('');
    $("#idInputApellidos").val('');
    $("#idInputDni").val('');
    $("#idInputDireccion").val('');
    $("#idInputCorreo").val('');
    $("#idInputTelefono").val('');
    $("#idInputIdPersona").val('0');
    $("#idInputDni").attr("readonly", false);

    /* PERSONA JURIDICA */

    $("#idBtnAgregarEditarPersonaJuridica").html("Agregar Persona Juridica");
    var modal = document.getElementById("idModalJuridicaGuardarEditar");
    classie.remove(modal, 'md-show');
    $('#IdInputRazonSocial').removeAttr("disabled");
    $('#IdInputRuc').removeAttr("disabled");
    $('#IdInputRazonSocial').val("");
    $('#IdInputRuc').val("");
    $('#idInputIdPersonaJuridica').val("0");
});


var dniInput = $("#idInputDni");
dniInput.change(function () {

    if (dniInput.val().length > 7 && dniInput.val().length < 9) {
        var persona = fncGetDataDni($("#idInputDni").val());
    }

});

function fncGetDataDni(dni) {
    var data = {
        'dni': dni
    }
    var persona = null;
    $.ajax({
        type: "GET",
        url: "https://rest.softdatamen.com/v1/0e622529d7b8d35ba8a9885d334bc84b/reniec/avanzado",
        data: data,
        success: function (response) {
            //var jsonData = JSON.parse(response);
            console.log(response);
            if (response.success) {
                $("#idInputNombres").val(response.result.nombres.toString());
                $("#idInputApellidos").val(response.result.apellido_paterno.toString() + ' ' + response.result.apellido_materno.toString());
                //console.log(response.print);
                if (response.print == '' || response.print == null) { } else {
                    // console.log("a");
                    $('#idInputNombres').attr("disabled", true);
                    $('#idInputApellidos').attr("disabled", true);
                    $('#idInputDni').attr("disabled", true);
                }

            }
        },
        complete: function (xhr, status) {
            if (dniInput.val().length > 8) {
                $('#idInputNombres').attr("disabled", false);
                $('#idInputApellidos').attr("disabled", false);
                $('#idInputDni').attr("disabled", false);
            }
        }
    });

}



function fncRenderizarDataTable() {

    var table = $('#idListadoPersonas').DataTable();
    table.clear();
    table.destroy();
    var table = $('#idListadoPersonas').DataTable({
        'destroy': true,
        pageLength : 5,
        "ajax": {
            type: "GET",
            "url": "/gps/src/private/PersonaNaturalListar.php",
            cache: true

        },
        "dataSrc": function (json) {
            var result = JSON.parse(json);
            return result.data;
        },
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [[1, 'asc']],
        "language": {
            url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        "columns": [

            { "defaultContent": '' },
            {
                "data": "nombres"
            },
            {
                "data": "apellidos"
            },
            { "data": "dni" },
            { "data": "direccion" },
            { "data": "correo" },
            { "data": "createdAt" },
            { "data": "updatedAt" },
            {
                "defaultContent": '',
                render: function (data, type, row) {
                    var btn = '<button id="idBtnEditarPersona" class="btn btn-mini btn-warning btn-round">Editar</button>';

                    return btn;
                }
            }
        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            // total = api
            //     .column(2)
            //     .data()
            //     .reduce(function (a, b) {
            //         return intVal(a) + intVal(b);
            //     }, 0);
            // $("#idSumaTotalPagoVehiculo").val("S/. " + total);
        },


    });
    $('#idListadoPersonas tbody').off('click');
    table.on('order.dt search.dt', function () { //numeracion para la tabla
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $('#idListadoPersonas tbody').on('click', '#idBtnEditarPersona', function () {

        var data = table.row($(this).parents('tr')).data();
        var rowData = null;
        if (data == undefined) {
            var selected_row = $(this).parents('tr');
            if (selected_row.hasClass('child')) {
                selected_row = selected_row.prev();
            }
            rowData = $('#idListadoPersonas').DataTable().row(selected_row).data();
        } else {
            rowData = data;
        }
        $("#idInputDni").attr("readonly", true);
        $("#idBtnAgregarEditarPersona").html("Editar Vehículo");
        $("#idModalGuardarEditar").addClass("md-show");
        maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 2 });
        $("#idInputNombres").val(rowData.nombres);
        $("#idInputApellidos").val(rowData.apellidos);
        $("#idInputDni").val(rowData.dni);
        $("#idInputDireccion").val(rowData.direccion);
        $("#idInputCorreo").val(rowData.correo);
        $("#idInputTelefono").val(rowData.telefono);
        $("#idInputIdPersona").val(rowData.idPersona);


    });

    // $('#idListadoPersonas tbody').on('click', '#idBtnDeshabilitarVehiculo', function () {
    //     var data = table.row($(this).parents('tr')).data();
    //     var rowData = null;
    //     if (data == undefined) {
    //         var selected_row = $(this).parents('tr');
    //         if (selected_row.hasClass('child')) {
    //             selected_row = selected_row.prev();
    //         }
    //         rowData = $('#idListadoPersonas').DataTable().row(selected_row).data();
    //     } else {
    //         rowData = data;
    //     }


    //     var sendData = {
    //         "idVehiculo": rowData.idVehiculo,
    //         "estado": rowData.estado
    //     }
    //     swal({
    //         title: "Estas seguro?",
    //         text: "Los dato seran enviados para deshabilitar este Vehículo!",
    //         type: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#DD6B55",
    //         confirmButtonText: "Si, enviar",
    //         cancelButtonText: "No, cancelar",
    //         closeOnConfirm: false,
    //         closeOnCancel: false
    //     },
    //         function (isConfirm) {
    //             if (isConfirm) {
    //                 $.ajax({
    //                     type: "GET",
    //                     url: '/gps/src/private/VehiculoDeshabilitar.php',
    //                     data: sendData,
    //                     success: function (response) {
    //                         var jsonData = JSON.parse(response);
    //                         // console.log(jsonData);
    //                         if (jsonData.error == false) {
    //                             swal("Deshabilitado", jsonData.mensaje, "success");
    //                             fncRenderizarDataTable();

    //                         } else {
    //                             swal("Error", jsonData.mensaje, "error");
    //                         }
    //                     }
    //                     ,
    //                     error: function (XMLHttpRequest, textStatus, errorThrown) {
    //                         var jsonData = JSON.parse(XMLHttpRequest.responseText);
    //                         swal("Error", jsonData.mensaje, "error");
    //                     }
    //                 });

    //             } else {
    //                 swal("Cancelado", "Los datos no se enviaron", "error");
    //             }
    //         });
    // });


}

$("#idModalMostrarGuardarEditar").click(function (e) {
    maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 2 });
    $("#idModalGuardarEditar").addClass("md-show");
    //$("#idInputPlacaVehiculo").attr("readonly", false);
    $("#idBtnAgregarEditarPersona").html("Agregar Persona");
    $("#idInputIdPersona").val('0');
});




$('#idFormPersona').validate({
    rules: {
        idInputNombres: {
            required: true,
            minlength: 2,
        },
        idInputApellidos: {
            required: true,
            minlength: 2,
        },
        idInputDireccion: {
            required: true,
        },
        idInputCorreo: {
            required: true,
            email: true,
        },
        idInputDni: {
            required: true,
            digits: true,
        },
        idInputTelefono: {
            required: true,
            digits: true,
        },
    },
    submitHandler: function (form) {
        var nombres = $('#idInputNombres').val();
        var apellidos = $('#idInputApellidos').val();
        var telefono = $('#idInputTelefono').val();
        var dni = $('#idInputDni').val();
        var direccion = $('#idInputDireccion').val();
        var correo = $('#idInputCorreo').val();
        var idInputIdPersona = $('#idInputIdPersona').val();

        var data = {
            'nombres': nombres,
            'apellidos': apellidos,
            'telefono': telefono,
            'dni': dni,
            'direccion': direccion,
            'correo': correo,
        }
        if (parseInt(idInputIdPersona) != 0) {
            data["idPersona"] = idInputIdPersona;
        }

        fncGuardarEditarPersona(data);
        return false;
    }
});


function fncGuardarEditarPersona(data) {

    swal({
        title: "Estas seguro?",
        text: "Los dato seran enviados para registro de una Persona!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, enviar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: '/gps/src/private/PersonaGuardar.php',
                    data: data,
                    success: function (response) {
                        var jsonData = JSON.parse(response);
                        console.log(jsonData);
                        if (jsonData.error == false) {
                            swal("Registrado", jsonData.mensaje, "success");
                            fncRenderizarDataTable();
                            fncListarPersonasNaturales();
                            maskOff(document.getElementsByClassName("main-body"));
                            var modal = document.getElementById("idModalGuardarEditar");
                            classie.remove(modal, 'md-show')
                        } else {
                            swal("Error", jsonData.mensaje, "error");
                        }
                    }
                    ,
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


/** PERSONA JURIDICA */

$(document).ready(function () {
    $('#idBtnAgregarEditarPersonaJuridica').on('click', (e) => {
        e.preventDefault();
        $('#idFormPersonaJuridica').submit();
        return false;
    })
});

$("#idModalJuridicaMostrarGuardarEditar").click(function (e) {
    maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 2 });
    $("#idModalJuridicaGuardarEditar").addClass("md-show");
    $("#IdInputDniRepresentanteLegal").val('');
    $('#IdInputDniRepresentanteLegal').trigger('change');

    $('#IdInputRazonSocial').removeAttr("disabled");
    $('#IdInputRuc').removeAttr("disabled");
    $('#IdInputRazonSocial').val("");
    $('#IdInputRuc').val("");
    $('#idInputIdPersonaJuridica').val("0");
    $('#IdInputCorreoJuridica').val("");
    $("#idBtnAgregarEditarPersonaJuridica").html("Agregar Persona");
    
    //$("#idInputPlacaVehiculo").attr("readonly", false);
    //$("#idBtnAgregarEditarPersona").html("Agregar Persona");
    //$("#idInputIdPersona").val('0');
});

$('.validanumericos').keypress(function (e) {
    if (isNaN(this.value + String.fromCharCode(e.charCode)))
        return false;
}).on("cut copy paste", function (e) {
    e.preventDefault();
});


$("#IdInputDniRepresentanteLegal").select2({
    dropdownParent: $("#idModalJuridicaGuardarEditar")
});
fncListarPersonasNaturales();
function fncListarPersonasNaturales() {

    $.ajax({
        type: "GET",
        url: "/gps/src/private/PersonaNaturalListar.php",
        data: "data",
        success: function (response) {

            $('#IdInputDniRepresentanteLegal').empty();
            var selectPersonaNatural = $("#IdInputDniRepresentanteLegal");
            var result = JSON.parse(response);
            var optionDefault = '<option value="">Elija el DNI de un Representate Legal</option>';
            selectPersonaNatural.append(optionDefault);
            $.each(result.data, function (indexInArray, valueOfElement) {
                var option = '<option value="' + valueOfElement.idPersona + '">' + valueOfElement.dni + ' : ' + valueOfElement.nombres + ' ' + valueOfElement.apellidos + '</option>';
                selectPersonaNatural.append(option);
            });
        }
    });
}


$('#idFormPersonaJuridica').validate({
    rules: {
        IdInputRuc: {
            required: true,
            minlength: 11,
            digits: true,
        },
        IdInputRazonSocial: {
            required: true,
        },
        IdInputDniRepresentanteLegal: {
            minlength: 1,
            required: true
        },

    },
    messages: {
        IdInputDniRepresentanteLegal: "Es obligatorio un DNI",
    },
    // highlight: function (element, errorClass, validClass) {
    //     $(element).addClass('form-control-danger');
    // },
    // unhighlight: function (element, errorClass, validClass) {
    //     $(element).removeClass('form-control-danger');
    // },
    submitHandler: function (form) {
        var ruc = $('#IdInputRuc').val();
        var razonSocial = $('#IdInputRazonSocial').val();
        var correo = $('#IdInputCorreoJuridica').val();
        var idRepresentanteLegal = $('#IdInputDniRepresentanteLegal').val();
        var idJuridico = $('#idInputIdPersonaJuridica').val();


        var tipoPersona = 'personaJuridica';
        var formData = new FormData();

        var data = {
            'ruc': ruc,
            'razonSocial': razonSocial,
            'correo': correo,
            'idRepresentanteLegal': idRepresentanteLegal
        }
        if (parseInt(idJuridico) != 0) {
            data["idJuridico"] = idJuridico;
        }

        fncGuardarPersonaJuridica(data);
        return false;
    }
});

function fncGuardarPersonaJuridica(data) {

    swal({
        title: "Estas seguro?",
        text: "Los dato seran enviados para registro de una Persona Jurídica",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, enviar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: '/gps/src/private/PersonaJuridicaGuardar.php',
                    data: data,
                    success: function (response) {
                        var jsonData = JSON.parse(response);
                        console.log(jsonData);
                        if (jsonData.error == false) {
                            swal("Registrado", jsonData.mensaje, "success");
                           // $('#modalLargeNuevoCliente').modal('hide');
                           fncRenderizarDataTableJuridico();
                            maskOff(document.getElementsByClassName("main-body"));
                            var modal = document.getElementById("idModalJuridicaGuardarEditar");
                            classie.remove(modal, 'md-show')
                        } else {
                            swal("Error", jsonData.mensaje, "error");
                        }
                    }
                    ,
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

var rucInput = $("#IdInputRuc");
rucInput.change(function () {
    console.log("jo");
    if (rucInput.val().length > 10 && rucInput.val().length < 12) {
        //console.log($("#inputDniVisita").val());
        var juridica = fncGetDataRuc($("#IdInputRuc").val());
    }

});
function fncGetDataRuc(dni) {

    console.log("entro");
    $.ajax({
        type: "GET",
        url: "https://consultaruc.win/api/ruc/" + dni,

        success: function (response) {
            //var jsonData = JSON.parse(response);
            //console.log(response);
            if (response.result) {
                $("#IdInputRazonSocial").val(response.result.razon_social.toString());
                if (response.result.razon_social === '' || response.result.razon_social === null) { } else {
                    $('#IdInputRazonSocial').attr("disabled", true);
                    $('#IdInputRuc').attr("disabled", true);
                }
            }
        },
        complete: function (xhr, status) {
            if (dniInput.val().length > 8) {
                $('#IdInputRazonSocial').attr("disabled", false);
                $('#IdInputRuc').attr("disabled", false);
            }
        }
    });

}


function fncRenderizarDataTableJuridico() {

    var table = $('#idListadoPersonaJuridica').DataTable();
    table.clear();
    table.destroy();
    var table = $('#idListadoPersonaJuridica').DataTable({
        'destroy': true,
        pageLength : 5,
        "ajax": {
            type: "GET",
            "url": "/gps/src/private/PersonaJuridicaListar.php",
            cache: true

        },
        "dataSrc": function (json) {
            var result = JSON.parse(json);
            return result.data;
        },
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [[1, 'asc']],
        "language": {
            url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
        },
        "columns": [

            { "defaultContent": '' },
            {
                "data": "ruc"
            },
            {
                "data": "razonSocial"
            },
            { "data": "contratos" },
            { "data": "correo" },
            { "data": "nombreRepresentanteLegal" },
            { "data": "createdAt" },
            { "data": "updatedAt" },
            {
                "defaultContent": '',
                render: function (data, type, row) {
                    var btn = '<button id="idBtnEditarPersonaJuridica" class="btn btn-mini btn-warning btn-round">Editar</button>';

                    return btn;
                }
            }
        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            // total = api
            //     .column(2)
            //     .data()
            //     .reduce(function (a, b) {
            //         return intVal(a) + intVal(b);
            //     }, 0);
            // $("#idSumaTotalPagoVehiculo").val("S/. " + total);
        },


    });
    $('#idListadoPersonaJuridica tbody').off('click');
    table.on('order.dt search.dt', function () { //numeracion para la tabla
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $('#idListadoPersonaJuridica tbody').on('click', '#idBtnEditarPersonaJuridica', function () {

        var data = table.row($(this).parents('tr')).data();
        var rowData = null;
        if (data == undefined) {
            var selected_row = $(this).parents('tr');
            if (selected_row.hasClass('child')) {
                selected_row = selected_row.prev();
            }
            rowData = $('#idListadoPersonaJuridica').DataTable().row(selected_row).data();
        } else {
            rowData = data;
        }
        $("#idInputDni").attr("readonly", true);
        $("#idBtnAgregarEditarPersonaJuridica").html("Editar Jurídica");
        $("#idModalJuridicaGuardarEditar").addClass("md-show");
        maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 2 });
        $("#idInputIdPersonaJuridica").val(rowData.idJuridico);
        $("#IdInputRuc").val(rowData.ruc);

        $("#IdInputRazonSocial").val(rowData.razonSocial);
        $("#IdInputDniRepresentanteLegal").val(rowData.idRepresentanteLegal);
        $('#IdInputDniRepresentanteLegal').trigger('change'); // Notify any JS components that the value changed
        $("#idInputCorreo").val(rowData.nombreRepresentanteLegal);
        $("#IdInputCorreoJuridica").val(rowData.correo);
        $("#IdInputRuc").attr("disabled", true);
        $("#IdInputRazonSocial").attr("disabled", true);


    });

    // $('#idListadoPersonaJuridica tbody').on('click', '#idBtnDeshabilitarVehiculo', function () {
    //     var data = table.row($(this).parents('tr')).data();
    //     var rowData = null;
    //     if (data == undefined) {
    //         var selected_row = $(this).parents('tr');
    //         if (selected_row.hasClass('child')) {
    //             selected_row = selected_row.prev();
    //         }
    //         rowData = $('#idListadoPersonaJuridica').DataTable().row(selected_row).data();
    //     } else {
    //         rowData = data;
    //     }

    //     //console.log(rowData);
    //     var sendData = {
    //         "idVehiculo": rowData.idVehiculo,
    //         "estado": rowData.estado
    //     }
    //     swal({
    //         title: "Estas seguro?",
    //         text: "Los dato seran enviados para deshabilitar este Vehículo!",
    //         type: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#DD6B55",
    //         confirmButtonText: "Si, enviar",
    //         cancelButtonText: "No, cancelar",
    //         closeOnConfirm: false,
    //         closeOnCancel: false
    //     },
    //         function (isConfirm) {
    //             if (isConfirm) {
    //                 $.ajax({
    //                     type: "GET",
    //                     url: '/gps/src/private/VehiculoDeshabilitar.php',
    //                     data: sendData,
    //                     success: function (response) {
    //                         var jsonData = JSON.parse(response);
    //                         // console.log(jsonData);
    //                         if (jsonData.error == false) {
    //                             swal("Deshabilitado", jsonData.mensaje, "success");
    //                             fncRenderizarDataTable();

    //                         } else {
    //                             swal("Error", jsonData.mensaje, "error");
    //                         }
    //                     }
    //                     ,
    //                     error: function (XMLHttpRequest, textStatus, errorThrown) {
    //                         var jsonData = JSON.parse(XMLHttpRequest.responseText);
    //                         swal("Error", jsonData.mensaje, "error");
    //                     }
    //                 });

    //             } else {
    //                 swal("Cancelado", "Los datos no se enviaron", "error");
    //             }
    //         });
    // });


}
