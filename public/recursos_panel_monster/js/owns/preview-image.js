//============================================
//FUNCIÓN PARA RESETEAR IMAGEN
//============================================
/**
 * id = 'preview'
 * src = 'ruta para obtener la imagen'
*/
const resetear_img = (id,src) => {
    document.getElementById(id).src=src;
};//end resetear_img

// Validar imagen
/*
  obj: hace referencia al objeto, es decir al boton
  preview: id de la imagen a la previsualización
  btn: id del boton a bloquear temporalmente
  img_base: imagen por defecto en caso de que la imagen no cumpla las condiciones
  ancho: tamañano del ancho de la imagen
  alto: tamaño del alto de la imagen
*/
 this, 'img', 'verify', '../recursos_panel_monster/images/profile-images/no-image-m.png', 512, 512
const validate_image = (obj, preview, btn, img_base, ancho, alto) => {
    let uploadFile = obj.files[0];
    let button = document.getElementById(btn);
    if(uploadFile){
        if(!(/\.(jpg|png|jpeg)$/i).test(uploadFile.name)) {
            alerta_modal("¡Aviso!", "Formato de la imagen no permitido", 2);
            button.disabled = true;
            resetear_img(preview,img_base);
            button.disabled = false;
            obj.value = '';
        }//end if
        else{
            let img = new Image();
            img.onload = function() {
            if((this.width.toFixed(0) > ancho || this.height.toFixed(0) > alto) || ((uploadFile.size/1024/1024) > 1)) {
                alerta_modal("¡Aviso!", 'El peso de la imagen debe ser menor a 2MB o la imagen excede el tamaño recomendado que es de '+ancho+"x"+alto, 2);
                button.disabled = true;
                // document.getElementById(preview).setAttribute('src', img_base);
                resetear_img(preview,img_base);
                button.disabled = false;
                obj.value = '';
            }//end of if
            else {
                if (obj.files && obj.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#'+preview).attr('src', e.target.result);
                        $('#'+preview).hide();
                        $('#'+preview).fadeIn(650);
                    }
                    reader.readAsDataURL(obj.files[0]);
                }
                button.disabled = false;
            }//end of else
        };//end of function
            img.src = URL.createObjectURL(uploadFile);
        }//end of else
    }//end if no cancela el archivo
    else{
        button.disabled = true;
        resetear_img(preview,img_base);
        button.disabled = false;
        obj.value = '';
    }//end else no cancela el archivo
};//end validate_image
// =======================================================================================
