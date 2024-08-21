const resetear_formulario = (id_form = '', fields_to_clean, has_select = false) => {
    let validator = $("#" + id_form).validate();
    validator.resetForm();
    $("#" + id_form + " .form-control").removeClass("is-valid is-invalid");
    if (has_select) {
        $("#" + id_form + " .form-select").removeClass("is-valid is-invalid");
    }

    for (let index in fields_to_clean) {
        let element = document.getElementById(index);
        if (element) {
            if (element.type === 'radio' || element.type === 'checkbox') {
                // Maneja radio buttons y checkboxes
                if (element.value === fields_to_clean[index]) {
                    element.checked = true;
                } else {
                    element.checked = false;
                }
            } else if (element.tagName === 'IMG') {
                // Actualiza el src de la imagen
                element.src = fields_to_clean[index];
            } else {
                // Maneja otros elementos de formulario
                element.value = fields_to_clean[index];
            }
        } else {
        
        }
    }
};


const resetear_spawnear_elementos_formulario = (id_form = '', fields_to_clean, fields_to_spawn, has_select = false) => {
    let validator = $("#"+id_form).validate();
    validator.resetForm();
    $("#"+id_form+" .form-control").removeClass("is-valid");
    $("#"+id_form+" .form-control").removeClass("is-invalid");
    if(has_select){
        $("#"+id_form+" .form-select").removeClass("is-valid");
        $("#"+id_form+" .form-select").removeClass("is-invalid");
    }//end if existe algún elemento select
    for(let index in fields_to_clean) {
        document.getElementById(index).value = fields_to_clean[index];
    }//end forin fields_to_clean
    for(let index in fields_to_spawn) {
        document.getElementById(index).style.display = fields_to_spawn[index];
    }//end forin fields_to_clean
};//end resetear_spawnear_elementos_formulario


const deshabilitar_habilitar_formulario = (fields_to_block, estatus = 'true', action = 'hidden', btn_form = '') =>{
    let set_style = (action == 'hidden') ?  'none' : 'block';
    document.getElementById(btn_form).style.display = set_style;
    for(let index in fields_to_block) {
        document.getElementById(index).disabled = estatus;
    }//end forin fields_to_clean
}//deshabilitar_formulario
