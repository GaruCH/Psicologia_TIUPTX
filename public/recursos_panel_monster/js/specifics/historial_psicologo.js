let loader = new Loader('loader');


//================================================================
//===================SECCIÓN PARA TABLA===========================
//================================================================

// DATATABLE
//================================================================
const create_historial_pacientes_table = () => {
    columns_elements = [
        {
            "targets": [0, 1, 2, 3, 4, 5],
            "createdCell": function (td, cellData, rowData, row, col) {
                $(td).addClass("special-cell text-center ");
            },
        }
    ];
    columns_order = [
        { "data": "total" },
        { "data": "identificador" },
        { "data": "nombre_usuario" },
        { "data": "estado_asignacion" },
        { "data": "fecha_historial" },
        { "data": "descripcion_historial" }
    ];
    return instantiateAjaxDatatable('table-historial-pacientes', './obtener_historial_pacientes', 'GET', null, columns_elements, columns_order);
}; //end create_psicologos_table

let table_historiales = create_historial_pacientes_table();