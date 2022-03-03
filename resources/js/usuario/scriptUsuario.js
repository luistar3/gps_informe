$(document).ready(function () {
    $('#idBtnAgregarEditarUsuario').on('click', (e) => {
        e.preventDefault();
        $('#idFormNuevoUsuario').submit();
        return false;
    });
    fncRenderizarDataTable();
    $("#idModalGuardarEditar").click(function (e) {
        maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 2 });
        $("#idModalMostrarGuardarEditar").addClass("md-show");
        //$("#idInputPlacaVehiculo").attr("readonly", false);
        $("#idBtnAgregarCliente").html("Agregar Usuario");
        $("#idInputIdUsuario").val('0');
        fncListarUsuarios();
    });

    $(".md-close").click(function (e) {
        /* PERSONA NATURAL */
        maskOff(document.getElementsByClassName("main-body"));
        $("#idBtnAgregarEditarPersona").html("Agregar Persona");
        var modal = document.getElementById("idModalMostrarGuardarEditar");
        classie.remove(modal, 'md-show')
        $("#idFormNuevoUsuario").validate().resetForm();
        $("#idUsuario").val('');
        $("#idContrasena").val('');
        $("#idInputIdUsuario").val('0');
        $("#idUsuario").attr("readonly", false);
    });

    fncListarUsuarios();
    fncListarRoles();
    
});



function fncRenderizarDataTable() {

    var table = $('#idListadoUsuarios').DataTable();
    table.clear();
    table.destroy();
    var table = $('#idListadoUsuarios').DataTable({
        'destroy': true,
        "ajax": {
            type: "GET",
            "url": "/gps/src/private/UsuarioListarAll.php",
            cache: true

        },
        "dataSrc": function (json) {
            console.log(json);
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
                "data": "personaNatural.dni"
            },
            {
                "data": "personaNatural.nombres"
            },
            { "data": "personaNatural.apellidos" },
            { "data": "usuario" },
            { "data": "personaNatural.correo" },
            { "data": "rol.nombre" },
            { "data": "estado" ,
                render: function (data,type,row) {
                    switch(parseInt(data)) {
                        case 1:
                          return 'Habilitado'
                          break;
                        default:
                          return 'Deshabilitado'
                      }
                }
            },
            {
                "defaultContent": '',
                render: function (data, type, row) {
                    var btn = '<button id="idBtnEditarUsuario" class="btn btn-mini btn-warning btn-round">Editar</button>';

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
    $('#idListadoUsuarios tbody').off('click');
    table.on('order.dt search.dt', function () { //numeracion para la tabla
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $('#idListadoUsuarios tbody').on('click', '#idBtnEditarUsuario', function () {

        var data = table.row($(this).parents('tr')).data();
        var rowData = null;
        if (data == undefined) {
            var selected_row = $(this).parents('tr');
            if (selected_row.hasClass('child')) {
                selected_row = selected_row.prev();
            }
            rowData = $('#idListadoUsuarios').DataTable().row(selected_row).data();
        } else {
            rowData = data;

        }
        idInputIdPersonaNatural
        $("#idUsuario").attr("readonly", true);
        $("#idBtnAgregarEditarUsuario").html("Editar Usuario");
        $("#idModalMostrarGuardarEditar").addClass("md-show");
        maskOn(document.getElementsByClassName("main-body"), { color: '#48c9b059', hourglass: true, zIndex: 2 });
        
        $("#idInputIdUsuario").val(rowData.idUsuario);
        $("#idUsuario").val(rowData.usuario);
        $("#idEstadoUsuario").val(rowData.estado);
        $("#idInputISelectRol").val(rowData.rol.idRol);
        $("#idInputDireccion").val(rowData.direccion);
        $("#idInputCorreo").val(rowData.correo);
        $("#idInputTelefono").val(rowData.telefono);
        $("#idInputIdPersona").val(rowData.idPersona);


    });

}


function fncListarUsuarios() {
    $("#idInputIdPersonaNatural").empty();
    $.ajax({
        type: "GET",
        url: "/gps/src/private/PersonaNaturalListarAgregarUsuario.php",
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

    $("#idInputIdPersonaNatural").select2({
        dropdownParent: $("#idModalMostrarGuardarEditar")
    });
    
}
function fncListarRoles() {
    $.ajax({
        type: "GET",
        url: "/gps/src/private/RolListar.php",
        data: "data",
        success: function (response) {

            var jsonData = JSON.parse(response);
          /*  $('#idInputIdPersonaNatural').append($('<option>', {
                value: '',
                text: 'Seleccione persona natural'
            }));*/
            for (let index = 0; index < jsonData.data.length; index++) {
                $('#idInputISelectRol').append($('<option>', {
                    value: jsonData.data[index].idRol,
                    text: '[ '+jsonData.data[index].idRol+' ] '+ ''+' '+jsonData.data[index].nombre
                }));
            }
            $.duplicate();

        }
    });
    
}


$('#idFormNuevoUsuario').validate({
    rules: {
        idUsuario: {
            required: true,
            minlength: 4,
        },
        idContrasena: {
            required: function () {
                var min = parseInt( $('#idInputIdUsuario').val());
                console.log(min);
                if (min==0) {
                    return true;
                }else{
                    return false
                }
            },
            minlength: function () {
                var min = $('#idContrasena').val().length;
                console.log(min);
                if (min>0) {
                    return 8;
                }
            },
        },
        
    },
    messages: {
        idUsuario: {
            required:"Por favor, introduce un nombre de Usuario válida",
            minlength:'El Usuario debe tener al menos {0} caracteres'
        },
        idContrasena: {
          required: "Por favor proporcione una contraseña",
          minlength: "Tu contraseña debe tener al menos {0} caracteres",
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
