<?php
//**************************************************************
//
// Archivo de cabecera para la conexion a una BD 
// V. 2.0
//
// Ing. Edwin Agudelo
// 2014
//
//***************************************************************

include 'configuracion.php';

class CConexionBD{
    
    protected $link;
    protected $motor; // Motor de la BD
    protected $dbUser; // Usuario de BD
    protected $dbPass; // Contrasena de la BD
    protected $dbHost; // Host de la BD
    protected $dbPort; // Puerto de la BD
    protected $dbName; // Nombre de la BD
    protected $dbConn; // Cadena de conexion de la BD
    
    // Constructor
    public function __construct( $objCfg ){
        $this->motor = $objCfg->getDbSys();
        $this->dbUser = $objCfg->getDbUser();
        $this->dbPass = $objCfg->getDbPass();
        $this->dbHost = $objCfg->getDbHost();
        $this->dbPort = $objCfg->getDbPort();
        $this->dbName = $objCfg->getDbName(); 
    }
    
    public function Parametrizar( $objCfg ){
        $this->motor = $objCfg->getDbSys();
        $this->dbUser = $objCfg->getDbUser();
        $this->dbPass = $objCfg->getDbPass();
        $this->dbHost = $objCfg->getDbHost();
        $this->dbPort = $objCfg->getDbPort();
        $this->dbName = $objCfg->getDbName(); 
    }
    
    /*private function armarConexion(){
        
    }
    
    public function Conectarse(){
            // Ahora intento conectarme
            //$link= pg_connect("host=localhost dbname=adsl1 user=root") or die("Error conectando a la BD: " . pg_last_error($link));
            $link= pg_connect("host=localhost dbname=adsl1 user=postgres password=luisa") or die("Error conectando a la BD: " . pg_last_error($link));
            // Seleccionamos la BD
            return $link;
    }
    
    public function Desconectarse($link){
    	pg_close($link);
    	return;
    }*/
}


?>
