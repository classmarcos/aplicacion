<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class mdl_user_validate extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}

	public function validate_user($datos = array()){
		$datos['contrasena'] = $datos['contrasena'] ? $datos['contrasena'] : "0";
		$datos['usuario'] = $datos['usuario'] ? $datos['usuario'] : "0";
		$url = 'http://';
		$data = array('usuario' =>$datos['usuario'] ,'contrasena'=>$datos['contrasena'] );

		$options = array(
			'http' => array(
				'method' => 'POST', 
				'header'=>'Content-type: application/x-www-form-urlencoded',
				'content' => http_build_query($data)
			) 
		);

		$context = stream_context_create($options);
		$result = file_get_contents($url,false,$context);
		
		$json_a = json_decode($result,true);
		
		var_dump($json_a);

		return $json_a;
	}
}