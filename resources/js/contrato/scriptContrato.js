$(document).ready(function () {

    $('#idBtnAgregarNuevoClienteJuridica').on('click', (e) => {
        e.preventDefault();

        $('#idFormPersonaJuridica').submit();

        return false;
    })
    $('#idBtnAgregarNuevoClienteNatural').on('click', (e) => {
        e.preventDefault();
        $('#idFormPersonaNatural').submit();

        return false;
    })


    var elemdefault = document.querySelector('#idCheckNaturalJuridica');
    var switchery = new Switchery(elemdefault, { color: '#bdc3c7', jackColor: '#fff', jackColor: '#9decff', size: 'small' });


    elemdefault.onchange = function () {
        //console.log(elemdefault.checked);
        if (elemdefault.checked) {
            $("#idFormularioJuridica").attr("hidden", true);
            $("#idFormularioNatural").removeAttr('hidden');
        } else {
            $("#idFormularioJuridica").attr("hidden", false);
            $("#idFormularioNatural").attr("hidden", true)
        }
        fncClearInputsNaturalJuridica();
    };

    $('.validanumericos').keypress(function (e) {
        if (isNaN(this.value + String.fromCharCode(e.charCode)))
            return false;
    })
        .on("cut copy paste", function (e) {
            e.preventDefault();
        });

    var dniInput = $("#IdInputDni");
    dniInput.change(function () {

        if (dniInput.val().length > 7 && dniInput.val().length < 9) {
            var persona = fncGetDataDni($("#IdInputDni").val());
        }

    });


    var dniInputRepresentanteLegal = $("#IdInputDniRepresentanteLegal");
    dniInputRepresentanteLegal.change(function () {
        if (dniInputRepresentanteLegal.val().length > 7 && dniInputRepresentanteLegal.val().length < 9) {
            //console.log($("#inputDniVisita").val());
            var persona = fncGetDataDniRepresentanteLegal($("#IdInputDniRepresentanteLegal").val());
        }
    });
    var rucInput = $("#IdInputRuc");
    rucInput.change(function () {
        console.log("jo");
        if (rucInput.val().length > 10 && rucInput.val().length < 12) {
            //console.log($("#inputDniVisita").val());
            var juridica = fncGetDataRuc($("#IdInputRuc").val());
        }

    });


    $("#idInputFechaInicioContrato,#idInputFechaFinContrato").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        lang: "es",
        format: 'Y-m-d',
        maxYear: 3000
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
                    $("#idInputNombrePersonaNatural").val(response.result.nombres.toString());
                    $("#idInputApellidoPersonaNatural").val(response.result.apellido_paterno.toString() + ' ' + response.result.apellido_materno.toString());
                    //console.log(response.print);
                    if (response.print == '' || response.print == null) { } else {
                        // console.log("a");
                        $('#idInputNombrePersonaNatural').attr("disabled", true);
                        $('#idInputApellidoPersonaNatural').attr("disabled", true);
                        $('#IdInputDni').attr("disabled", true);
                    }

                }
            },
            complete: function (xhr, status) {
                if (dniInput.val().length > 8) {
                    $('#idInputNombrePersonaNatural').attr("disabled", false);
                    $('#idInputApellidoPersonaNatural').attr("disabled", false);
                    $('#IdInputDni').attr("disabled", false);
                }
            }
        });

    }

    function fncGetDataDniRepresentanteLegal(dni) {
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
                    $("#idInputNombreRepresentanteLegal").val(response.result.nombres.toString());
                    $("#idInputApellidoRepresentanteLegal").val(response.result.apellido_paterno.toString() + ' ' + response.result.apellido_materno.toString());
                    if (response.result.apellido_paterno == 'null' || response.result.apellido_paterno == null) { } else {
                        $('#idInputNombreRepresentanteLegal').attr("disabled", true);
                        $('#idInputApellidoRepresentanteLegal').attr("disabled", true);
                        $('#IdInputDniRepresentanteLegal').attr("disabled", true);

                    }
                }
            },
            complete: function (xhr, status) {
                if (dniInput.val().length > 8) {
                    $('#idInputNombreRepresentanteLegal').attr("disabled", false);
                    $('#idInputApellidoRepresentanteLegal').attr("disabled", false);
                    $('#IdInputDniRepresentanteLegal').attr("disabled", false);
                }
            }
        });

    }

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

    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

        if (repo.description) {
            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
        }

        markup += "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'><i class='icofont icofont-flash'></i> " + repo.forks_count + " Forks</div>" +
            "<div class='select2-result-repository__stargazers'><i class='icofont icofont-star'></i> " + repo.stargazers_count + " Stars</div>" +
            "<div class='select2-result-repository__watchers'><i class='icofont icofont-eye-alt'></i> " + repo.watchers_count + " Watchers</div>" +
            "</div>" +
            "</div></div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.full_name || repo.text;
    }
    $("#idSelectCliente").select2({
                language: {

            noResults: function () {

                return "No hay resultado";
            },
            searching: function () {

                return "Buscando..";
            },
            inputTooShort: function () {
                return 'Ingrese texto para la búsqueda.';
            }
        },
        ajax: {
            url: "/gps/src/private/ClienteBuscarPorDatos.php",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {

                var jsonData = JSON.stringify(data.data);

                var data = JSON.parse(jsonData);
                console.log(data);
                return {
                    results: data
                };
            },
            cache: true
        },
        // let our custom formatter work
        minimumInputLength: 3

    });


    $("#pruebas").click(function (e) {
        var idCliente = $('#idSelectCliente').val();
        console.log(idCliente);

    });

    $("#modalLargeNuevoCliente").on("hidden.bs.modal", function () {
        fncClearInputsNaturalJuridica();
    });

    function fncClearInputsNaturalJuridica() {
        $("#idFormPersonaNatural").trigger('reset');
        $("#idFormPersonaJuridica").trigger('reset');

        $('#IdInputRazonSocial').attr("disabled", false);
        $('#IdInputRuc').attr("disabled", false);

        $('#idInputNombreRepresentanteLegal').attr("disabled", false);
        $('#idInputApellidoRepresentanteLegal').attr("disabled", false);
        $('#IdInputDniRepresentanteLegal').attr("disabled", false);

        $('#idInputNombrePersonaNatural').attr("disabled", false);
        $('#idInputApellidoPersonaNatural').attr("disabled", false);
        $('#IdInputDni').attr("disabled", false);
    }







    $('#idFormPersonaNatural').validate({

        submitHandler: function (form) {
            var dni = $('#IdInputDni').val();
            var nombrePersonaNatural = $('#idInputNombrePersonaNatural').val();
            var apellidoPersonaNatural = $('#idInputApellidoPersonaNatural').val();
            var correoPersonaNatural = $('#idInputCorreoPersonaNatural').val();
            var telefonoPersonaNatural = $('#idInputTelefonoPersonaNatural').val();
            var direccionPersonaNatural = $('#idInputDireccionPersonaNatural').val();

            // var voucher = $('#idInputVoucher').prop('files')[0];

            var formularioValido = true;
            var campos = [];

            if (dni === '' || dni === null) {
                formularioValido = false;
                campos.push("El dni de la persona es requerida");
            }
            if (dni.length < 8) {
                formularioValido = false;
                campos.push("Escriba un dni válido");
            }
            if (nombrePersonaNatural === '' || nombrePersonaNatural === null) {
                formularioValido = false;
                campos.push("El nombre de la persona es requerida");
            }
            if (apellidoPersonaNatural === '' || apellidoPersonaNatural === null) {
                formularioValido = false;
                campos.push("Los apellidos de la persona son requeridos");
            }
            if (correoPersonaNatural === '' || correoPersonaNatural === null) {
                formularioValido = false;
                campos.push("El correo de la persona es requerida");
            }
            if (telefonoPersonaNatural === '' || telefonoPersonaNatural === null) {
                formularioValido = false;
                campos.push("El telefono de la persona es requerida");
            }
            if (direccionPersonaNatural === '' || direccionPersonaNatural === null) {
                formularioValido = false;
                campos.push("La dirección de la persona es requerida");
            }
            var tipoPersona = 'personaNatural';
            var formData = new FormData();
            formData.append('tipoPersona', tipoPersona);
            formData.append('dni', dni);
            formData.append('nombres', nombrePersonaNatural);
            formData.append('apellidos', apellidoPersonaNatural);
            formData.append('correo', correoPersonaNatural);
            formData.append('telefono', telefonoPersonaNatural);
            formData.append('direccion', direccionPersonaNatural);

            // formData.append( 'recibo', $( '#idInputRecibo' )[0].files[0] );
            // formData.append( 'voucher', $( '#idInputVoucher' )[0].files[0] );
            if (formularioValido == true) {
                fncGuardarDatosCliente(formData);
                return false;

            } else {
                swal("Datos faltantes", campos[0], 'error');
            }
        }
    });


    $('#idFormPersonaJuridica').validate({

        submitHandler: function (form) {
            //console.log("persona Juridica");


            var ruc = $('#IdInputRuc').val();
            var razonsocial = $('#IdInputRazonSocial').val();
            var correoJuridico = $('#IdInputCorreoJuridica').val();
            var dniRepresentanteLegal = $('#IdInputDniRepresentanteLegal').val();
            var nombreRepresentanteLegal = $('#idInputNombreRepresentanteLegal').val();
            var apellidoRepresentanteLegal = $('#idInputApellidoRepresentanteLegal').val();
            var correoRepresentanteLegal = $('#idInputCorreoRepresentanteLegal').val();
            var telefonoRepresentanteLegal = $('#idInputTelefonoRepresentanteLegal').val();
            var direccionRepresentanteLegal = $('#idInputDireccionRepresentanteLegal').val();


            //var voucher = $('#idInputVoucher').prop('files')[0];
            var formularioValido = true;
            var campos = [];
            if (ruc === '' || ruc === null) {
                formularioValido = false;
                campos.push("Los apellidos del difunto son requeridos");
            }
            if (ruc.length < 11) {
                formularioValido = false;
                campos.push("Escriba un ruc válido");
            }
            if (razonsocial === '' || razonsocial === null) {
                formularioValido = false;
                campos.push("El documento de indentidad es requerido");
            }
            if (correoJuridico === '' || correoJuridico === null) {
                formularioValido = false;
                campos.push("Es requeridad una fecha de inhumacion");
            }
            if (dniRepresentanteLegal === '' || dniRepresentanteLegal === null) {
                formularioValido = false;
                campos.push("Escriba un dni válido");
            }
            if (nombreRepresentanteLegal === '' || nombreRepresentanteLegal === null) {
                formularioValido = false;
                campos.push("Los nombres del representante legal es requeridos");
            }
            if (apellidoRepresentanteLegal === '' || apellidoRepresentanteLegal === null) {
                formularioValido = false;
                campos.push("Los apellidos del representante legal son requeridos");
            }
            if (correoRepresentanteLegal === '' || correoRepresentanteLegal === null) {
                formularioValido = false;
                campos.push("El correo del representante legal es requerida");
            }
            if (telefonoRepresentanteLegal === '' || telefonoRepresentanteLegal === null) {
                formularioValido = false;
                campos.push("El telefono del representante legal es requerida");
            }
            if (direccionRepresentanteLegal === '' || direccionRepresentanteLegal === null) {
                formularioValido = false;
                campos.push("La dirección del representante legal es requerida");
            }
            var tipoPersona = 'personaJuridica';
            var formData = new FormData();
            formData.append('tipoPersona', tipoPersona);
            formData.append('ruc', ruc);
            formData.append('razonSocial', razonsocial);
            formData.append('correoJuridico', correoJuridico);
            formData.append('dni', dniRepresentanteLegal);
            formData.append('nombres', nombreRepresentanteLegal);
            formData.append('apellidos', apellidoRepresentanteLegal);
            formData.append('correo', correoRepresentanteLegal);
            formData.append('telefono', telefonoRepresentanteLegal);
            formData.append('direccion', direccionRepresentanteLegal);

            if (formularioValido == true) {
                fncGuardarDatosCliente(formData);
                return false;

            } else {
                //notificacion('Datos faltantes : ', campos[0], 'warning');
            }
        }
    });


    function fncGuardarDatosCliente(data) {


        swal({
            title: "Estas seguro?",
            text: "Los dato seran enviados para registro de un cliente!",
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
                        url: '/gps/src/private/ClienteGuardar.php',
                        data: data,
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function (response) {
                            var jsonData = JSON.parse(response);
                            console.log(jsonData);
                            if (jsonData.error == false) {
                                swal("Registrado", jsonData.mensaje, "success");
                                $('#modalLargeNuevoCliente').modal('hide');
                            } else {
                                swal("Error", jsonData.mensaje, "error");
                            }
                        }
                    });

                } else {
                    swal("Cancelado", "Los datos no se enviaron", "error");
                }
            });



    }

    $("#idBtnGuardarContrato").click(function (e) {

        var idCliente = $('#idSelectCliente').val();
        var idInputMensualidadContrato = $('#idInputMensualidadContrato').val();
        var idInputFechaInicioContrato = $("#idInputFechaInicioContrato").val();
        var idInputFechaFinContrato = $("#idInputFechaFinContrato").val();

        var pagoContrato = $('input[name="pagoContrato[]"]').map(function () {
            return this.value;
        }).get();

        var pagoFrecuencia = [];
        $('select[name="pagoFrecuencia[]"] option:selected').each(function () {
            pagoFrecuencia.push($(this).val());
        });

        var marcaVehiculo = [];
        $('select[name="marcaVehiculo[]"] option:selected').each(function () {
            marcaVehiculo.push($(this).val());
        });
       
        var modelo = $("input[name='modelo[]']").map(function () {
            return $(this).val();}).get();  

        var placa = $("input[name='placa[]']").map(function () {
            return $(this).val();}).get();

        var gps = $('input[name="gps[]"]').map(function () {
            return $(this).val();}).get();  
                  
        var imei = $('input[name="imei[]"]').map(function () {
            return $(this).val();}).get();
        var anio = $('input[name="anio[]"]').map(function () {
            return $(this).val();}).get();
            
        var fechaInstalacion = $('input[name="fechaInstalacion[]"]').map(function () {
            return $(this).val();}).get();
            
        var formularioValido = true;
        var campos = [];
        if (idCliente === '' || idCliente === null) {
            formularioValido = false;
            campos.push("Debe elegir un cliente");
        }
        if (idInputMensualidadContrato === '' || idInputMensualidadContrato === null) {
            formularioValido = false;
            campos.push("Determine la mensualidad");
        }
        if (idInputFechaInicioContrato === '' || idInputFechaInicioContrato === null) {
            formularioValido = false;
            campos.push("Determine el inicio de contrato");
        }
        if (idInputFechaFinContrato === '' || idInputFechaFinContrato === null) {
            formularioValido = false;
            campos.push("Determine fin del contrato");
        }

        var formData = new FormData();
        formData.append('idCliente', idCliente);
        formData.append('mensualidadContrato', idInputMensualidadContrato);
        formData.append('fechaInicioContrato', idInputFechaInicioContrato);
        formData.append('fechaFinContrato', idInputFechaFinContrato);
        formData.append('pagoContrato', JSON.stringify(pagoContrato));
        formData.append('pagoFrecuencia', JSON.stringify(pagoFrecuencia));
        formData.append('marcaVehiculo', JSON.stringify(marcaVehiculo));
        formData.append('modelo', JSON.stringify(modelo));
        formData.append('placa', JSON.stringify(placa));
        formData.append('gps', JSON.stringify(gps));
        formData.append('anio', JSON.stringify(anio));
        formData.append('imei', JSON.stringify(imei));
        formData.append('fechaInstalacion', JSON.stringify(fechaInstalacion));

        //console.log(formData);

        if (formularioValido == true) {
            fncGuardarContratoCliente(formData);
            return false;

        } else {
            swal("Falta datos", campos[0], "error");
        }

    });

    function fncGuardarContratoCliente(data) {


        swal({
            title: "Estas seguro?",
            text: "Los dato seran enviados para registro de un contrato!",
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
                        url: '/gps/src/private/ContratoGuardar.php',
                        data: data,
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function (response) {
                            var jsonData = JSON.parse(response);
                            //console.log(jsonData);
                            if (jsonData.error==false) {
                                swal("Registrado", jsonData.mensaje, "success");
                               // $('#modalLargeNuevoCliente').modal('hide');
                               location.reload(true);
                            } else {
                                swal("Error", jsonData.mensaje, "error");
                            }
                        }
                    });

                } else {
                    swal("Cancelado", "Los datos no se enviaron", "error");
                }
            });



    }
    fncListarMarcasVehiculos();
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



});