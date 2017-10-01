<?php
//**************************************************************
//
// Archivo de cabecera para la administracion de la
// configuracion local
// V. 1.0
//
// Ing. Edwin Agudelo
// 2014
//
//***************************************************************
class CConfigura{
    private $ruta_conf; // Ruta de configuracion
    private $habilitado; // Flag de habilitacion
    private $motor; // Motor de la BD
    private $dbUser; // Usuario de BD
    private $dbPass; // Contrasena de la BD
    private $dbHost; // Host de la BD
    private $dbPort; // Puerto de la BD
    private $dbName; // Nombre de la BD
    private $dbConn; // Cadena de conexion de la BD
    
    function __construct( $rutaIni ){
        $this->ruta_conf = $rutaIni;
        $archivo = file($this->ruta_conf) or die('No se tiene acceso al archivo ' . $rutaIni);
        foreach ($archivo as $linea ) {
            if(preg_match('/^#/', $linea)){
                continue;
            }
            if(preg_match('/^\n/', $linea)){
                continue;
            }
            $llave_valor = explode(' ', $linea);
            if(preg_match('/^DBSYS$/', $llave_valor[0])){
                $this->motor = $llave_valor[1];
                //echo 'Set Motor ' . $this->motor . '<br/>';
                continue;
            }
            if(preg_match('/^ENABLE$/', $llave_valor[0])){
                $this->habilitado = $llave_valor[1];
                //echo 'Set Habilitado ' . $this->motor . '<br/>';
                continue;
            }
            if(preg_match('/^DBUSER$/', $llave_valor[0])){
                $this->dbUser = $llave_valor[1];
                continue;
            }
            if(preg_match('/^DBPASS$/', $llave_valor[0])){
                $this->dbPass = $llave_valor[1];
                continue;
            }
            if(preg_match('/^DBHOST$/', $llave_valor[0])){
                $this->dbHost = $llave_valor[1];
                continue;
            }
            if(preg_match('/^DBPORT$/', $llave_valor[0])){
                $this->dbPort = $llave_valor[1];
                continue;
            }
            if(preg_match('/^DBNAME$/', $llave_valor[0])){
                $this->dbName = $llave_valor[1];
                continue;
            }
            if(preg_match('/^DBCONN$/', $llave_valor[0])){
                $this->dbConn = $llave_valor[1];
                continue;
            }
            //echo $linea . '<br/>';
        }
    }
    
    // Funciones publicas
    
    // Ruta de configuracion
    public function getRutaCfg(){
        return $this->ruta_conf;
    }
    
    // Flag de habilitacion
    public function getHabilitado(){
        return $this->habilitado;
    }
    
    // Motor de datos
    public function getDbSys(){
        return $this->motor;
    }
    
    // Usuario de BD
    public function getDbUser(){
        return $this->dbUser;
    }
    
    // Contrasena de BD
    public function getDbPass(){
        return $this->dbPass;
    }
    
    // Nombre de BD
    public function getDbName(){
        return $this->dbName;
    }
    
    // Host de BD
    public function getDbHost(){
        return $this->dbHost;
    }
    
    // Puerto de la BD
    public function getDbPort(){
        return $this->dbPort;
    }
    
    // Cadena de conexion de la BD
    public function getDbConn(){
        return $this->dbConn;
    }
}
?>