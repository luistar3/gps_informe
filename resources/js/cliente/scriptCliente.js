
$(document).ready(function () {
    $('#idBtnAgregarCliente').on('click', (e) => {
        e.preventDefault();
       // $('#idFormNuevoCliente').submit();
        return false;
    })
    fncRenderizarDataTable();
    fncListarPersonaNatural();
    fncListarPersonaJuridica();
});



function fncRenderizarDataTable() {

    var table = $('#idListadoCliente').DataTable();
    table.clear();
    table.destroy();
    var table = $('#idListadoCliente').DataTable({
        'destroy': true,
        "ajax": {
            type: "GET",
            "url": "/gps/src/private/ClienteListar.php"
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

        /*    <th>N° Documento</th>
                                                <th>Nombre Cliente</th>
                                                <th>Tipo Cliente</th>
                                                <th>Ultimo Pago</th>
                                                <th>Correo</th>
                                                <th>Creado</th>
                                                <th>Actualizado</th>
                                                <th>Accciones</th> */

        "columns": [
            { "defaultContent": '' },
            {
                "data": "documentoCliente",

                createdCell: function (td, cellData, rowData, row, col) {
                    var color = (rowData.tipoCliente == 'NATURAL') ? '#636363' : '#ff5757';
                    $(td).css('border', color + ' solid 3px');
                }
            },
            {
                "data": "nombreCliente"
            },
            { "data": "tipoCliente" },
            { "data": "ultimoPago" },
            { "data": "correo" },
            { "data": "updatedAt" },
            { "data": "createdAt" },
            {
                "data": "idCliente",
                render: function (data, type, row) {
                    var btn = '<a  class="btn" href="/gps/src/private/views/persona/naturalJuridicaView.php" >Editar</a>';                   
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
            this.api().columns("2,3").every(function () {
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
    $('#idListadoCliente tbody').off('click');
    table.on('order.dt search.dt', function () { //numeracion para la tabla
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $('#idListadoCliente tbody').on('click', '#idBtnEditarVehiculo', function () {

        var data = table.row($(this).parents('tr')).data();
        var rowData = null;
        if (data == undefined) {
            var selected_row = $(this).parents('tr');
            if (selected_row.hasClass('child')) {
                selected_row = selected_row.prev();
            }
            rowData = $('#idListadoCliente').DataTable().row(selected_row).data();
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

    $('#idListadoCliente tbody').on('click', '#idBtnDeshabilitarVehiculo', function () {
        var data = table.row($(this).parents('tr')).data();
        var rowData = null;
        if (data == undefined) {
            var selected_row = $(this).parents('tr');
            if (selected_row.hasClass('child')) {
                selected_row = selected_row.prev();
            }
            rowData = $('#idListadoCliente').DataTable().row(selected_row).data();
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
                                var modal = document.getElementById("idModalGuardarEditar");
                                classie.remove(modal, 'md-show');
                                maskOff(document.getElementsByClassName("main-body"));
                               
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

$("#idModalMostrarGuardarEditar").click(function (e) {
    maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 2 });
    $("#idModalGuardarEditar").addClass("md-show");
    //$("#idInputPlacaVehiculo").attr("readonly", false);
    $("#idBtnAgregarEditarPersona").html("Agregar Persona");
    $("#idInputIdPersona").val('0');
});


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
    var modal = document.getElementById("idModalGuardarEditar");
    classie.remove(modal, 'md-show')
    $("#idFormNuevoCliente").validate().resetForm();
    $("#idInputPlacaVehiculo").val('');
    $("#idInputAnioVehiculo").val('');
    $("#idInputModeloVehiculo").val('');
    $("#idInputMarcaGpsVehiculo").val('');
    $("#idInputImeiGpsVehiculo").val('');

    $("#idInputPlacaVehiculo").attr("readonly", false);

    $("#idDivPersonaJuridica").addClass("d-none");
    $("#idDivPersonaNatural").removeClass("d-none");
    $("#idRadioNatural").prop("checked", true);
    $("#idRadioJuridico").prop("checked", false);

});



function fncListarPersonaNatural() {
    $.ajax({
        type: "GET",
        url: "/gps/src/private/PersonaNaturalListarParaCliente.php",
        data: "data",
        success: function (response) {

            var jsonData = JSON.parse(response);
          /*  $('#idInputIdPersonaNatural').append($('<option>', {
                value: '',
                text: 'Seleccione persona natural'
            }));*/
            for (let index = 0; index < jsonData.data.length; index++) {
                $('#idInputIdPersonaNatural').append($('<option>', {
                    value: jsonData.data[index].idPersona,
                    text: '[ '+jsonData.data[index].dni+' ] '+ jsonData.data[index].nombres+' '+jsonData.data[index].apellidos
                }));
            }
            $.duplicate();

        }
    });

    $("#idInputIdPersonaJuridica").select2({
        dropdownParent: $("#idModalGuardarEditar")
    });
    
}
function fncListarPersonaJuridica() {
    $.ajax({
        type: "GET",
        url: "/gps/src/private/PersonaJuridicaListarParaCliente.php",
        data: "data",
        success: function (response) {

            var jsonData = JSON.parse(response);
          /*  $('#idInputIdPersonaJuridica').append($('<option>', {
                value: '',
                text: 'Seleccione persona jurídica'
            }));*/
            for (let index = 0; index < jsonData.data.length; index++) {
                $('#idInputIdPersonaJuridica').append($('<option>', {
                    value: jsonData.data[index].idJuridico,
                    text: '[ '+jsonData.data[index].ruc+' ] '+ jsonData.data[index].razonSocial
                }));
            }
            $.duplicate();

        }
    });
    $("#idInputIdPersonaNatural").select2({
        dropdownParent: $("#idModalGuardarEditar")
    });
    
}

$("#idRadioNatural").click(function (e) { 
    $("#idDivPersonaJuridica").addClass("d-none");
    $("#idDivPersonaNatural").removeClass("d-none");
});


$("#idRadioJuridica").click(function (e) { 
    $("#idDivPersonaJuridica").removeClass("d-none");
    $("#idDivPersonaNatural").addClass("d-none");
});


$("#idBtnAgregarCliente").click(function (e) { 
  
    var idPersonaJuridica = '';
    var idPersonaNatural = '';
var data = {};
   var tipoPersona =  $('[name=tipoPersona]:checked').val();
    if (tipoPersona == "juridica") {
        idPersonaJuridica = $("#idInputIdPersonaJuridica").val();
        var data = {
            "idJuridico":idPersonaJuridica,
            "tipoPersona":tipoPersona
        }
    }else{
        idPersonaNatural = $("#idInputIdPersonaNatural").val();
        var data = {
            "idPersona":idPersonaNatural,
            "tipoPersona":tipoPersona
        }
    }
    
    swal({
        title: "Estas seguro?",
        text: "Los dato seran enviados para Agregar un Nuevo Cliente!",
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
                    url: '/gps/src/private/ClienteGuardarSolo.php',
                    data: data,
                    success: function (response) {
                        var jsonData = JSON.parse(response);
                       // console.log(jsonData);
                        if (jsonData.error == false) {
                            swal("Agregado", jsonData.mensaje, "success");                               
                            fncRenderizarDataTable();
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
    
});

