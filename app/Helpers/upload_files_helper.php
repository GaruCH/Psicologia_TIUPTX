<?php

// *****************************************************************************
// ************************** FUNCIONES PARA IMÁGENES **************************
// *****************************************************************************

/*
Esta función sirve para cargar una imagen, es dependiente de la función verify_image.
La función se encarga de subir la imagen a una ruta puesta con un prefijo de archivo, los parámetros son los siguientes:
    - $file = El archivo a cargar, obtenido por un input file.
    - $file_prefix_name = El prefijo que gustemos que tenga el archivo, si no queremos uno simplemente se usará el default encriptado.
    - $route_to_save = La ruta en la que irá la imagen.
    - $width = El ancho de la imagen.
    - $height = El alto de la imagen.
    - $limit_size = El límite de espacio que se puede permitir en la imagen.
*/
function upload_image($file = NULL, $file_prefix_name = '', $route_to_save = NULL, $width = 512, $height = 512, $limit_size = 2097152){
    //We get the file image properties
    $file_size = $file->getSize();
    $file_extension = $file->getClientExtension();
    $file_info = \Config\Services::image()
                                 ->withFile($file)
                                 ->getFile()
                                 ->getProperties(true);

    //We asign a name for the file, if we want a random name, the file_prefix_name must to be ''
    if($file_prefix_name == ''){
        $file_name = (hash("sha256",time())).'.'.$file_extension;
    }//end if doesn't exists prefix and have to give him a default prefix
    else{
        $file_name = $file_prefix_name.'.'.$file_extension;
    }//end else doesn't exists prefix and have to give him a default prefix

    //Verify if the file exists, if exists only add an sufix _1
    if(file_exists($route_to_save.'/'.$file_name)){
        if($file_prefix_name == ''){
            $file_name = (hash("sha256",time())).'_1.'.$file_extension;
        }//end if doesn't exists prefix and have to give him a default prefix
        else{
            $file_name = $file_prefix_name.'_1.'.$file_extension;
        }//end else doesn't exists prefix and have to give him a default prefix
    }//end if file exists

    //We verify the properties of image, if are the dimension and size that we want
    if(verify_image($file_size, $file_extension, $file_info, $width, $height, $limit_size)){
        $file->move($route_to_save, $file_name);
        return $file_name;
    }//end if the image satisfy our requirements
    else{
        return NULL;
    }//end else the image satisfy our requirements
}//end upload_image

/*
Esta función sirve para verificar que la imagen cumpla con nuestros criterios.
La función se encarga de verificar si una imagen cumple con las dimensiones deseadas y el tamaño límite, sólo se aceptan png y jpg
    - $file_size = El tamaño del archivo, es obtenido con las propiedades del archivo en la función upload_image.
    - $file_extension = La extensión del archivo, igual obtenido en la función upload_image.
    - $file_info = La información de la imagen, para obtener el width y el height de la misma.
    - $width = El ancho de la imagen.
    - $height = El alto de la imagen.
    - $limit_size = El límite de espacio que se puede permitir en la imagen.
*/
function verify_image($file_size = NULL, $file_extension = NULL, $file_info = NULL, $width = 0, $height = 0, $limit_size = 0){
    if($file_size <= $limit_size && ($file_extension == 'jpeg' || $file_extension == 'jpg' || $file_extension == 'png') &&
       $file_info['width'] <= $width && $file_info['height'] <= $height){
        return TRUE;
    }//end if the image pass
    else{
        return FALSE;
    }//end else the image pass
}//end verify_image

// *****************************************************************************
// ************************** FUNCIONES PARA ARCHIVOS **************************
// *****************************************************************************

/*
Esta función sirve para cargar un archivo, es dependiente de la función verify_file.
La función se encarga de subir el archivo a una ruta puesta con un prefijo de archivo, los parámetros son los siguientes:
    - $file = El archivo a cargar, obtenido por un input file.
    - $file_prefix_name = El prefijo que gustemos que tenga el archivo, si no queremos uno simplemente se usará el default encriptado.
    - $route_to_save = La ruta en la que irá la imagen.
    - $allowed_extension = La extensión que se permitirá para el archivo.
    - $limit_size = El límite de espacio que se puede permitir en el archivo.
*/
function upload_file($file = NULL, $file_prefix_name = '', $route_to_save = NULL, $allowed_extension = NULL, $limit_size = 2097152){
    //We get the file properties
    $file_size = $file->getSize();
    $file_extension = $file->getClientExtension();

    //We asign a name for the file, if we want a random name, the file_prefix_name must to be ''
    if($file_prefix_name == ''){
        $file_name = (hash("sha256",time())).'.'.$file_extension;
    }//end if doesn't exists prefix and have to give him a default prefix
    else{
        $file_name = $file_prefix_name.'.'.$file_extension;
    }//end else doesn't exists prefix and have to give him a default prefix

    //Verify if the file exists, if exists only add an sufix _1
    if(file_exists($route_to_save.'/'.$file_name)){
        if($file_prefix_name == ''){
            $file_name = (hash("sha256",time())).'_1.'.$file_extension;
        }//end if doesn't exists prefix and have to give him a default prefix
        else{
            $file_name = $file_prefix_name.'_1.'.$file_extension;
        }//end else doesn't exists prefix and have to give him a default prefix
    }//end if file exists

    //We verify the properties of image, if are the size that we want
    if(verify_file($file_size, $file_extension, $limit_size, $allowed_extension)){
        $file->move($route_to_save, $file_name);
        return $file_name;
    }//end if the file satisfy our requirements
    else{
        return NULL;
    }//end else the file satisfy our requirements
}//end upload_file

/*
Esta función sirve para verificar que la imagen cumpla con nuestros criterios.
La función se encarga de verificar si una imagen cumple con las dimensiones deseadas y el tamaño límite, sólo se aceptan png y jpg
    - $file_size = El tamaño del archivo, es obtenido con las propiedades del archivo en la función upload_image.
    - $file_extension = La extensión del archivo, igual obtenido en la función upload_image.
    - $limit_size = El límite de espacio que se puede permitir en la imagen.
    - $allowed_extension = La extensión que se permitirá para el archivo.
*/
function verify_file($file_size = NULL, $file_extension = NULL, $limit_size = 0, $allowed_extension = NULL){
    if($file_size <= $limit_size && ($file_extension == 'pdf' || $file_extension == 'xlsx' || $file_extension == 'docx')){
        if($file_extension == $allowed_extension)
            return TRUE;
        else
            return FALSE;
    }//end if the file pass
    else{
        return FALSE;
    }//end else the file pass
}//end verify_file



// *****************************************************************************
// ***************************** FUNCIONES GENERALES ***************************
// *****************************************************************************
function erase_file($file_name = NULL, $route = NULL){
    if(file_exists($route.'/'.$file_name)){
        unlink($route.'/'.$file_name);
        return TRUE;
    }//end if exists the file for erase it
    else{
        return FALSE;
    }//end else exists the file for erase it
}//end erase_file

function rename_file($old_file_name = NULL, $new_file_name = NULL, $route = NULL){
    if(file_exists($route.'/'.$old_file_name)){
        rename($route.'/'.$old_file_name, $route.'/'.$new_file_name);
        return TRUE;
    }//end if exists the file for rename it
    else{
        return FALSE;
    }//end else exists the file for rename it
}//end rename_file
