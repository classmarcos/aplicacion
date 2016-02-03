<?php
	class PointAddress extends CI_controller{

		public function __construct(){
			parent::__construct();
			$this->load->library('lib_check_user');
			$this->load->model('mdl_point_address');
		}

		public function index(){

			$this->lib_check_user->isSession(true,'PointAddress/');
			if(!$this->lib_check_user->valida_perfil()) redirect('/checkUser/index','refresh');

			$codigo = $this->mdl_point_address->select_estafetas();

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
		                "jquery-2.11.0.min",
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
			$this->load->view('config/estafeta', array('codigos' => $codigos ));
			$this->load->view('ht/footer');
		}

		public function consult_estafeta(){
			$user_logged = $this->lib_check_user->isSession(true);
			$parametro =($this->input->post('id') ? $this->input->post('id') : 0);

			$json_a = $this->mdl_point_address-> select_estafetas($parametro) ->resultado;

			if($parametro !==null){
				echo json_encode($json_a);
				return;
			}
		}

		public function data(){
			return;
			$user_logged = $this->lib_check_user->isSession(true);
			$page = $this->input->post('page') ? $this->input->post('page') :1;

			$rp = $this->input->post('rows') ? $this->input->post('rows') :50;
			$sortname = $this->input->post('sidx') ? $this->input->post('sidx') :'';
			$sortorder = $this->input->post('sord') ? $this->input->post('sord') :'DESC';
			$limit = $rp * $page - $rp;
			$offset = $rp;

			$parametro = ($this->input->post('parametro') ? $his->input->post('parametro'):null);
			$json_a = $this->mdl_point_address->select_estafetas($parametro)->resultado;

			if($parametro !==nul){
				echo json_encode($json_a);
				return;
			}

			 $filter = array();
	        $totalRecords   = count($json_a);
	        $results        = $json_a; 
	        $totalPages     = ceil($totalRecords / $rp);

	        $json_output = array(
	            'total'     => $totalPages,
	            'page'      => $page,
	            'records'   => $totalRecords,
	            'rows'      => $results,
	            'user_logged' => $user_logged
	        );
	        
	       echo json_encode($json_output);
		}

		public function json($data=array()){
			$this->output->set_content_type('application/json')
				->set_output(json_encode($data));

		}
	}
?>