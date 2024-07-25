<?php namespace App\Models;

use CodeIgniter\Model;

class Cargar_db extends Model{
    protected $table = 'configuraciones';

    public function config_first_time($dbname = NULL, $username = NULL, $password = NULL){
        $connect = mysqli_connect('localhost','root','');
        if(!$connect){
            die('Error al conectarse con el servidor ' .mysql_error());
        }//End if
        else{
            //Declaración de variables
            $bd = $dbname;
            $user = $username;
            $password = $password;
            //Sintaxis sql
            $sql_bd = "CREATE DATABASE IF NOT EXISTS ".$bd." DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $sql_user = "GRANT ALL PRIVILEGES ON ".$bd.".* TO '".$user."'@'localhost' IDENTIFIED BY '".$password."'";
            //Creación de la base de datos
            if (mysqli_query($connect, $sql_bd)) {
                echo "La base de datos <b>".$bd."</b> se creó correctamente<br>";
            }//end if logra crear la bd
            else {
                echo 'Error al crear la base de datos' . mysql_error() . "<br>";
            }//end else
            //Creación del usuario y privilegios para el mismo
            if (mysqli_query($connect,$sql_user)) {
                echo "El usuario <b>".$user."</b> se creó correctamente con el password <b>".$password."</b><br><br>";
            }//end if logra crear el user
            else {
                echo 'Error al crear el usuario ' . mysql_error() . "<br>";
            }//end else
        }//end else
    }//end config_first_time

    public function importar($dbname = NULL){
        $query = '';
        $path = FCPATH.'../recursos/bd/'.$dbname.'_original.sql';
        if(file_exists($path)) {
		    $sqlScript = file( FCPATH.'../recursos/bd/'.$dbname.'_original.sql');
            foreach($sqlScript as $line){
                $startWith = substr(trim($line), 0 ,2);
    	        $endWith = substr(trim($line), -1 ,1);

                if(empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
                    continue;
    	        }//end if líneas de comentarios

                $query = $query . $line;
                if($endWith == ';') {
                    if(!$this->simpleQuery($query)){
                        echo '<div class="">Hubo un problema al ejecutar el SQL Query: <b>' . $query. '</b></div>';
                    }//end if error al ejecutar query
                    $query= '';
    	        }//end if fin línea de query
            }//end foreach
            echo '<div class="">Se ha importado exitosamente el archivo base de la DB. Puedes Continuar :D</div>';
        }//end if el archivo base existe
        else {
            echo '<div class="">Error! No se encuentra el archivo de la BD, verifica el nombre del archivo o su existencia.</div>';
        }//end if no existe el archivo db
    }//end importar

}//End Model Cargar_db
