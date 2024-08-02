let loader = new Loader('loader');


//================================================================
//===================SECCIÓN PARA TABLA===========================
//================================================================

// DATATABLE
//================================================================
const create_horarios_table = () => {
    columns_elements = [
        {
            "targets": [0,1,2,3,4],
            "createdCell": function(td, cellData, rowData, row, col) {
                $(td).addClass("special-cell text-center ");

                // Agregar los atributos data-hora-entrada y data-hora-salida
                if (col === 3) {
                    $(td).closest('tr').attr('data-hora-entrada', cellData);
                    $(td).html(`<input type="time" class="form-control" value="${cellData}">`);
                }
                if (col === 4) {
                    $(td).closest('tr').attr('data-hora-salida', cellData);
                    $(td).html(`<input type="time" class="form-control" value="${cellData}">`);
                }
            },
        }
    ];
    columns_order = [
        {"data": "id_h"},
        {"data": "dia"},
        {"data": "estado"},
        {"data": "hora_entrada"},
        {"data": "hora_salida"}
    ];
    return instantiateAjaxDatatable('table-horario','./obtener_horario','GET', null, columns_elements, columns_order);
}; //end create_horarios_table

let table_horarios = create_horarios_table();


// BOTONES OPCIONES
// =================================================================
$(document).on('click', '.estatus-horario', function() {
	let elemento = $(this).attr('id');
	let id = elemento.split('_')[0];
    let estatus = elemento.split('_')[1];
	let array = ['./estatus_horario', id, estatus, 'este horario', 'estará disponible'];
    cambiar_estatus_datatable(array, table_horarios);
});//end onclick estatus-psicologos

//================================================================
//===================SECCIÓN PARA CREAR===========================
//================================================================

// Método de validación personalizado para asegurar que la hora de entrada sea menor que la hora de salida
$.validator.addMethod("timeLessThan", function(value, element, param) {
    let startTime = $(param).val();
    let endTime = value;

    // Convertir las horas a minutos desde el inicio del día
    function convertToMinutes(time) {
        let [hours, minutes] = time.split(':').map(Number);
        return hours * 60 + minutes;
    }

    return this.optional(element) || convertToMinutes(startTime) < convertToMinutes(endTime);
}, "La hora de entrada debe ser anterior a la hora de salida");

// Método de validación para formato de hora (HH:MM)
$.validator.addMethod("timeFormat", function(value, element) {
    return this.optional(element) || /^([0-1][0-9]|2[0-3]):([0-5][0-9])$/.test(value);
}, "Ingrese una hora válida en formato HH:MM");

$("#formulario-horario").validate({
    rules: {
        dia: {
            required: true,
        },
        hora_entrada: {
            required: true,
            timeFormat: true // Asegura que la entrada sea un tiempo válido en formato HH:MM
        },
        hora_salida: {
            required: true,
            timeFormat: true, // Asegura que la salida sea un tiempo válido en formato HH:MM
            timeLessThan: '#hora_entrada' // Verifica que la hora de salida sea mayor que la hora de entrada
        }
    },
    messages: {
        dia: {
            required: 'Se requiere seleccionar un día.'
        },
        hora_entrada: {
            required: 'Se requiere la hora de entrada.',
            timeFormat: 'Ingrese una hora válida en formato HH:MM'
        },
        hora_salida: {
            required: 'Se requiere la hora de salida.',
            timeFormat: 'Ingrese una hora válida en formato HH:MM',
            timeLessThan: 'La hora de salida debe ser posterior a la hora de entrada'
        }
    },
    highlight: function(input) {
        $(input).addClass('is-invalid');
        $(input).removeClass('is-valid');
    },
    unhighlight: function(input) {
        $(input).removeClass('is-invalid');
        $(input).addClass('is-valid');
    },
    errorPlacement: function(error, element) {
        $(element).next().append(error);
    }
});
//INSERTAR HORARIO
//================================================================
document.getElementById('formulario-horario').addEventListener('submit', event => {
    event.preventDefault();
    event.stopImmediatePropagation();

    // Asegúrate de ejecutar tu lógica de validación antes de este punto
    if ($('#formulario-horario .is-invalid').length == 0) {
        loader.setLoaderTitle('Registrando el horario, por favor espere...');
        loader.setLoaderBody('Por favor espere en lo que se registra el horario...');
        loader.openLoader();
        
        fetch('./registrar_horario', {
            method: 'POST',
            body: new FormData(document.getElementById('formulario-horario'))
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Ocurrió un error');
            }
            return res.json();
        })
        .then(respuesta => {
            loader.closeLoader();
            mensaje_notificacion(respuesta.mensaje, respuesta.tipo_mensaje, respuesta.titulo, respuesta.timer_message);

            if (respuesta.error === 0) {
               // Reseteamos los campos básicos
                $('#formulario-horario')[0].reset();
                // Limpia cualquier mensaje de retroalimentación
                $('.invalid-feedback').text('');
                // Eliminar clases de validación de Bootstrap
                $('#formulario-horario .form-control').removeClass('is-valid is-invalid');
                $('#formulario-horario .form-select').removeClass('is-valid is-invalid');
                $('#formulario-horario .form-check-input').removeClass('is-valid is-invalid');

                $('#nuevo-horario').modal('hide');
                table_horarios.ajax.reload(null, false);
            }
        })
        .catch(error => {
            loader.closeLoader();
            mensaje_notificacion('Hubo un error con nuestro servidor. Intente nuevamente, por favor.', 'danger', '¡Error al registrar!', 4000);
        });
    } else {
        mensaje_notificacion('Por favor, completa los campos correctamente antes de enviar.', 'warning', '¡Advertencia!', 4000);
    }
});


//==============================================================================
//===================SECCIÓN PARA EDITAR========================================
//==============================================================================

// Botón para guardar cambios
// Función para convertir el tiempo a minutos
const timeToMinutes = (time) => {
    const [hours, minutes] = time.split(':').map(Number);
    return hours * 60 + minutes;
};

// Botón para guardar cambios
$(document).on('click', '#save-changes', function() {
    const updates = [];
    const cambios = [];
    let valid = true;

    $('#table-horario').DataTable().rows().nodes().to$().each(function() {
        const row = $(this);
        const id = row.find('td').eq(0).text(); // Obtener el ID desde la primera columna
        const horaEntrada = row.find('td').eq(3).find('input').val();
        const horaSalida = row.find('td').eq(4).find('input').val();

        if (id) {
            // Obtener valores actuales del servidor
            const currentHoraEntrada = row.attr('data-hora-entrada');
            const currentHoraSalida = row.attr('data-hora-salida');

            // Verificar si los valores han cambiado
            if (horaEntrada !== currentHoraEntrada || horaSalida !== currentHoraSalida) {
                // Validar que la hora de entrada no sea mayor que la de salida
                if (timeToMinutes(horaEntrada) >= timeToMinutes(horaSalida)) {
                    valid = false;
                    mensaje_notificacion(`La hora de entrada (${horaEntrada}) no puede ser mayor o igual a la hora de salida (${horaSalida})`, 'danger', '¡Error de Validación!', 4000);
                    return false; // Salir del each loop
                }

                cambios.push(id); // Registrar IDs de filas con cambios
                updates.push({
                    id: id,
                    horaEntrada: horaEntrada,
                    horaSalida: horaSalida
                });
            }
        }
    });

    if (valid && updates.length > 0) {
        loader.setLoaderTitle('Actualizando horarios, por favor espere...');
        loader.setLoaderBody('Estamos actualizando los horarios. Esto puede tomar un momento.');
        loader.openLoader();

        // Enviar datos al servidor
        fetch('./editar_horario', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ updates: updates })
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Ocurrió un error');
            }
            return res.json();
        })
        .then(data => {
            loader.closeLoader();
            mensaje_notificacion(data.mensaje, data.tipo_mensaje, data.titulo, data.timer_message);

            if (data.error === 0) {
                // Actualizar la tabla si es necesario
                table_horarios.ajax.reload();
            }
        })
        .catch(error => {
            loader.closeLoader();
            mensaje_notificacion('Hubo un error con nuestro servidor. Inténtelo de nuevo, por favor.', 'danger', '¡Error al actualizar!', 4000);
        });
    } else {
        mensaje_notificacion('No hay horarios para actualizar.', 'warning', '¡Advertencia!', 4000);
    }
});



//==============================================================================
//==================================ON PAGE LOADED==============================
//==============================================================================



$(document).ready(function() {
    $('#cancel-form-create-horario').on('click', function() {
        // Reseteamos los campos básicos
        $('#formulario-horario')[0].reset();
        // Limpia cualquier mensaje de retroalimentación
        $('.invalid-feedback').text('');
        // Eliminar clases de validación de Bootstrap
        $('#formulario-horario .form-control').removeClass('is-valid is-invalid');
        $('#formulario-horario .form-select').removeClass('is-valid is-invalid');
        $('#formulario-horario .form-check-input').removeClass('is-valid is-invalid');

    });
});