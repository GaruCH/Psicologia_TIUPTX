<?php

// *****************************************************************************
// **************************** FUNCIONES ESPECIALES ***************************
// *****************************************************************************

//Funcion para establecer el horario en México
date_default_timezone_set("America/Mexico_City");

//Establece el idioma en español méxicano
setlocale(LC_ALL, 'es_MX.UTF-8', "es_MX", 'esp');

function set_dafault_date_and_time() {
    return date('I'); 
}//end set_dafault_date_and_time

// =======================================================
// Función para obtener la fecha actual en formato
// "0000-00-00 00:00:00"
// =======================================================
function list_year($start = 0, $end = 0){
    $year_list = array();
    if ($start != 0 && $end != 0) {
        for ($i = $start; $i < $end; $i++) { 
            $year_list[$i] = $start++;
        }//end for 
    }//end if 
    return $year_list;
}//end list_year

// =======================================================
// Función para obtener la fecha actual en formato
// "0000-00-00 00:00:00"
// =======================================================
function fecha_actual(){
    $horarioVerano = set_dafault_date_and_time();
    return ($horarioVerano == TRUE) ? date('Y-m-d H:i:s', strtotime('-1 hour')) : date('Y-m-d H:i:s') ;
}//end fecha_actual

// =======================================================
// Función para obtener la fecha actual en formato
// "0000-00-00"
// =======================================================
function fecha_actual_y_m_d(){
    return date('Y-m-d');
}//end fecha_actual

// =======================================================
// Función para obtener la fecha actual en formato
// "00:00:00"
// =======================================================
function hora_actual(){
    $horarioVerano = set_dafault_date_and_time();
    return ($horarioVerano == TRUE) ? date('H:i:s', strtotime('-1 hour')) : date('H:i:s') ;
}//end hora_actual

// =======================================================
// Función para obtener y formatear hora_fecha
// Fecha 0000-00-00
// dia de mes de anio"
// 
// Hora 00:00:00
// 00:00 
// =======================================================
function formatear_hora_y_fecha($fecha = "0000-00-00", $hora = "00:00:00") {
    if($fecha == "0000-00-00" || $hora == "00:00:00"){
        $fecha_formateada = array( 
                                    'fecha' => 'La fecha aún no es asignada.',
                                    'hora' => 'La hora aún no es asignada.'
                                );
    }//end if 
    else{    
        $fecha_formateada = array( 
                                    'fecha' => strftime("%d de %B de %Y", strtotime($fecha)), //Genera la fecha en string
                                    'hora' => strftime("%I:%M", strtotime($hora))//Genera la hora
                                );
    }//end else
    return $fecha_formateada;
}//end formatear_hora_y_fecha

// =======================================================
// Función para darle formato a una fecha de tipo
// "Domingo 00 de Enero de 0000"
// =======================================================
function formatear_fecha($fecha){
    if($fecha != ''){
        $partes = explode("-",$fecha);
        if(checkdate($partes[1], $partes[2], $partes[0])){
            $semana = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
            $mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
            preg_match("/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $fecha);
            $f = mktime(0,0,0, $fecha[2], $fecha[3], $fecha[1]);
            return $semana[date('w', $f)].', '.date('d', $f).' de '.$mes[date('m', $f)-1].' de '.date('Y', $f);
        }
        else{
            return "Fecha por definir";
        }
    }
    else{
        return "Fecha invalida";
    }
}//end formatear_fecha

// =======================================================
// Función para convertir un arreglo[] a un arreglo object
// =======================================================
function convert_array_to_stdlclass($arreglo){
    $object = new stdClass();
    foreach ($arreglo as $key => $value) {
        if (is_array($value)) {
            $value = convert_array_to_stdlclass($value);
        }//End if
        $object->$key = $value;
    }//End foreach
    return $object;
}//end convert_array_to_stdlclass

// ================================================
// Función para convertir un arreglo object
// a un arreglo[]
// ================================================
function covert_stdlclass_to_array($arreglo){
    $array = (array)$arreglo;
    foreach($array as $key => &$field){
        if(is_object($field))$field = covert_stdlclass_to_array($field);
    }//End foreach
    return $array;
}//End covert_stdlclass_to_array



// *****************************************************************************
// *************************** FUNCIONES PRIMORDIALES **************************
// *****************************************************************************

function enviar_correo_individual($user_from = '', $alias_from = '', $user_to = '', $subject = '', $message = NULL, $files = NULL){
    $email = \Config\Services::email();
    $email->setFrom($user_from, $alias_from);
    $email->setTo($user_to);
    $email->setSubject($subject);
    $email->setMessage($message);

    if($files != NULL){
        foreach ($files as $file) {
            $email->attach($file);
        }//end foreach archivos
    }//end if se deben enviar archivos

    if ($email->send()) {
        // echo 'Email successfully sent';
        return TRUE;
    }//end if mail
    else{
        // $data = $email->printDebugger(['headers']);
        // print_r($data);
        return FALSE;
    }//end else
}//end enviar_correo_individual

/*
    Esta función ayudará a generar la clave de recuperación de un usuario, siendo una clave única generada de manera automática
    de manera que se genera con la fecha y hora actual, para posteriormente encriptar este token con el hash.
*/
function generar_clave_recuperacion_password(){
    $clave_recuperacion_password = substr(hash("sha256",time()), 0, -52);
    return $clave_recuperacion_password;
}//end generar_clave_recuperacion_password

// ================================================
// Función para generar numero consecutivo
// con 0000 digitos
//$inicio = numero donde empezara a contar
//$contador = cuantos numeros va a tomar en cuenta para la sucesion
//$digitos = cuantos digitos se van a mostrar ejm: 0000, 0001, 0002
// ================================================
function digito_consecutivo($inicio, $contador, $digitos) {
    $resultado = array();
    for ($i = $inicio; $i < $inicio + $contador; $i++) {
        $resultado[] = str_pad($i, $digitos, "0", STR_PAD_LEFT);
    }//End for
    return $resultado[0];
}//End digito_consecutivo

function calcular_edad_persona($fecha_persona = NULL) {
    $current_date = strtotime(fecha_actual_y_m_d());
    $year_current = date('Y',$current_date);
    $data_date = strtotime($fecha_persona);
    $year = date('Y',$data_date);
    return ($fecha_persona != NULL) ? ($year_current - $year) : NULL ;
}//end calcular_edad_persona

function folio_sistema_persona($constant = 0, $folio_actual = '', $status = -1 , $year = 0000) {
    $folio = '';
    $current_date = strtotime(fecha_actual_y_m_d());
    $year_current = date('Y',$current_date);
    /**
        $explode = 0000_CONST_0000
        $explode[0] = 2023
        $explode[1] = VIC
        $explode[2] = 0000
    */
    $explode = explode("_", $folio_actual);
    $number = (int)$explode[2];
    //===============
    // To check if it's same year
    //===============
    if($status != -1 ){
        if($year_current == $explode[0]){
            $digit = digito_consecutivo(++$number, 1, 4);
            $folio = $year_current.'_'.$constant.'_'.$digit;
        }//end $year_current
        else{
            $digit = digito_consecutivo(0, 1, 4);
            $folio = $year_current.'_'.$constant.'_'.$digit;
        }//end else
    }//end if
    else{
        if($year == $explode[0]){
            $digit = digito_consecutivo(++$number, 1, 4);
            $folio = $year.'_'.$constant.'_'.$digit;
        }//end $year_current
        else{
            $digit = digito_consecutivo(0, 1, 4);
            $folio = $year.'_'.$constant.'_'.$digit;
        }//end else
    }//end else
    return $folio;
}//end folio_sistema_persona

function separador_string($tring = '', $explode = '') {
    $exp = explode($explode, $tring);
    if (count($exp) > 0) {
        return $exp;
    }//end if count
    return '';
}//end separador_string
