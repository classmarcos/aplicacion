<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mdl_point_address extends CI_Model {

    public function __construct() {
        parent::__construct();
    }



    public function select_estafetas($parametro= NULL){

        if($this->session->userdata('idusuario') === NULL){
            return;
        }

        $url = 'http://192.168.10.147:8080/Clientela/db_ODC.php';
        $data = array('tipo' => "82", 'codigo' => $this->session->userdata('idusuario'), 'parametro' => $parametro);

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($data)
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $json_a = json_decode($result);

        /*
        |::TODO Fix Bajaviano para el codigo 0
        |Cuando mandas 0 trae todos los resultados de la base de datos ERROR A CORREGIR GRAVE
        | Parece ser el metodo de mandar datos
        */

        if ($parametro === 0 ) {
            $json_a->resultado =  array($json_a->resultado[0]);
        }


        return $json_a;
    }

}