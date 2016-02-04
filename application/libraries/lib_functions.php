<?php if(! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php	
	/**
	* 
	*/
	class lib_functions{
		
		

		private static $CI = NULL;

    public function __construct(){
        self::$CI = &get_instance();

    }


		public function clean_session(){
			 self::$CI->load->library('session');

			$array_items = array('session_id' =>'' ,
							'ip_address'=>'',
							'user_agent'=>'',
							'last_activity'=>'',
							'nombreusuario' =>'',
							'impresion_Nombre'=>'',
							'impresion_Ciudad' =>'',
							 'impresion_Direccion' =>'',
							 'impresion_Telefono' =>'',
							 'impresion_Fax' =>'');
			//self::$CI->session->unset_userdata($array_items);
			self::$CI->session->sess_destroy($array_items);
		}
	}
?>