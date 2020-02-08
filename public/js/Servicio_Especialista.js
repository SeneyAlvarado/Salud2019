function extraerRecintos() {
        $('#dropRecintos').empty();
        $('#dropRecintos').append("<option>Cargando...</option>");
        $('#dropEspecialistas').append("<option value='defecto'>Seleccione Especialista</option>");
        $('#dropServicios').append("<option value='defecto'>Seleccione Servicio</option>");

        $.ajax({
                url: '/recintosCombo',
                type: 'GET',
                dataType: "json",
                success: function (datos) {
                        $('#dropRecintos').empty();
                        $('#dropRecintos').append("<option value='defecto'>Seleccione Recinto</option>");
                        $.each(datos, function () {
                                $.each(this, function () {//los datos del server vienen en una variable data
                                        //si quieren ver esos datos pongan en la URL "/recintosCombo" por ejemplo.
                                        $('#dropRecintos').append('<option value="' + this.id + '">' + this.descripcion + '</option>');
                                })
                        })

                }, error: function () {
                        alert("¡Ha habido un error! Elija correctamente su recinto." +
                                "Si este error persiste por favor comuníquese con el Servicio de Salud");
                        $('#dropEspecialistas').append("<option value='defecto'>Seleccione Especialista</option>");
                }
        });
}

function extraerServicios(ID_Recinto) {
        $('#dropServicios').empty();
        $('#dropServicios').append("<option>Cargando...<option>");
        $.ajax({
                url: '/serviciosCombo/' + ID_Recinto,
                type: 'GET',
                dataType: "json",
                success: function (datos) {
                        $('#dropServicios').empty();
                        $('#dropServicios').append("<option value='defecto'>Seleccione Servicio</option>");
                        $.each(datos, function () {
                                $.each(this, function () {
                                        $('#dropServicios').append('<option value="' + this.id + '">' + this.nombre + '</option>');
                                })
                        })

                }, error: function () {
                        $('#dropServicios').empty();
                        $('#dropServicios').append("<option value='defecto'>Seleccione Servicio</option>");
                        alert("¡Ha habido un error! Si este persiste por favor comuníquese con el Servicio de Salud");
                }
        }); //fin ajax
}//fin servicios 


function extraerEspecialistas() {
        $('#dropEspecialistas').empty();
        $('#dropEspecialistas').append("<option>Cargando...<option>");
        $.ajax({
                url: '/cargarEspecialistas',
                type: 'GET',
                dataType: "json",
                success: function (datos) {
                        $('#dropEspecialistas').empty();
                        $('#dropEspecialistas').append("<option value='defecto'>Seleccione Especialista</option>");
                        $.each(datos, function () {
                                $.each(this, function () {
                                        $('#dropEspecialistas').append('<option value="' + this.id + '">' + this.nombre + ' ' + this.primer_apellido_especialista + ' ' + this.segundo_apellido_especialista + '</option>');
                                })
                        })

                }, error: function () {
                        $('#dropEspecialistas').empty();
                        $('#dropEspecialistas').append("<option value='defecto'>Seleccione Servicio</option>");
                        alert("¡Ha habido un error! Si este persiste por favor comuníquese con el Servicio de Salud");
                }
        }); //fin ajax
}//fin servicios 

function vincular() {
        if (validarInputs()) {
                if (($.trim($('#max_citas_diarias').val()).length === 0 )) {//Si max_citas_diarias es vacío
                        
                        alert("Digíte un número válido en máximo de citas diarias");
                        return false;
                        
                } else {//si max_citas_diarias NO es vacío
                        var servicio = $('#dropServicios').val();
                        var recinto = $('#dropRecintos').val();
                        var especialista = $('#dropEspecialistas').val();
                        var max_citas = $('#max_citas_diarias').val();
                        window.location.replace("/vincularEspecialista/" + servicio + "/" + recinto + "/" + especialista + "/" + max_citas);
                }
        }
}

function validarInputs() {
        var servicio = $('#dropServicios').val();
        var recinto = $('#dropRecintos').val();
        var especialista = $('#dropEspecialistas').val();

        if (recinto == "defecto") {
                alert("Elija un Recinto válido");
                return false;
        }
        if (servicio == "defecto") {
                alert("Elija un Servicio válido");
                return false;
        }
        if (especialista == "defecto") {
                alert("Elija un Especialista válido");
                return false;
        }
        return true;
}
/***********







***********/
//VER ESTO QUE ES IMPORTANTE E INVISIBLE, TOTALMENTE
$(document).ready(function () {
        setDefaultMaxCitas(0);
        prepareTooltip();
        extraerRecintos();
        $('#dropRecintos').change(function () {
                var ID_Recinto = $('#dropRecintos').val();
                if (ID_Recinto != 'defecto') {
                        extraerServicios(ID_Recinto);
                        //limpiarDrop("dropEspecialistas", "Especialista")
                } else {
                        limpiarDrop("dropServicios", "Servicio")
                        //limpiarDrop("dropEspecialistas", "Especialista")
                }
        })
        extraerEspecialistas();
})



/***********



*************/



function limpiarDrop(nombreDrop, nombreTexto) {
        $('#' + nombreDrop).empty();
        $('#' + nombreDrop).append("<option value='defecto'>----Seleccione " + nombreTexto + "----</option>");
}

function prepareTooltip() {
        $('[data-toggle="tooltip"]').tooltip({
                placement: 'top'
        });
}

function max_citas_number() {
        var max_citas = $('#max_citas_diarias').val();
        if (max_citas.length == 2 && max_citas.charAt(0) == "0") {
                $('#max_citas_diarias').val(max_citas.charAt(1));
        }
        if (isNaN(max_citas) || max_citas.charAt(1) == ".") {
                alert("Solo tiene permitido digitar números");
                $('#max_citas_diarias').val("0");
        }
}

function setDefaultMaxCitas(valor) {
        document.getElementById("max_citas_diarias").defaultValue = valor;
}