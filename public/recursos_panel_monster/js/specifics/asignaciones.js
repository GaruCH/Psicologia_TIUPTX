let loader = new Loader('loader');


//================================================================
//===================SECCIÓN PARA TABLA===========================
//================================================================

// DATATABLE
//================================================================
const create_asignaciones_table = () => {
    columns_elements = [
        {
            "targets": [0,1,2,3,4,5,6],
            "createdCell": function(td, cellData, rowData, row, col) {
                $(td).addClass("special-cell text-center ");

            },
        }
    ];
    columns_order = [
        {"data": "total"},
        {"data": "numero_trabajador"},
        {"data": "nombre_psicologo"},
        {"data": "identificador_paciente"},
        {"data": "nombre_paciente"},
        {"data": "fecha_asignacion"},
        {"data": "acciones"},
    ];
    return instantiateAjaxDatatable('table-asignaciones','./obtener_asignaciones','GET', null, columns_elements, columns_order);
}; //end create_horarios_table

let table_horarios = create_asignaciones_table();

//==============================================================================
//===================SECCIÓN PARA EDITAR========================================
//==============================================================================

// CREAR DATOS DEL MODAL

// =================================================================
$(document).on('click', '.editar-psicologo', function () {
    let button_info = document.getElementById($(this).attr('id'));
    // Esconder el tooltip por si se bugea
    let tooltip_button = bootstrap.Tooltip.getInstance(button_info);
    if (tooltip_button) {
        tooltip_button.hide();
    }

    let id = $(this).attr('id').split('_')[1];

    loader.setLoaderTitle('Cargando datos, por favor espere...');
    loader.setLoaderBody('Por favor espere en lo que se cargan los datos del psicólogo...');
    loader.openLoader();

    fetch('./obtener_psicologo/' + id)
        .then(res => {
            if (!res.ok) {
                throw new Error('Ocurrió un error');
            }
            return res.json();
        })
        .then(respuesta => {
            loader.closeLoader();
            if (respuesta.data === -1) {
                mensaje_notificacion("No existe el psicólogo buscado ¿Ha seleccionado correctamente el psicólogo?", DANGER_ALERT, "!Error al obtener el psicólogo¡");
            } else {
                let clean_elements = {
                    'numero_trabajador_editar': respuesta.data.numero_trabajador_psicologo,
                    'nombre_editar': respuesta.data.nombre_usuario,
                    'ap_paterno_editar': respuesta.data.ap_paterno_usuario,
                    'ap_materno_editar': respuesta.data.ap_materno_usuario,
                    'masculino_editar': respuesta.data.sexo_usuario,
                    'femenino_editar': respuesta.data.sexo_usuario,
                    'email_editar': respuesta.data.email_usuario,
                    'fecha_nacimiento_editar': respuesta.data.fecha_nacimiento_usuario,
                    'id_psicologo_editar': respuesta.data.id_psicologo
                };

                // Manejo de la imagen
                let sexoUsuario = parseInt(respuesta.data.sexo_usuario, 10); // Convertir a número

                let imgSrc;
                if (respuesta.data.imagen_usuario) {
                    imgSrc = `../../recursos_panel_monster/images/profile-images/${respuesta.data.imagen_usuario}`;
                } else {
                    if (sexoUsuario === 2) {
                        imgSrc = '../../recursos_panel_monster/images/profile-images/no-image-m.png'; // Masculino
                    } else if (sexoUsuario === 1) {
                        imgSrc = '../../recursos_panel_monster/images/profile-images/no-image-f.png'; // Femenino
                    } else {
                        imgSrc = '../../recursos_panel_monster/images/profile-images/no-image-default.png'; // En caso de valor inesperado
                    }
                }

                clean_elements['img_editar'] = imgSrc;

                resetear_formulario('formulario-psicologo-editar', clean_elements, true);
                let modal_edit_psicologo = new bootstrap.Modal(document.getElementById('editar-psicologo'));
                modal_edit_psicologo.show();
            }
        })
        .catch(error => {
            loader.closeLoader();
            mensaje_notificacion("Hubo un error con nuestro servidor. Intente nuevamente, por favor", DANGER_ALERT, "!Error al obtener el psicólogo¡");
        });
});