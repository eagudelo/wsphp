<?php
    /*
     * PgConsultas.php
     * 
     * Consultas del negocio para postgresql
     * 
     * Ing. Edwin A. Agudelo G.
     * Soluciones Buenas Ideas.
     * Colombia.
     * 2014.
     * 
     * */
     
     include('../utiles/PgConexion.php');
     //include('../utiles/configuracion.php');
     
     class CPgConsultas{
         
         // Objeto de conexion
         private $connPg;
         private $config;
         
         function __construct(){
             $this->config = new CConfigura('../txt_cfg/configuracion.txt');
             if(!$this->config){
                 echo "No se puede cargar el archivo de configuracion.";
                 return;
             }
             $this->connPg = new PgConexion($this->config);
         }
         
         public function consultaParametro($llave){
             if(!$this->connPg){
                 echo "No se tiene inicializado el objeto";
                 return "-3";
             }
             // Ahora realizo la consulta
             $sqlstr = "Select fn_ret_param('$llave')";
             $this->connPg->Conectarse();
             $resultado = pg_query($sqlstr);
             $retorno = "-4";
             while($fila = pg_fetch_array($resultado,NULL,PGSQL_NUM)){
                 $retorno = $fila[0];
             }
             pg_free_result($resultado);
             $this->connPg->Desconectarse();
             return $retorno;
         }
         
         function sbiLlamaFecha(){
            $retorno = "-1";
            $strsql = "Select current_date";
            $this->connPg->Conectarse();
            $result = pg_query($strsql);
            while($reg = pg_fetch_array($result,NULL,PGSQL_NUM)){
                $retorno = $reg[0];
            }
            //mysqli_free_result($result);
            pg_free_result($result);
            $this->connPg->Desconectarse();
            return $retorno;
        }
        
         function crearLlave($mac, $usuario, $maquina){
            $llave_ret = "";
            $llave = $mac . $maquina;
            // Valido que no exista
            $strsql = "Select ins_llave From instancias Where ins_mac = $1 and ins_usuario = $2 and ins_maquina = $3 and ins_version = 3";
            $this->connPg->Conectarse();
            $sentencia = pg_prepare($this->connPg->TomaEnlace(),"ConsultarLlave",$strsql);

            if($result = pg_execute($this->connPg->TomaEnlace(),"ConsultarLlave",array($mac, $usuario, $maquina))){
                while($fila = pg_fetch_array($result,NULL, PGSQL_NUM)){
                    $llave_ret = $fila[0];
                    break;
                }
            }
            pg_free_result($result);
            //$sentencia->close();
            
            if($llave_ret == ""){
                if(!($sentencia = pg_prepare("CrearLlave","Insert Into instancias(ins_mac, ins_usuario, ins_maquina, ins_llave, ins_version) Values($1 , $2, $3 , md5( $4 ) , 3 )"))){
                    echo "Fallo preparacion 1 > " . pg_errormessage();
                }
                if(!($result = pg_execute("CrearLlave",array($mac,$usuario, $maquina, $llave)))){
                    $llave_ret = "-1:" . pg_errormessage();
                    pg_free_result($result);
                    $this->connPg->Desconectarse();
                    return $llave_ret;
                }
                //$sentencia->close();
                //$sentencia = $this->mylink->prepare("Select ins_llave From instancias Where ins_mac = ? and ins_usuario = ? and ins_maquina = ?");
                if($result = pg_execute("ConsultarLlave",array($mac, $usuario, $maquina))){
                    while($fila = pg_fetch_array($result,NULL, PGSQL_NUM)){
                        $llave_ret = $fila[0];
                        break;
                    }
                }
                pg_free_result($result);
                //$sentencia->close();
            }
            $this->connPg->Desconectarse();
            return $llave_ret;
        }

        function crearLlave2($mac, $usuario, $maquina, $version){
            $llave_ret = "";
            $llave = $mac . $maquina;
            // Valido que no exista
            $strsql = "Select ins_llave From instancias Where ins_mac = $1 and ins_usuario = $2 and ins_maquina = $3 and ins_version = $4";
            $this->connPg->Conectarse();
            $sentencia = pg_prepare($this->connPg->TomaEnlace(),"ConsultarLlave2",$strsql);

            if($result = pg_execute($this->connPg->TomaEnlace(),"ConsultarLlave2",array($mac, $usuario, $maquina, $version))){
                while($fila = pg_fetch_array($result,NULL, PGSQL_NUM)){
                    $llave_ret = $fila[0];
                    break;
                }
            }
            pg_free_result($result);
            //$sentencia->close();
            
            if($llave_ret == ""){
                if(!($sentencia = pg_prepare("CrearLlave2","Insert Into instancias(ins_mac, ins_usuario, ins_maquina, ins_llave, ins_version) Values($1 , $2, $3 , md5( $4 ) , $5 )"))){
                    echo "Fallo preparacion 1 > " . pg_errormessage();
                }
                if(!($result = pg_execute("CrearLlave2",array($mac,$usuario, $maquina, $llave, $version)))){
                    $llave_ret = "-1:" . pg_errormessage();
                    pg_free_result($result);
                    $this->connPg->Desconectarse();
                    return $llave_ret;
                }
                pg_free_result($result);
                if($result = pg_execute("ConsultarLlave2",array($mac, $usuario, $maquina, $version))){
                    while($fila = pg_fetch_array($result,NULL, PGSQL_NUM)){
                        $llave_ret = $fila[0];
                        break;
                    }
                }
                pg_free_result($result);
                //$sentencia->close();
            }
            $this->connPg->Desconectarse();
            return $llave_ret;
        }

         function validaLlave($llave){
            $retorno = 0;
            if($this->consultaParametro("V3") == "0"){
                $retorno = -2;
                return $retorno;
            }
            
            $this->connPg->Conectarse();
            
            $sentencia = pg_prepare("ValidaLlave","Select ins_id From instancias Where ins_llave = $1 and ins_estado = 1");
            
            if(($result = pg_execute("ValidaLlave",array($llave)))){
                while($fila = pg_fetch_array($result,NULL, PGSQL_NUM)){
                    $retorno = $fila[0];
                    break;
                }
            }
            else{
                $retorno = -1;
            }
            $this->connPg->Desconectarse();
            return $retorno;
        }
         
         function validaLlave2($llave, $version){
            $retorno = 0;
            if($this->consultaParametro("V".$version) == "0"){
                $retorno = -2;
                return $retorno;
            }
            $this->connPg->Conectarse();
            $sentencia = pg_prepare("ValidaLlave2","Select ins_id From instancias Where ins_llave = $1 and ins_version = $2 and ins_estado = 1");
            if(($result = pg_execute("ValidaLlave2",array($llave, $version)))){
                while($fila = pg_fetch_array($result,NULL, PGSQL_NUM)){
                    $retorno = $fila[0];
                    break;
                }
            }
            else{
                $retorno = -1;
            }
            $this->connPg->Desconectarse();
            return $retorno;
        }
        
        
        function registraResumen($identi, $distri, $canti){
            $retorno = "0";
            $this->connPg->Conectarse();
            $sentencia = pg_prepare("RegistraResumen","Insert Into resumenes(ins_id, res_cantidad, res_distri) Values($1 , $2 , $3)");
            if(!($result = pg_execute("RegistraResumen",array($identi, $canti, $distri)))){
                $retorno = "-1:" . pg_errormessage();
            }
            else{
                $retorno = "1";
            }
            $this->connPg->Desconectarse();
            return $retorno;
        }
         
         function registraVal($idInstancia, $dirIp){
             $this->connPg->Conectarse();
            if(!($sentencia = pg_prepare("InsVal","Insert Into validaciones(ins_id, val_ip) Values($1,$2)"))){
                echo "Fallo preparacion 1 > " . pg_errormessage();
            }
            if(!($result = pg_execute("InsVal",array($idInstancia, $dirIp)))){
                echo "No se puede ejecutar registro:" . pg_errormessage();
            }
            $this->connPg->Desconectarse();
        }
        
     }
?>