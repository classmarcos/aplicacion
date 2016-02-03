<?php
	class PointAddress extends CI_controller{

		public function __construct(){
			parent::__construct();
			$this->load->library('lib_check_user');
			$this->load->model('mdl_pointaddress');
		}

		public function index(){

			$this->lib_check_user->isSession(true,'PointAddress');
			if(!$this->lib_check_user->valida_perfil()) redirect('/checkUser/index','refresh');

			$codigo = $this->mdl_pointaddress->select_estafetas();

			$this->load->view('hf/header', array(
		            'precss' => array(
		                //"http://fonts.googleapis.com/css?family=Sonsie+One"
		                    ),
		            'css' => array(
		                "bootstrap/bootstrap",
		                "config/estafeta",
		                "comun"
		                ),

		            'js' => array(
		                "jquery-1.11.0.min",
		                "bootstrap/bootstrap.min",
		                "jquery.cookie",
                		"elementos_js",
                		"config/estafeta"
		                ),
		            
		            'prejs' => array(
		                ),
		            'title' => "Estafetas",
		            'usuario' => $this->session->userdata('nombreusuario')
		            )
			);
			$this->load->view('config/estafeta')
		}
	}
?>