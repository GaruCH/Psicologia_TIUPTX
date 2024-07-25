
//Función para instanciar una datatable básica (sin ajax)
const instantiateBasicDatatable = (nameClass = 'datatable') => {
    let datatable = $('.'+nameClass).DataTable({
                        "responsive": true,
                        'scrollX': true,
                        drawCallback: function (settings) {
                            feather.replace();
                            let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                            let tooltipList = tooltipTriggerList.map(function(element){
                                return new bootstrap.Tooltip(element);
                            });
                        },
                        "language": {
                            "paginate": {
                              "previous": '<i class="fas fa-angle-left"></i>',
                              "next": '<i class="fas fa-angle-right"></i>'
                            },
                            "emptyTable": "No hay información",
                            "zeroRecords": "No se encontraron resultados",
                            "info": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
                            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
                            "sSearch": "Buscar:",
                            "sProcessing":"Procesando...",
                            "loadingRecords": "Cargando...",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ registros",
                        }
                    });
    return datatable;
}//end instantiateBasicDatatable



//Función para instanciar una datatable con ajax
const instantiateAjaxDatatable = (nameId = 'datatable', locationAjax = '', typeAjax = 'GET', bodyAjax, columnElements, columnsOrder) => {
    let datatable = $('#'+nameId).DataTable({
                        'processing': true,
                        'scrollX': true,
                        'ajax': {
                            url: locationAjax,
                            data: bodyAjax,
                            type: typeAjax,
                        },
                        "columnDefs": columnElements,
                        drawCallback: function (settings) {
                            feather.replace();
                            let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                            let tooltipList = tooltipTriggerList.map(function(element){
                                return new bootstrap.Tooltip(element);
                            });
                        },
                        "columns": columnsOrder,
                        "language": {
                            "paginate": {
                              "previous": '<i class="fas fa-angle-left"></i>',
                              "next": '<i class="fas fa-angle-right"></i>'
                            },
                            "emptyTable": "No hay información",
                            "zeroRecords": "No se encontraron resultados",
                            "info": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
                            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
                            "sSearch": "Buscar:",
                            "sProcessing":"Procesando...",
                            "loadingRecords": "Cargando...",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ registros",
                        }
                    });
    return datatable;
}//end instantiateAjaxDatatable



//Función para instanciar una datatable con ajax y lenguaje personalizado
const instantiateAjaxDatatableLanguage = (nameId = 'datatable', locationAjax = '', typeAjax = 'GET', bodyAjax, columnElements, columnsOrder, languageOrder) => {
    let datatable = $('#'+nameId).DataTable({
                        'processing': true,
                        'scrollX': true,
                        'ajax': {
                            url: locationAjax,
                            data: bodyAjax,
                            type: typeAjax,
                        },
                        "columnDefs": columnElements,
                        drawCallback: function (settings) {
                            feather.replace();
                            let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                            let tooltipList = tooltipTriggerList.map(function(element){
                                return new bootstrap.Tooltip(element);
                            });
                        },
                        "columns": columnsOrder,
                        "language": languageOrder
                    });
    return datatable;
}//end instantiateAjaxDatatableLanguage
