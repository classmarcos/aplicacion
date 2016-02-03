<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class lib_check_user{

    private static $CI = NULL;

    public function __construct(){
        self::$CI = &get_instance();
    }


    public function isSession($user_out = false,$from_url = null, $redirect_url = null){
        self::$CI->load->library('session');

        if (self::$CI->session->userdata('idusuario') && self::$CI->session->userdata('ip_address')) {
            return TRUE;
        }else{

            if($user_out){
                if($from_url != null){

                    $cookie = array(
                        'name'   => 'redirect',
                        'value'  =>  $from_url,
                        'expire' => '120', //2 minutos para borrar
                        'prefix' => 'telenordci_',
                        'path'   => '/',
                        'secure' => false
                    );

                    self::$CI->input->set_cookie($cookie);
                }
                redirect($redirect_url ? $redirect_url : base_url(), 'refresh');

            }

            return FALSE;

        }

    }

    public function valida_perfil(){
        self::$CI->load->library('session');
        if (self::$CI->session->userdata('perfilusuario') && self::$CI->session->userdata('perfilusuario') === "1") {
            return TRUE;
        } else {
            return FALSE;
        }
    }




}