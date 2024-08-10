let loader = new Loader('loader');


//================================================================
//===================SECCIÓN PARA TABLA===========================
//================================================================

// DATATABLE
//================================================================
const create_asignaciones_table = () => {
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
        { "data": "nombre_usuario" },
        { "data": "sexo_usuario" },
        { "data": "edad_usuario" },
        { "data": "correo_usuario" },
        { "data": "papel_paciente" },
        { "data": "acciones" }
    ];
    return instantiateAjaxDatatable('table-asignaciones', './obtener_asignaciones', 'GET', null, columns_elements, columns_order);
}; //end create_psicologos_table

let table_usuarios = create_asignaciones_table();


//==============================================================================
//===================SECCIÓN PARA CONSULTAR========================================
//==============================================================================


// CREAR DATOS DEL MODAL
// =================================================================
$(document).on('click', '.ver-paciente', function () {
    let button_info = document.getElementById($(this).attr('id'));

    // Esconder el tooltip por si se bugea
    let tooltip_button = bootstrap.Tooltip.getInstance(button_info);
    if (tooltip_button) {
        tooltip_button.hide();
    }

    let id = $(this).attr('id').split('_')[1];

    loader.setLoaderTitle('Cargando datos, por favor espere...');
    loader.setLoaderBody('Por favor espere en lo que se cargan los datos del paciente...');
    loader.openLoader();

    fetch(`./obtener_paciente/${id}`)
        .then(res => {
            if (!res.ok) {
                throw new Error('Ocurrió un error');
            }
            return res.json();
        })
        .then(respuesta => {
            loader.closeLoader();

            if (respuesta.data === -1) {
                mensaje_notificacion("No existe el paciente buscado ¿Ha seleccionado correctamente al paciente?", DANGER_ALERT, "!Error al obtener el paciente!");
            } else {

                const papel = {
                    439: 'Alumno',
                    426: 'Administrativo',
                    411: 'Invitado'
                }[respuesta.data.id_subcate] || 'Desconocido'; // 'DESCONOCIDO' en caso de que no coincida ningún valor

                const referencia = {
                    211: 'Servicio Médico',
                    222: 'Tutor',
                    233: 'Director de Carrera',
                    244: 'Otro'
                }[respuesta.data.id_tipo_referencia] || 'Desconocido'; // 'DESCONOCIDO' en caso de que no coincida ningún valor

                const atencion = {
                    111: 'Primera vez',
                    122: 'Subsecuente',
                }[respuesta.data.id_tipo_atencion] || 'Desconocido'; // 'DESCONOCIDO' en caso de que no coincida ningún valor

                const area = {
                    1: 'Administrativo',
                    2: 'Docente',
                }[respuesta.data.id_area] || 'Desconocido'; // 'DESCONOCIDO' en caso de que no coincida ningún valor
                
                const carreras = {
                    10: 'Ingeniería en Biotecnología',
                    20: 'Ingeniería Mecatrónica',
                    30: 'Ingeniería Industrial',
                    40: 'Ingeniería en Tecnologías de la Información',
                    50: 'Ingeniería Financiera',
                    60: 'Ingeniería Química',
                    70: 'Ingeniería en Sitemas Automotrices'
                }[respuesta.data.id_programa] || 'Desconocido'; // 'DESCONOCIDO' en caso de que no coincida ningún valor

                const clean_elements = {
                    'numero_trabajador': respuesta.data.numero_trabajador_administrativo,
                    'nombre': respuesta.data.nombre_usuario,
                    'ap_paterno': respuesta.data.ap_paterno_usuario,
                    'ap_materno': respuesta.data.ap_materno_usuario,
                    'masculino': respuesta.data.sexo_usuario,
                    'femenino': respuesta.data.sexo_usuario,
                    'email': respuesta.data.email_usuario,
                    'fecha_nacimiento': respuesta.data.fecha_nacimiento_usuario,
                    'papel': papel,
                    'num_expediente': respuesta.data.numero_expediente,
                    'referencia': referencia,
                    'atencion': atencion,
                    'matricula': respuesta.data.matricula,
                    'programa_edu': carreras,
                    'area': area,
                    'identificador': respuesta.data.identificador
                };

                // Manejo de la imagen
                const sexoUsuario = parseInt(respuesta.data.sexo_usuario, 10); // Convertir a número

                const imgSrc = respuesta.data.imagen_usuario 
                    ? `../../recursos_panel_monster/images/profile-images/${respuesta.data.imagen_usuario}`
                    : sexoUsuario === 2 
                        ? '../../recursos_panel_monster/images/profile-images/no-image-m.png' // Masculino
                        : sexoUsuario === 1 
                            ? '../../recursos_panel_monster/images/profile-images/no-image-f.png' // Femenino
                            : '../../recursos_panel_monster/images/profile-images/no-image-default.png'; // En caso de valor inesperado

                clean_elements['img_editar'] = imgSrc;

                // Resetear el formulario y mostrar el modal
                resetear_formulario('formulario-paciente-ver', clean_elements, true);

                // Lógica para ocultar campos según id_subcate
                const idSubcate = respuesta.data.id_subcate;
                const fieldsToHide = {
                    439: ['numero_trabajador', 'area', 'identificador'], // Ocultar estos campos si id_subcate es 1
                    426: ['matricula', 'programa_edu', 'identificador'], // Ocultar estos campos si id_subcate es 2
                    411: ['matricula', 'programa_edu', 'numero_trabajador', 'area'],// Agrega más casos según sea necesario
                };

                // Mostrar u ocultar campos
                $('.col-md-6').show(); // Mostrar todos los campos por defecto
                if (fieldsToHide[idSubcate]) {
                    fieldsToHide[idSubcate].forEach(function (fieldId) {
                        document.getElementById(fieldId).closest('.col-md-6').style.display = 'none';
                    });
                }

                const modal_ver_paciente = new bootstrap.Modal(document.getElementById('ver-paciente'));
                modal_ver_paciente.show();
            }
        })
        .catch(error => {
            loader.closeLoader();
            mensaje_notificacion("Hubo un error con nuestro servidor. Intente nuevamente, por favor", DANGER_ALERT, "!Error al obtener al paciente!");
        });
});

