<?php
    /*
     * MyConexion.php
     * 
     * Clase que extiende la conexion. Busca conectarse a un motor en MYSQL
     * 
     * Ing. Edwin A. Agudelo G.
     * Soluciones Buenas Ideas.
     * Colombia.
     * 2014.
     * 
     *  */
    
    include('conexion.php');
    
    class MyConexion extends CConexionBD{
        // Enlace
        private $mylink;
        
        // Constructor
        function __construct( $configuracion ){
            if($configuracion){ // Existe la configuracion
                $this->Parametrizar($configuracion);
            }
        }
        
        // Se conecta a la BD
        function Conectarse(){
            $this->mylink = mysql_connect($this->dbHost, $this->dbUser, $this->dbPass);
            if(!$this->mylink){
                echo 'No puede conectarse al motor';
                return -1;
            }
            mysql_select_db($this->dbName,$this->mylink);
            return 1;
        }
        
        function Desconectarse(){
            mysql_close($this->mylink);
        }
        
    }
?>