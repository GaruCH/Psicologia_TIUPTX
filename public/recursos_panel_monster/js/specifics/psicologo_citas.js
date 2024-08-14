let loader = new Loader('loader');


//================================================================
//===================SECCIÓN PARA TABLA===========================
//================================================================

// DATATABLE
//================================================================
const create_citas_table = () => {
    columns_elements = [
        {
            "targets": [0, 1, 2, 3, 4, 5, 6, 7],
            "createdCell": function (td, cellData, rowData, row, col) {
                $(td).addClass("special-cell text-center ");
            },
        }
    ];
    columns_order = [
        { "data": "total" },
        { "data": "identificador" },
        { "data": "nombre_paciente" },
        { "data": "descripcion_cita" },
        { "data": "fecha_cita" },
        { "data": "hora_cita" },
        { "data": "estado_cita" },
        { "data": "acciones" }
    ];
    return instantiateAjaxDatatable('table-citas', './obtener_citas', 'GET', null, columns_elements, columns_order);
}; //end create_psicologos_table

let table_citas = create_citas_table();

// BOTONES OPCIONES
// =================================================================

$(document).on('click', '.confirmar-cita', function () {
    let elemento = $(this).attr('id');
    let id = elemento.split('_')[0];
    let estatus = elemento.split('_')[1];
    let array = ['./cambiar_estatus_cita_aceptar', id, estatus, 'esta cita', 'se actualizará.'];
    cambiar_estatus_citas_aceptar_datatable(array, table_citas);
});//end onclick estatus-psicologos

$(document).on('click', '.cancelar-cita', function () {
    let elemento = $(this).attr('id');
    let id = elemento.split('_')[0];
    let estatus = elemento.split('_')[1];
    let array = ['./cambiar_estatus_cita_cancelar', id, estatus, 'esta cita', 'se actualizará.'];
    cambiar_estatus_citas_cancelar_datatable(array, table_citas);
});//end onclick estatus-psicologos

$(document).on('click', '.concluir-cita', function () {
    let elemento = $(this).attr('id');
    let id = elemento.split('_')[0];
    let estatus = elemento.split('_')[1];
    let array = ['./cambiar_estatus_cita_concluir', id, estatus, 'esta cita', 'se  actualizará.'];
    cambiar_estatus_citas_concluir_datatable(array, table_citas);
});//end onclick estatus-psicologos


$(document).on('click', '.eliminar-cita', function () {
    eliminar_datatable("./eliminar_cita", $(this).attr('id'), '¿Estás seguro de eliminar a esta cita?', 'Esta acción es permanente', table_citas);
});//end onclick eliminar-psicologo

$(document).ready(function() {
    // Ocultar el campo de hora al cargar la página
    $('#hora_cita_container').hide();

    $('#fecha_cita').change(function() {
        var fecha = $(this).val();
        var psicologoId = $('#id_psicologo').val();
        console.log('ID Psicólogo:', psicologoId);
        console.log('Fecha seleccionada:', fecha);

        if (fecha) {
            var date = new Date(fecha);
            var diaNumero = date.getDay() + 1; // 1 (Lunes) a 7 (Domingo)
            console.log('Día número:', diaNumero);

            // Verificar si la fecha seleccionada es válida (habilitada)
            $.ajax({
                url: './verificar_fecha_valida/' + diaNumero + '/' + psicologoId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Respuesta de verificar fecha válida:', response);
                    if (response.fecha_valida) {
                        // Mostrar el campo de hora si la fecha es válida
                        $('#hora_cita_container').show();

                        // Solicitar horas disponibles al servidor
                        $.ajax({
                            url: './obtener_horas_disponibles/' + diaNumero + '/' + psicologoId + '/' + fecha,
                            method: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                console.log('Respuesta de horas disponibles:', response);
                                if (response.horas_disponibles) {
                                    var selectHora = $('#hora_cita');
                                    selectHora.empty();
                                    selectHora.append('<option value="">Selecciona una hora</option>');

                                    $.each(response.horas_disponibles, function(index, hora) {
                                        selectHora.append('<option value="' + hora.value + '">' + hora.text + '</option>');
                                    });
                                } else {
                                    alert(response.error);
                                }
                            },
                            error: function() {
                                mensaje_notificacion('Hubo un error con nuestro servidor. Intente nuevamente, por favor.', 'danger', '¡Error al obtener las horas disponibles!', 4000);
                            }
                        });
                    } else {
                        // Ocultar el campo de hora si la fecha no es válida
                        $('#hora_cita_container').hide();
                        mensaje_notificacion('Horas no disponibles del psicólogo o psicóloga.', 'warning', '¡Advertencia!', 4000);
                    }
                },
                error: function() {
                    mensaje_notificacion('Hubo un error con nuestro servidor. Intente nuevamente, por favor.', 'danger', '¡Error al verificar la validez de la fecha!', 4000);
                }
            });
        } else {
            // Ocultar el campo de hora si no se selecciona una fecha
            $('#hora_cita_container').hide();
        }
    });
});


