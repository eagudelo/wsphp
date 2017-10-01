<?php
    
    /* Web Service de prueba y configuraciones
     * 
     * Expone un procedimiento para retornar una configuracion 
     * especifada en el parametro.
     * 
     * Ing. Edwin A. Agudelo G.
     * Soluciones Buenas Ideas.
     * Colombia.
     * 2014.
     *  
     * */
    
    include('../negocio/PgConsultas.php');
    require_once('../utiles/lib/nusoap.php');
    $URL       = "WSBI_Configuracion.php";
    $namespace = $URL . '?wsdl';
    
    // Creo el servidor 
    $server = new soap_server;
    $server->configureWSDL('Configuracion', $namespace);
    
    $server->register('getMensaje', array("name" => "xsd:string"),array("return" => "xsd:string"),$namespace);
    $server->register('getParamSBI', array("param_name" => "xsd:string"),array("return" => "xsd:string"),$namespace);
    $server->register('getDateSBI', array("name" => "xsd:string"),array("return" => "xsd:string"),$namespace);
    $server->register('createKey', array("mac" => "xsd:string", "osuser" => "xsd:string", "machine" => "xsd:string"),array("return" => "xsd:string"),$namespace);
    $server->register('validKey', array("client" => "xsd:string"),array("return" => "xsd:string"),$namespace);
    $server->register('createKey2', array("mac" => "xsd:string", "osuser" => "xsd:string", "machine" => "xsd:string", "version" => "xsd:string"),array("return" => "xsd:string"),$namespace);
    $server->register('validKey2', array("client" => "xsd:string", "version" => "xsd:string"),array("return" => "xsd:string"),$namespace);
    $server->register('summaryReg', array("client" => "xsd:string", "partner" => "xsd:string", "value" => "xsd:string"),array("return" => "xsd:string"),$namespace);
    
    // Funcion expuesta
    function getMensaje($your_name){
        if(!$your_name){
            return new soap_fault('Cliente', '', 'Ponga su nombre!!!');
        }
        return "Bienvenido a los servicios web de sbi, " . $your_name . ".\nGracias por usar nuestros servicios.";
    }
    
    function getParamSBI($param_name){
        if(!$param_name){
            return new soap_fault('SBI WS', 'Error', '-1');
        }
        // Armo la salida
        //$retorno = "Ok En " . gethostname();
        $consulta = new CPgConsultas();
        $retorno = $consulta->consultaParametro($param_name);
        return $retorno;
    }

    function getDateSBI($param_name){
        if(!$param_name){
            return new soap_fault('SBI WS', 'Error', '-1');
        }
        // Armo la salida
        //$retorno = "Ok En " . gethostname();
        $consulta = new CPgConsultas();
        $retorno = $consulta->sbiLlamaFecha();
        return $retorno;
    }
    
    function createKey($mac, $osuser, $machine){
        $retorno = 0;
        $consulta = new CPgConsultas();
        $retorno = $consulta->crearLlave($mac, $osuser, $machine);
        return $retorno;        
    }
    
    function validKey($clientKey){
        $retorno = 0;
        $ipcliente = $_SERVER['REMOTE_ADDR'];
        $consulta = new CPgConsultas();
        $retorno = $consulta->validaLlave($clientKey);
        $consulta->registraVal($retorno, $ipcliente);
        return $retorno;
    }
    
    function createKey2($mac, $osuser, $machine, $version){
        $retorno = 0;
        $consulta = new CPgConsultas();
        $retorno = $consulta->crearLlave2($mac, $osuser, $machine, $version);
        return $retorno;        
    }
    
    function validKey2($clientKey, $version){
        $retorno = 0;
        $ipcliente = $_SERVER['REMOTE_ADDR'];
        $consulta = new CPgConsultas();
        $retorno = $consulta->validaLlave2($clientKey, $version);
        $consulta->registraVal($retorno, $ipcliente);
        return $retorno;
    }
    
    function summaryReg($client, $partner, $value){
        $retorno = 0;
        $consulta = new CPgConsultas();
        $retorno = $consulta->registraResumen($client, $partner, $value);
        return $retorno;
    }
    
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    
    // Creo el escucha HTTP
    $server->service($HTTP_RAW_POST_DATA);
    
    exit();
    
?>
