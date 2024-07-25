
// Validar archivo
/*
  obj: hace referencia al objeto, es decir input file
  btn: id del boton a bloquear temporalmente
  allowed_extensions: extensiones que aceptará el archivo, divididas con un |
  allowed_size: tamaño máximo en MB que se permitirá del archivo, como 1, 5 o 10 mb como ejemplo
*/
 this, 'btn-submit-file', 'pdf|xls|pptx', 1
const validate_file = (obj, btn, allowed_extensions, allowed_size) => {
    let uploadFile = obj.files[0];
    let button = document.getElementById(btn);
    if(uploadFile){
        if(!(uploadFile.name.match(new RegExp("."+allowed_extensions)))) {
            button.disabled = true;
            alerta_modal("¡Aviso!", "Formato del archivo no permitido. Solo se permiten archivos con las extensiones: " + allowed_extensions, 2);
            button.disabled = false;
            obj.value = '';
        }//end if
        else{
            if((uploadFile.size/1024/1024) > allowed_size) {
                button.disabled = true;
                alerta_modal("¡Aviso!", 'El peso del archivo debe ser menor a '+allowed_size+'MB', 2);
                button.disabled = false;
                obj.value = '';
            }//end of if
        }//end of else
    }//end if no cancela el archivo
    else{
        button.disabled = true;
        button.disabled = false;
        obj.value = '';
    }//end else no cancela el archivo
};//end validate_file
