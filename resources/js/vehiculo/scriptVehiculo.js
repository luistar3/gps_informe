$(document).ready(function () {

    $('#idBtnAgregarNuevoVehiculo').on('click', (e) => {
        e.preventDefault();
        $('#idFormVehiculo').submit();
        return false;
    })

    fncRenderizarDataTable();
    fncListarMarcasVehiculos();
});



function fncRenderizarDataTable() {

    var table = $('#idListadoVehiculo').DataTable();
    table.clear();
    table.destroy();
    var table = $('#idListadoVehiculo').DataTable({
        'destroy': true,
        "ajax": {
            type: "GET",
            "url": "/gps/src/private/VehiculoListar.php"
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
                "data": "placa",

                createdCell: function (td, cellData, rowData, row, col) {
                    var color = (rowData.estado == 1) ? '#636363' : '#ff5757';
                    $(td).css('border', color + ' solid 3px');
                }
            },
            {
                "data": "marca"
            },
            { "data": "modelo" },
            { "data": "anio" },
            { "data": "gps" },
            { "data": "imei" },
            { "data": "createdAt" },
            {
                "data": "estado",
                render: function (data, type, row) {
                    var btn = '<button id="idBtnEditarVehiculo" class="btn btn-mini btn-warning btn-round">Editar</button>';
                    if (data == 1) {
                        btn += '<button id="idBtnDeshabilitarVehiculo" class="btn btn-mini btn-danger btn-round">Deshabilitar</button>';
                    } else {
                        btn += '<button id="idBtnDeshabilitarVehiculo" class="btn btn-mini btn-secondary btn-round">Habilitar</button>';
                    }
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
        initComplete: function () { //opcion de busqueda parte inferior
            this.api().columns("4,2,3").every(function () {
                var column = this;
                var select = $('<select class="" ><option value="">Todos</option></select>')
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
    $('#idListadoVehiculo tbody').off('click');
    table.on('order.dt search.dt', function () { //numeracion para la tabla
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $('#idListadoVehiculo tbody').on('click', '#idBtnEditarVehiculo', function () {

        var data = table.row($(this).parents('tr')).data();
        var rowData = null;
        if (data == undefined) {
            var selected_row = $(this).parents('tr');
            if (selected_row.hasClass('child')) {
                selected_row = selected_row.prev();
            }
            rowData = $('#idListadoVehiculo').DataTable().row(selected_row).data();
        } else {
            rowData = data;
        }
        $("#idInputPlacaVehiculo").attr("readonly", true);
        $("#idBtnAgregarNuevoVehiculo").html("Editar Vehículo");
        $("#idModalListadoVehiculo").addClass("md-show");
        maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 2 });
        $("#idInputIdVehiculo").val(rowData.idVehiculo);
        $("#idInputPlacaVehiculo").val(rowData.placa);
        $("#idInputAnioVehiculo").val(rowData.anio);
        $("#idInputModeloVehiculo").val(rowData.modelo);
        $("#idInputMarcaVehiculo").val(rowData.idMarcaVehiculo);
        $("#idInputMarcaGpsVehiculo").val(rowData.gps);
        $("#idInputImeiGpsVehiculo").val(rowData.imei);
        // $('html, body').animate({ scrollTop: 0 }, 'slow');
        // console.log(data);
        // maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 2 });
        // $("#idModalNuevoPago").addClass("md-show");
        // $("#idSelectTipoPagoModalNuevoPago").val(data.idTipoPago);
        // $("#idInputMontoPago").val(data.montoPago);

        // $("#idInputFechaPago").val(data.fechaPago);
        // $("#idTextObservacion").val(data.observacion);
        // $("#output").attr("src", '../../' + data.archivo);
        // $("#idBtnEditarPago").removeClass("d-none");
        // $("#idBtnGuardarNuevoPago").addClass("d-none");
        // $("#idInputIdPago").val(data.idPago);
        // $("#idTituloAccionModal").text("Editar Pago");


    });

    $('#idListadoVehiculo tbody').on('click', '#idBtnDeshabilitarVehiculo', function () {
        var data = table.row($(this).parents('tr')).data();
        var rowData = null;
        if (data == undefined) {
            var selected_row = $(this).parents('tr');
            if (selected_row.hasClass('child')) {
                selected_row = selected_row.prev();
            }
            rowData = $('#idListadoVehiculo').DataTable().row(selected_row).data();
        } else {
            rowData = data;
        }

        //console.log(rowData);
        var sendData = {
            "idVehiculo":rowData.idVehiculo,
            "estado":rowData.estado
        }
        swal({
            title: "Estas seguro?",
            text: "Los dato seran enviados para deshabilitar este Vehículo!",
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
                        type: "GET",
                        url: '/gps/src/private/VehiculoDeshabilitar.php',
                        data: sendData,
                        success: function (response) {
                            var jsonData = JSON.parse(response);
                           // console.log(jsonData);
                            if (jsonData.error == false) {
                                swal("Deshabilitado", jsonData.mensaje, "success");                               
                                fncRenderizarDataTable();
                               
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
    });


}


$("#idBtnModalCrearNuevoVehiculo").click(function (e) {
    maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 2 });
    $("#idModalListadoVehiculo").addClass("md-show");
    $("#idInputPlacaVehiculo").attr("readonly", false);
    $("#idBtnAgregarNuevoVehiculo").html("Agregar Vehículo");
    $("#idInputIdVehiculo").val("0");
});

$(".md-close").click(function (e) {

    maskOff(document.getElementsByClassName("main-body"));
    $("#idBtnAgregarNuevoVehiculo").html("Agregar Vehículo");
    var modal = document.getElementById("idModalListadoVehiculo");
    classie.remove(modal, 'md-show')
    $("#idFormVehiculo").validate().resetForm();
    $("#idInputPlacaVehiculo").val('');
    $("#idInputAnioVehiculo").val('');
    $("#idInputModeloVehiculo").val('');
    $("#idInputMarcaGpsVehiculo").val('');
    $("#idInputImeiGpsVehiculo").val('');

    $("#idInputPlacaVehiculo").attr("readonly", false);

});


function fncListarMarcasVehiculos() {
    $.ajax({
        type: "GET",
        url: "/gps/src/private/MarcaVehiculoListar.php",
        data: "data",
        success: function (response) {

            var jsonData = JSON.parse(response);
            for (let index = 0; index < jsonData.data.length; index++) {
                $('#idInputMarcaVehiculo').append($('<option>', {
                    value: jsonData.data[index].idMarcaVehiculo,
                    text: jsonData.data[index].marca
                }));
            }
            $.duplicate();

        }
    });


}
$('#idFormVehiculo').validate({
    rules: {
        idInputPlacaVehiculo: {
            required: true,
            minlength: 7,
        },
        idInputAnioVehiculo: {
            required: true,
            min: 1950,
        },
        idInputModeloVehiculo: {
            required: true,
        },
        idInputMarcaGpsVehiculo: {
            required: true,
        },
        idInputImeiGpsVehiculo: {
            required: true,
            digits: true,
        },
    },
    submitHandler: function (form) {
        var placa = $('#idInputPlacaVehiculo').val();
        var anio = $('#idInputAnioVehiculo').val();
        var idMarcaVehiculo = $('#idInputMarcaVehiculo').val();
        var modelo = $('#idInputModeloVehiculo').val();
        var gps = $('#idInputMarcaGpsVehiculo').val();
        var imei = $('#idInputImeiGpsVehiculo').val();
        var idVehiculo = $('#idInputIdVehiculo').val();


        var tipoPersona = 'personaJuridica';
        var formData = new FormData();

        var data = {
            'placa': placa,
            'anio': anio,
            'idMarcaVehiculo': idMarcaVehiculo,
            'modelo': modelo,
            'gps': gps,
            'imei': imei,
        }
        if (parseInt(idVehiculo) != 0) {
            data["idVehiculo"] = idVehiculo;
        }

        fncGuardarVehiculo(data);
        return false;
        // if (formularioValido == true) {
        //     fncGuardarDatosCliente(formData);
        //     return false;

        // } else {
        //     notificacion('Datos faltantes : ', campos[0], 'warning');
        // }
    }
});

function fncGuardarVehiculo(data) {

    swal({
        title: "Estas seguro?",
        text: "Los dato seran enviados para registro de un Vehículo!",
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
                    url: '/gps/src/private/VehiculoGuardar.php',
                    data: data,
                    success: function (response) {
                        var jsonData = JSON.parse(response);
                        console.log(jsonData);
                        if (jsonData.error == false) {
                            swal("Registrado", jsonData.mensaje, "success");
                            $('#modalLargeNuevoCliente').modal('hide');
                            fncRenderizarDataTable();
                            maskOff(document.getElementsByClassName("main-body"));
                            var modal = document.getElementById("idModalListadoVehiculo");
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

