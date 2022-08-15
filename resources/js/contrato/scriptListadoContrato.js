$(document).ready(function () {
    var tablaListadoContratos = document.getElementById("idListadoContratos");
    function setDateFilters() {
        $('#idContratoFechaInicioHasta').val(moment().format('YYYY-MM-DD'));
        $('#idContratoFechaInicioDesde').val(moment().subtract(5, 'YEAR').format('YYYY-MM-DD'));   
        
        var desde  = $("#idContratoFechaInicioHasta").val();
        var hasta  = $("#idContratoFechaInicioDesde").val();
        if (desde!='' && hasta!='') {
            return true;
        } else{
            return false;
        }
    }
    $.when(setDateFilters()).then(fncRenderDatatableListadoContrato());
});

$("#idContratoVehiculoPagosBuscar").click(function (e) { 
    
    
    fncRenderDatatableListadoContrato();
});
function fncGetDataFilter() {

    
    var contratoVehiculo = 0;
    var idContratoEstado = $("#idContratoEstado").val();
    var idContratoFechaInicioDesde = $("#idContratoFechaInicioDesde").val();
    var idContratoFechaInicioHasta = $("#idContratoFechaInicioHasta").val();
  
    var data = {
        "contratoEstado": idContratoEstado,
        "contratoFechaInicioDesde": idContratoFechaInicioDesde,
        "contratoFechaInicioHasta": idContratoFechaInicioHasta
    }
    return data;

}
function fncRenderDatatableListadoContrato(data) {

    
    var table = $('#idListadoContratos').DataTable();
    table.clear();
    table.destroy();
    var table = $('#idListadoContratos').DataTable({
        'destroy': true,

        "ajax": {
            type: "GET",
            "url": "/gps/src/private/ContratoListar.php",
            "data": fncGetDataFilter(),
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
        "pageLength": 10,
        "processing": true, // Si se muestra el estado de procesamiento (al ordenar, una gran cantidad de datos lleva mucho tiempo, esto también se mostrará)
        "data": data,
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'asc' ]],
        "language": {
            url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json'
        },
        "columns": [
            { "defaultContent": '' },
            { "data": "nombre",
            render: function (data, type,row) {
              
                return(data+'<a href="#" type="button" class="text-dark" data-modal="idModalListadoVehiculoContrato" onclick="fncListarVehiculosContrato('+row.idContrato+',\''+row.nombre+'\')">&nbsp;&nbsp;&nbsp;(+)</a>');

            },
            createdCell: function(td, cellData, rowData, row, col){
                var color = (rowData.tipoCliente === 'juridica') ? '#C0657A' : '#84B1F2';
               
                $(td).css('background', color);
                $(td).css('color', '#fff');
                
              } },
            { "data": "mensualidad",
            render: function (data, type) {
                
                return 'S/.'+data;

            } },
            { "data": "fechaInicio" },
            { "data": "fechaFin",
            render: function (data, type) {
                
                var hoy = moment(moment().format('YYYY-MM-DD'), 'YYYY-MM-DD', 'fr', true).valueOf();
                var finContrato = moment(data, 'YYYY-MM-DD', 'fr', true).valueOf();
               
                if (finContrato<hoy) {

                    return data+' <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><style>@keyframes n-info-tri{0%,to{transform:rotate(0deg);transform-origin:center}10%,90%{transform:rotate(2deg)}20%,40%,60%{transform:rotate(-6deg)}30%,50%,70%{transform:rotate(6deg)}80%{transform:rotate(-2deg)}}.prefix__n-info-tri{animation:n-info-tri .8s cubic-bezier(.455,.03,.515,.955) both infinite}</style><path class="prefix__n-info-tri" style="animation-delay:1s" stroke="#0A0A30" stroke-width="1.5" d="M11.134 6.844a1 1 0 011.732 0l5.954 10.312a1 1 0 01-.866 1.5H6.046a1 1 0 01-.866-1.5l5.954-10.312z"/><g class="prefix__n-info-tri"><path stroke="#265BFF" stroke-linecap="round" stroke-width="1.5" d="M12 10.284v3.206"/><circle cx="12" cy="15.605" r=".832" fill="#265BFF"/></g></svg>';    
                }
                return data;
                

            } },
            { "data": "createdAt" },
            {
                "data": "contrato",
                render: function (data, type) {
                    
                    if (data == null || data == '') {
                        return 'Contrato no cargado <i class="ti-close"></i>';
                    } else {
                        return '<button class="btn btn-mini btn-inverse btn-outline-inverse btn-pdf-descargar">Ver / Descargar PDF <i class="ti-cloud-down"></i></button>'                       
                        
                    }

                },
                createdCell: function(td, cellData, rowData, row, col){
                    var color = (cellData === null) ? '#636363' : '#ff5757';
                    $(td).css('border', color+' solid 3px');
                  }
            },
            {
                "defaultContent": "",
                render: function (data, type, row) {
                    return '<button id="idBtnEditarIdPago" class="btn btn-mini btn-warning btn-round">Editar Contrato</button>';
                }
            }

        ],
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
    $('#idListadoContratos tbody').off('click');
    table.on('order.dt search.dt', function () { //numeracion para la tabla
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
    $('#idListadoContratos tbody').on('click', 'tr', function () { //seleccionar fila
        //$(this).toggleClass('selected');
    });
    $('#button').click(function () { //click event filas seleccionadas

        table.rows('.selected').data().map((row) => {
            console.log(row);
        });
    });
    $('#idListadoContratos tbody').on('click', '#idBtnEditarIdPago', function () {

        var data = table.row($(this).parents('tr')).data();
        // $('html, body').animate({ scrollTop: 0 }, 'slow');
        console.log(data);
        var contrato= {
            "idContrato": data.idContrato,
            "idCliente":data.idCliente
        }
        
        url ="/gps/src/private/views/contrato/editarContratosView.php";
        redireccionarPost(url,contrato);


    });
    

}

function fncListarVehiculosContrato(idContrato,nombre) {
    var modal = document.getElementById("idModalListadoVehiculoContrato");    
    
    $("#modalNombreCliente").text(nombre);
    var data = {
        "idContrato":idContrato
    }
    $.ajax({
        type: "GET",
        data: data,
        url: "/gps/src/private/ContratoListarVehiculo.php",
        success: function (response) {
            $("#idModalListadoContrato tbody").html('');
            var result = JSON.parse(response)
            var newRow = '';
            $.each(result.data, function (indexInArray, valueOfElement) { 
                 newRow += '<tr>';
                 newRow += '<th scope="row">'+(indexInArray+1)+'</th><td>'+valueOfElement.placa+'</td><td>'+valueOfElement.montoPago+'</td><td>'+valueOfElement.ultimoPago+'</td>';
                 newRow += '<td>'+valueOfElement.fechaInstalacion+'</td><td>'+valueOfElement.fechaTermino+'</td><td>'+valueOfElement.imei+'</td>';
                 newRow += '<td>'+'<button onClick="fncDetalleContratoVehiculo('+valueOfElement.idContratoVehiculo+','+idContrato+','+valueOfElement.idVehiculo+',\''+valueOfElement.placa+'\')" class="btn btn-primary btn-outline-primary btn-icon"><i class="icofont icofont-money-bag"></i></button>'+'</td>';
                 newRow += '</tr>';
            });

            $("#idModalListadoContrato tbody").append(newRow);
           
            
        },
        complete : function(xhr, status) {
            classie.add( modal, 'md-show' );
        }
    });
}
function fncDetalleContratoVehiculo(idContratoVehiculo,idContrato,idVehiculo,placa) { 

    data = {
    "idContratoVehiculo":idContratoVehiculo,   
    "idContrato":idContrato,    
    "idVehiculo":idVehiculo,   
    "placaVehiculo":placa
    }
    url ="/gps/src/private/views/contratoVehiculo/contratoVehiculoDetalleView.php";
    redireccionarPost(url,data);

 }
 
function redireccionarPost(url, data) {
    var form = document.createElement('form');
    document.body.appendChild(form);
    form.target = '_blank';
    form.method = 'post';
    form.action = url;
    for (var name in data) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = data[name];
        form.appendChild(input);
    }
    form.submit();
    document.body.removeChild(form);
}

/*
*************************************************************************
esconder modales
*************************************************************************
*/



$(".md-close").click(function (e) { 
    var modal = document.getElementById("idModalListadoVehiculoContrato");
    classie.remove( modal, 'md-show' )
    
});

