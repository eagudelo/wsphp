<?php
    /*
     * PgConexion.php
     * 
     * Clase que extiende la conexion. Busca conectarse a un motor en POSTGRESQL
     * 
     * Ing. Edwin A. Agudelo G.
     * Soluciones Buenas Ideas.
     * Colombia.
     * 2014.
     * 
     *  */
    
    include('conexion.php');
    
    class PgConexion extends CConexionBD{
        // Enlace
        private $pglink;
        private $pgcadena;
        
        // Constructor
        function __construct( $configuracion ){
            if($configuracion){ // Existe la configuracion
                $this->Parametrizar($configuracion);
            }
        }
        
        private function ArmarCadena(){
            $this->pgcadena = "host=". $this->dbHost ." dbname=". $this->dbName ." user=". $this->dbUser ." password=" . $this->dbPass;
        } 
        
        // Se conecta a la BD
        public function Conectarse(){
            $this->ArmarCadena();
            $this->pglink = pg_connect($this->pgcadena);
            if(!$this->pglink){
                echo 'No puede conectarse al motor';
                return -1;
            }
            return 1;
        }
        
        public function Desconectarse(){
            pg_close($this->pglink);
            return;
        }
        
        public function Ejecuta($strsql){
            $this->Conectarse();
            $resultado = pg_query($strsql);
            return $resultado;            
        }
        
        public function TomaEnlace(){
            return $this->pglink;
        }
    }
?>