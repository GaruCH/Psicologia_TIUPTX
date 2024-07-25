
const mensaje_notificacion = (texto = "", tipo = 5, titulo = "", tiempo = 2000) => {
    let options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "showDuration": "100",
        "hideDuration": "100",
        "timeOut": tiempo,
        "extendedTimeOut": "100",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "fadeOut"
    };

    switch (tipo) {
        case 1:
            toastr.success(texto, titulo, options);
            break;
        case 2:
            toastr.error(texto, titulo, options);
            break;
        case 3:
            toastr.info(texto, titulo, options);
            break;
        case 4:
            toastr.warning(texto, titulo, options);
            break;
        default:
            toastr.info(texto, titulo, options);
            break;
    }//end switch

};//end mensaje_notificacion
