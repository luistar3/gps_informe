$(document).ready(function () {
    fncSetDateInputFilter();
    fncObtenerTipoPagos();
    var elemdefault = document.querySelector('#idContratoVehiculoNombreContratoCheckbox');
    var switchery = new Switchery(elemdefault, { color: '#bdc3c7', jackColor: '#fff', jackColor: '#2ecc71', size: 'small' });
    fncObtenerContrato();

    $("#idTextPlacaVehiculo").val("PLACA : " + placaSeleccionada.toUpperCase());

    $('#idBtnGuardarNuevoPago').on('click', (e) => {
        e.preventDefault();
        $('#idFormNuevoPagoVehiculo').submit();

        return false;
    });
    $('#idBtnEditarPago').on('click', (e) => {
        e.preventDefault();
        $('#idFormNuevoPagoVehiculo').submit();

        return false;
    });

    fncRenderizarDataTable();
    fncListarPagosAnios();
});

console.log(idContrato);
function fncSetDateInputFilter() {
    var formatoFecha = moment().subtract(2, 'YEAR').format('YYYY-MM-DD');
    $('#idContratoVehiculoFechaInicio').val(formatoFecha);
    $('#idInputFechaPago').val(moment().format('YYYY-MM-DD'));


    var formatoFecha = moment().format('YYYY-MM-DD');
    var formatoFechaAnio = moment().format('YYYY');
    var formatoFechaAnioPasado = moment().subtract(1, 'year').format('YYYY');
    $('#idContratoVehiculoFechaFin').val(formatoFecha);
    $('#idTitleAnioActual').html(formatoFechaAnio);
    $('#idTitleAnioPasado').html(formatoFechaAnioPasado);

}
function fncObtenerTipoPagos() {
    // var fechaInicio =  new Date ($("#idContratoVehiculoFechaInicio").val());
    // var fechaFin = new Date( $("#idContratoVehiculoFechaFin").val());
    // if (fechaInicio<fechaFin) {
    //     $.ajax({
    //         type: "GET",
    //         url: "/gps/src/private/ContratoListar.php",
    //         data: "data",
    //         success: function (response) {

    //         }
    //     });
    // }
    $.ajax({
        type: "GET",
        url: "/gps/src/private/TipoPagoListar.php",
        data: "data",
        success: function (response) {
            var select = $("#idContratoVehiculoTipoPago");
            var selectNuevoPago = $("#idSelectTipoPagoModalNuevoPago");
            var result = JSON.parse(response);
            $.each(result.data, function (indexInArray, valueOfElement) {
                var option = '<option value="' + valueOfElement.idTipoPago + '">' + valueOfElement.tipoPago + '</option>';
                select.append(option);
                selectNuevoPago.append(option);
            });
        }
    });
}

function fncObtenerContrato() {
    data = {
        'id': idContrato
    }
    $.ajax({
        type: "GET",
        url: "/gps/src/private/ContratoObtener.php",
        data: data,
        success: function (response) {
            var result = JSON.parse(response);
            $("#idContratoVehiculoNombreContrato").html(result.data.nombre);

        }
    });
}
function fncListarPagoVehiculo() {

    var contratoActivo = document.querySelector('#idContratoVehiculoNombreContratoCheckbox');
    var contratoVehiculo = 0;
    var fechaInicio = $("#idContratoVehiculoFechaInicio").val();
    var fechaFin = $("#idContratoVehiculoFechaFin").val();
    var tipoPago = $("#idContratoVehiculoTipoPago").val();
    if (contratoActivo.checked) {
        console.log("si esta marcado");
        console.log(idContratoVehiculo);
        var contratoVehiculo = idContratoVehiculo;
    }
    var data = {
        "idContratoVehiculoFechaInicio": fechaInicio,
        "idContratoVehiculoFechaFin": fechaFin,
        "idContratoVehiculoTipoPago": tipoPago,
        "idContratoVehiculo": contratoVehiculo,
        "idVehiculo": idVehiculo
    }
    return data;

}

$("#idContratoVehiculoPagosBuscar").click(function (e) {

    // $('#idListadoPagoVehiculo').DataTable().ajax.reload();
    //fncListarPagoVehiculo(); 

    HoldOn.open();


    fncRenderizarDataTable();
    HoldOn.close();
});

function fncRenderizarDataTable() {

    var table = $('#idListadoPagoVehiculo').DataTable();
    table.clear();
    table.destroy();
    var table = $('#idListadoPagoVehiculo').DataTable({
        'destroy': true,
        "processing": true,
        "ajax": {
            type: "GET",
            "url": "/gps/src/private/PagoVehiculoListar.php",
            "data": fncListarPagoVehiculo(),
            beforeSend: function () {
                HoldOn.open();
              },
              complete: function () {
                HoldOn.close();
              }
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
                "data": "tipoPago",
                render: function (data, type, row) {
                    return '<span title="' + row.nombreCliente + '">' + data + '</span>';
                },
                createdCell: function (td, cellData, rowData, row, col) {
                    var color = '';

                    if (rowData.idTipoPago === '1') {
                        color = '#FFFACD';
                    } else if (rowData.idTipoPago === '2') {
                        color = '#B0E0E6	';
                    }
                    else if (rowData.idTipoPago === '3') {
                        color = '#DCDCDC';
                    }
                    else if (rowData.idTipoPago === '4') {
                        color = '#FFFFE0';
                    }

                    $(td).css('background', color);


                }
            },
            {
                "data": "montoPago"
            },
            { "data": "fechaPago" },
            { "data": "createdAt" },
            { "data": "observacion" },
            {
                "data": "idPago",
                render: function (data, type, row) {
                    return '<button id="idBtnEditarIdPago" class="btn btn-mini btn-warning btn-round">Editar</button>' + '<button id="idBtnEliminarPago" class="btn btn-mini btn-danger btn-round">Eliminar</button>'
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
            total = api
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $("#idSumaTotalPagoVehiculo").val("S/. " + total);
        },
        initComplete: function () { //opcion de busqueda parte inferior
            this.api().columns("1,2,3").every(function () {
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
    $('#idListadoPagoVehiculo tbody').off('click');
    table.on('order.dt search.dt', function () { //numeracion para la tabla
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $('#idListadoPagoVehiculo tbody').on('click', '#idBtnEditarIdPago', function () {

        var data = table.row($(this).parents('tr')).data();
        // $('html, body').animate({ scrollTop: 0 }, 'slow');
        console.log(data);
        maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 2 });
        $("#idModalNuevoPago").addClass("md-show");
        $("#idSelectTipoPagoModalNuevoPago").val(data.idTipoPago);
        $("#idInputMontoPago").val(data.montoPago);

        $("#idInputFechaPago").val(data.fechaPago);
        $("#idTextObservacion").val(data.observacion);
        $("#output").attr("src", '../../' + data.archivo);
        $("#idBtnEditarPago").removeClass("d-none");
        $("#idBtnGuardarNuevoPago").addClass("d-none");
        $("#idInputIdPago").val(data.idPago);
        $("#idTituloAccionModal").text("Editar Pago");


    });

    $('#idListadoPagoVehiculo tbody').on('click', '#idBtnEliminarPago', function () {
        var data = table.row($(this).parents('tr')).data();
        var datos = {
            "idPago":data.idPago
        }
      
        fncEliminarPagoCliente(datos);
    });


}

$(".btn-cerrar-modal").click(function (e) {
    $("#idInputIdPago").val('0');
    $("#idInputFile").val('');
    $('#output').attr('src', '');
    $('#output').attr('alt', 'Please Select Image');
    $("#idTextObservacion").val('');
    $("#idInputMontoPago").val('');
    maskOff(document.getElementsByClassName("main-body"));
    $("#idBtnEditarPago").addClass("d-none");
    $("#idBtnGuardarNuevoPago").removeClass("d-none");

});


$('#idFormNuevoPagoVehiculo').validate({

    submitHandler: function (form) {
        var formData = fncGetDataInsertUpdate();
        console.log(formData);
        if (parseInt(formData.get("idPago")) == 0) {
            fncGuardarNuevoPagoCliente(formData);
        } else {
            fncEditarPagoCliente(formData);
        }
        return false;
    }
});


function fncEliminarPagoCliente(data) {


    swal({
        title: "Estas seguro?",
        text: "Los dato seran Eliminados!",
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
                    data:data,
                    url: '/gps/src/private/PagoEliminar.php',
                    
                    success: function (response) {
                        var jsonData = JSON.parse(response);
                        if (jsonData.error == false) {
                            swal("Registrado", jsonData.mensaje, "success");
                            fncRenderizarDataTable();
                            fncListarPagosAnios();
                            
                        }                       
                        
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        var jsonData = JSON.parse(XMLHttpRequest.responseText);
                        swal("Error", jsonData.mensaje, "error");
                    },beforeSend: function () {
                        HoldOn.open();
                      },
                      complete: function () {
                        HoldOn.close();
                      }
                });

            } else {
                swal("Cancelado", "Los datos no se enviaron", "error");
            }
        });
}

function fncGuardarNuevoPagoCliente(data) {


    swal({
        title: "Estas seguro?",
        text: "Los dato seran enviados para registro de un nuevo Pago!",
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
                    url: '/gps/src/private/PagoGuardar.php',
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function (response) {
                        var jsonData = JSON.parse(response);
                        if (jsonData.error == false) {
                            swal("Registrado", jsonData.mensaje, "success");
                            $('.btn-cerrar-modal').trigger('click');
                        } else {
                            swal("Error", jsonData.mensaje, "error");
                        }
                        fncRenderizarDataTable();
                        fncListarPagosAnios();
                    }
                });

            } else {
                swal("Cancelado", "Los datos no se enviaron", "error");
            }
        });
}

function fncEditarPagoCliente(data) {

    swal({
        title: "Estas seguro?",
        text: "Los datos seran enviados para edicion del Pago!",
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
                    url: '/gps/src/private/PagoGuardar.php',
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function (response) {
                        var jsonData = JSON.parse(response);
                        if (jsonData.error == false) {
                            swal("Registrado", jsonData.mensaje, "success");
                            $('.btn-cerrar-modal').trigger('click');
                        }
                        fncRenderizarDataTable();
                        fncListarPagosAnios();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        var jsonData = JSON.parse(XMLHttpRequest.responseText);
                        swal("Error", jsonData.mensaje, "error");
                    },beforeSend: function () {
                        HoldOn.open();
                      },
                      complete: function () {
                        HoldOn.close();
                      }
                });

            } else {
                swal("Cancelado", "Los datos no se enviaron", "error");
            }
        });
}

$("#idModalNuevoPagoVehiculo").click(function (e) {
    console.log("nueov pago");
    maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 3 });
    $("#idBtnEditarPago").addClass("d-none");
    $("#idBtnGuardarNuevoPago").removeClass("d-none");
    $("#idTituloAccionModal").text("Nuevo Pago");

});
var cargarImagen = function (event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function () {
        URL.revokeObjectURL(output.src) // free memory
    }
};

function fncGetDataInsertUpdate() {
    var formData = new FormData();
    formData.append('archivo', $('#idInputFile')[0].files[0]);
    formData.append('idContratoVehiculo', idContratoVehiculo);
    formData.append('montoPago', $("#idInputMontoPago").val());
    formData.append('idTipoPago', $("#idSelectTipoPagoModalNuevoPago").val());
    formData.append('observacion', $("#idTextObservacion").val());
    formData.append('fechaPago', $("#idInputFechaPago").val());
    formData.append('idPago', $("#idInputIdPago").val());
    return formData;
}

function fncListarPagosAnios() {
    var data ={
        "idContratoVehiculo": idContratoVehiculo
    }

    $.ajax({
        type: "GET",
        data:data,
        url: "/gps/src/private/PagoVehiculoListarAnio.php",       
        success: function (response) {
            var jsonData = JSON.parse(response);
            var data = jsonData.data;
            fncLlenarListaMeses(data);
        }
    });
}

var meses = [{ 'mes': "Diciembre", 'num': '12' },
{ 'mes': "Noviembre", 'num': '11' },
{ 'mes': "Octubre", 'num': '10' },
{ 'mes': "Septiembre", 'num': '9' },
{ 'mes': "Agosto", 'num': '8' },
{ 'mes': "Julio", 'num': '7' },
{ 'mes': "Junio", 'num': '6' },
{ 'mes': "Mayo", 'num': '5' },
{ 'mes': "Abril", 'num': '4' },
{ 'mes': "Marzo", 'num': '3' },
{ 'mes': "Febrero", 'num': '2' },
{ 'mes': "Enero", 'num': '1' }];

function fncLlenarListaMeses(data) {
    $("#idUlMesesActual").empty();
    $("#idUlMesesPasado").empty();

    var formatoFechaAnio = moment().format('YYYY');
    var formatoFechaAnioPasado = moment().subtract(1, 'year').format('YYYY');

    meses.map((meses, index, array) => {
        //console.log(index);
        $("#idDivMesesActual ul").append('<li id="' + formatoFechaAnio + '_' + meses.num + '"><a href="#">' + meses.mes + '</a></li>');
        $("#idDivMesesPasado ul").append('<li id="' + formatoFechaAnioPasado + '_' + meses.num + '"><a href="#">' + meses.mes + '</a></li>');
    });
    try {
        data.map((data, index, array) => {
            var id = '#' + data.anio + '_' + data.mes + '';
            // console.log(id);
            $(id).addClass("active");
            $(id).append(' <label class="label label-inverse-info-border">Suma de Pagos = S/.' + data.sumaPago + '<i class="icofont icofont-bubble-right"></i>  Cantidad de Pagos= ' + data.cantidadMes + '</label>');
        });
    } catch (error) {
        console.log(error);
    }
}

