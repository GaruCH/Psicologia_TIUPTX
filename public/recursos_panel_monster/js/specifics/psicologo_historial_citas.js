let loader = new Loader('loader');


//================================================================
//===================SECCIÓN PARA TABLA===========================
//================================================================

// DATATABLE
//================================================================
const create_citas_table = () => {
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
        { "data": "nombre_paciente" },
        { "data": "descripcion_cita" },
        { "data": "fecha_cita" },
        { "data": "estado_cita" },
    ];
    return instantiateAjaxDatatable('table-citas', './historial/data', 'GET', null, columns_elements, columns_order);
}; //end create_psicologos_table

let table_citas = create_citas_table();
