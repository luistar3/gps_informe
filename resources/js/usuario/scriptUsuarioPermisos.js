$(document).ready(function () {
    fncListarPermisosModulos();
    fncListarPermisosRoles();
    // var elemdefault = document.querySelector('.js-switch');
    // var switchery = new Switchery(elemdefault, { color: '#bdc3c7', jackColor: '#fff', jackColor: '#9decff', size: 'small' });
    // elemdefault.onchange = function () {
    //     if (elemdefault.checked) {
    //     } else {

    //     }
    // };

    $('#inputIdSelectRol').on('select2:select', function (e) {




        var value = e.params.data.id;
        var data = {
            'id': value
        }
        $.ajax({
            type: "GET",
            url: "/gps/src/private/ModuloRolPermisosListar.php",
            data: data,
            success: function (response) {
                jsonData = JSON.parse(response);
                var idmodulos = new Array();
                $.each(jsonData.data, function (indexInArray, valueOfElement) {
                    var idModulo = '#' + 'moduloId' + valueOfElement.idModulo;
                    idmodulos.push(idModulo);
                });
                $.each(switcheryGlobal, function (indexInArray, element) { 
                    var idmodulo= '#'+element.element.id;
                   if (idmodulos.includes( idmodulo )) {
                    setSwitchery(element, true);
                   }else{
                    setSwitchery(element, false);
                   }
                   });
            }
        });
    });



});
$(document).on('change', '.js-switch', function (e) {
    let test = e.target.checked;
    var valorId = e.target.attributes["data-idmodulo"].value;
   // console.log(e);
});



function setSwitchery(switchElement, checkedBool) {
    if ((checkedBool && !switchElement.isChecked()) || (!checkedBool && switchElement.isChecked())) {
        switchElement.setPosition(true);
        switchElement.handleOnchange(true);
    }
}

function changeSwitchery(element, checked) {
    if ((element.is(':checked') && checked == false) || (!element.is(':checked') && checked == true)) {
        element.parent().find('.switchery').trigger('click');
    }
}

function fncListarPermisosRoles() {
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
                $('#inputIdSelectRol').append($('<option>', {
                    value: jsonData.data[index].idRol,
                    text: '[ ' + jsonData.data[index].idRol + ' ] ' + jsonData.data[index].nombre
                }));
            }
            $.duplicate();

        }
    });

    $("#inputIdSelectRol").select2({
        placeholder: "Select a state",
        allowClear: true
    });

}
var switcheryGlobal = new Array();
function fncListarPermisosModulos() {
    $.ajax({
        type: "GET",
        url: "/gps/src/private/ModuloListar.php",
        data: "data",
        success: function (response) {

            var jsonData = JSON.parse(response);

            for (let index = 0; index < jsonData.data.length; index++) {
                var inicioDiv = '<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">';
                var h4 = '<h5>' + jsonData.data[index].modulo + '</h5>';
                var input = '<input data-idmodulo="' + jsonData.data[index].idModulo + '" id="moduloId' + jsonData.data[index].idModulo + '" type="checkbox" class="js-switch" data-switchery="true">';
                var finDiv = '</div>';
                $("#idTableModulos").append([inicioDiv, h4, input, finDiv].join(''));
            }
            $.duplicate();

            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

            elems.forEach(function (html) {
                //console.log(elems);
                //var switchery = new Switchery(html, { color: '#bdc3c7', jackColor: '#fff', jackColor: '#9decff', size: 'small' });
                var switchery = new Switchery(html, { color: '#bdc3c7', jackColor: '#fff', jackColor: '#9decff', size: 'small' });
                
                switcheryGlobal.push(switchery);
            });



        }
    });
}


$('#idBtnGuardarPermisos').click(function (e) { 

    //console.log('hola ');
    var dataSelect = 0;
    $('#idFormPermisosUsuario select').each(
        function(index){  
            var input = $(this).val();
            dataSelect=input;
        }
    );
    var dataChecked = [];
    $('#idFormPermisosUsuario input').each(

        function(index){  
            var modulos = {
                moduloId:$(this).attr("data-idmodulo"),
                varlorCheck :$(this).prop("checked")
            }
            
            dataChecked.push(modulos);
        }
    );
    var data = {
        idRol:dataSelect,
        checked:dataChecked
    }
    console.log(data);
});
