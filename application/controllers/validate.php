<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validate extends  CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function form_login(){

        $this->load->helper('form');
        $this->load->library('form_validation');

        //form_validation: Libreria interna de codeigniter para la validacion de formularios
        $this->form_validation->set_error_delimiters('<p class="error">');
        $this->form_validation->set_rules('InputUsuario', 'Nombre Usuario', 'required');
        $this->form_validation->set_rules('InputPassword','Contraseña', 'required');

        //Si no se procesa la validacion se carga el form login
        if($this->form_validation->run() == FALSE){
            $this->load->view('form_login');
        }else{

            $this->load->model(array('mdl_user_validate','mdl_point_address'));
            $this->load->helper('security');

            //Enviamos datos de usuario para verificar si es valido
            $resultado = $this->mdl_user_validate->validate_user(array(

                'usuario' => $this->input->post('InputUsuario') ? $this->input->post('InputUsuario') : "0",
                'contrasena' => $this->input->post('InputPassword') ? $this->input->post('InputPassword') : "0"

            ))["resultado"][0]["result"];

            /*$result = "1007;1"*/

            if(!isset($resultado)){
                $this->load->view('from_login',array('mensaje' => 'Usuario/Contraseña Incorrectos'));
            }else{
                //Si Usuario es valido delimito por ; cada elemento
                $resultado = explode(";",$resultado);

                if($resultado[0] > 0){

                    $parametro = $this->input->post('parametro') ? $this->input->post('parametro') : -1;
                    $hoja = $this->input->post('hoja') ? $this->input('hoja') : -1;


                    /*
                        |::BAJAVIA
                        |El input cuando llega cero lo esta tomando como falso no como un valor numerico el codigo de abajo fue un force para normalizar los valores
                     */

                    if($this->input->post('parametro') === "0"){
                        $parametro = "0";
                    }

                    if($this->input->post('hoja') === "0"){
                        $hoja = "0";
                    }


                    if($parametro > -1){

                        $json_a = $this->mdl_puntodireccion->select_estafetas($parametro)->resultado[0];
                        $this->session->set_userdate(array(
                            'perfilusuario'       => $resultado[1],
                            'idusuario'           => $resultado[0],
                            'nombreusuario'       => $this->input->post('InputUsuario'),
                            'impresion_Nombre'    => $json_a->Nombre,
                            'impresion_Ciudad'    => $json_a->Ciudad,
                            'impresion_Direccion' => $json_a->Direccion,
                            'impresion_Telefono'  => $json_a->Telefono,
                            'impresion_Fax'       => $json_a->Fax


                        ));
                    }else{
                        $this->session->set_userdata(array(
                            'perfilusuario' => $resultado[1],
                            'idusuario'     => $resultado[0],
                            'nombreusuario' => $this->input->post('InputUsuario')
                        ));
                    }



                    if ((!isset($parametro) || $parametro < 0 || !isset($hoja) || $hoja < 0) &&  $resultado[1] == 1){redirect('PointAddress/', 'refresh');}

                    elseif ((!isset($parametro) || $parametro < 0 || !isset($hoja) || $hoja < 0) &&  $resultado[1] != 1) {
                        $this->load->view('formulario_ejemplo', array( 'mensaje' => 'Esta cuenta en esta computadora necesita ser configurada por un Super usuario'));
                    } elseif (isset($parametro) && $parametro > -1 && isset($hoja) && $hoja > -1) {
                        redirect('/CheckUser/index' , 'refresh');
                    }
                }

            }



        }

    }


}