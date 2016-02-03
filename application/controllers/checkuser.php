<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CheckUser extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this-> load-> library('');
		$this -> load -> model('');
	}

	public function index(){
		//$this-> ->

		$this->load->helper('form');
		$this->load->view('ht/header',array(
			'precss' => array(
				),
			'css' => array(
				"comun",
				"busquedacliente/busquedacliente",
				"bootstrap/bootstrap",
				"dt.min"),
			'js'=> array(
				"jquery-1.11.0.min",
				"header",
				"principal",
				"bootstrap/bootstrap.min",
				"dt.min"),
			)
			'usuario' => $this ->session -> userdate('nombreusuario');
		);

		$this -> load -> view('principal');
		$this -> load -> view('hf/footer');
	}

	public function data(){
		//$user_logged=$this->;

		$parameter = ($this-> input->post('searchString')? $this->input->post('searchString') : NULL);
		$json_a = $this -> mdl_clients->get_user_data($parameter);

		$filter = array();
		$totalRecords = count($json_a['resultado']);
		$results = json_a['resultado'];

		$json_output = array('records' =>$totalRecords , 'rows'=>$results,'user_logged'=>$user_logged);

		echo json_encode($json_output);

	}

	public function redireccionando($parameter=''){
		preg_match("/^[a-zA-Z][0-9]{7}[a-zA-Z]$/", $parameter,$output_array);

		if(empty($output_array[0])){
			echo '<button type="button" onClick="window.location.href=\'' . site_url() . '/busquedacliente/index\'">Regresar</button>';
			echo $parameter." Es un dato invalido";
			return;
		}

		//$this-> -> ();
		$this->load->view('redireccionando', array('parameter' =>$parameter ));
	}
}