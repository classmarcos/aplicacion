<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validate extends  CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function form_login(){

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');


        //from_validation: Libreria interna de codeignaiter para la validacion de formularios
        $this->form_validation->set_error_delimiters('<p class="error">');
        $this->form_validation->set_rules('InputUsuario', 'Nombre Usuario', 'required');
        $this->form_validation->set_rules('InputPassword', 'Contraseña', 'required');


        //Si validacion no se cumple Cargamo el mismo form de login
        if ($this->form_validation->run() == FALSE){




// puedes procesar $data explode()
            $this->load->view('form_login');

        } else {

            $this->load->model(array('mdl_user_validate', 'mdl_point_address'));
            $this->load->helper('security');

            //Enviamos datos de usurio para verificar si es valido
            $resultado = $this->mdl_user_validate->validate_user(array(
                'usuario'=> $this->input->post('InputUsuario') ? $this->input->post('InputUsuario') : "0",
                'contrasena'=> $this->input->post('InputPassword') ? do_hash($this->input->post('InputPassword'), 'md5') : "0"
            ))["resultado"][0]["result"];

            /*$resultado = "1001;1";*/

            //Si usuario no es valido en la base de datos retornamos el form login y emitimo mensaje de error
            if (!isset($resultado)) {
                $this->load->view('form_login', array('mensaje' => 'Usuario/Contraseña Incorrectos'));
            } else {
                //Si usuario es valido de limitamo por ; cada elemento del array
                $resultado = explode(";", $resultado); //explode(";", $resultado);//Posicion [0] = ID Posicion [1] = Perfil usuario


                if ($resultado[0] > 0){

                    $parametro = $this->input->post('parametro') ? $this->input->post('parametro') : -1;
                    $hoja = $this->input->post('hoja')  ? $this->input->post('hoja') : -1 ;

                    /*
                    |::BAJAVIA
                    |El input cuando llega cero lo esta tomando como falso no como un valor numerico el codigo de abajo fue un force para normalizar los valores
                    */

                    if ($this->input->post('parametro') === "0") {
                        $parametro = "0";
                    }

                    if ($this->input->post('hoja') === "0" ){
                        $hoja = "0";
                    }

                    if ($parametro > -1) { $json_a = $this->mdl_point_address->select_estafetas($parametro)->resultado[0];
                        $this->session->set_userdata(array(
                            'perfilusuario'       => $resultado[1],
                            'idusuario'           => $resultado[0],
                            'nombreusuario'       => $this->input->post('InputUsuario'),
                            'impresion_Nombre'    => $json_a->Nombre,
                            'impresion_Ciudad'    => $json_a->Ciudad,
                            'impresion_Direccion' => $json_a->Direccion,
                            'impresion_Telefono'  => $json_a->Telefono,
                            'impresion_Fax'       => $json_a->Fax
                        )); } else {
                        $this->session->set_userdata(array(
                            'perfilusuario' => $resultado[1],
                            'idusuario'     => $resultado[0],
                            'nombreusuario' => $this->input->post('InputUsuario')
                        ));
                    }

                    /*
                    | Valida si no esta configurado necesita ser un super usuario para entrar al sistema
                    |
                    */
                    if ((!isset($parametro) || $parametro < 0 || !isset($hoja) || $hoja < 0) &&  $resultado[1] == 1) redirect('pointaddress/', 'refresh');
                    elseif ((!isset($parametro) || $parametro < 0 || !isset($hoja) || $hoja < 0) &&  $resultado[1] != 1) {
                        $this->load->view('form_login', array( 'mensaje' => 'Esta cuenta en esta computadora necesita ser configurada por un Super usuario'));
                    } elseif (isset($parametro) && $parametro > -1 && isset($hoja) && $hoja > -1) {
                        redirect('/checkuser/index' , 'refresh');
                    }

                }
            }
        }
    }


    public function user_validate(){
        return;
        $this->load->model(array('mdl_user_validate', 'mdl_point_address'));
        $resultado = $this->mdl_user_validate->validate_user(array(
            'usuario'=> $this->input->post('usuario') ? $this->input->post('usuario') : "0",
            'contrasena'=> $this->input->post('contrasena') ? $this->input->post('contrasena') : "0",
            'tipo' => $this->input->post('tipo') ? $this->input->post('tipo') : "0"
        ));

        if ((int)$resultado > 0){
            $parametro = $this->input->post('parametro') ? $this->input->post('parametro') : NULL;
            $json_a = $this->mdl_puntodireccion->select_estafetas($parametro)->resultado[0];
            $this->session->set_userdata(array(
                'idusuario' => $resultado,
                'nombreusuario' => $this->input->post('usuario'),
                'impresion_Nombre' => $json_a->Nombre,
                'impresion_Ciudad' => $json_a->Ciudad,
                'impresion_Direccion' => $json_a->Direccion,
                'impresion_Telefono' => $json_a->Telefono,
                'impresion_Fax' => $json_a->Fax
            ));

        }

        echo json_encode(array("validate"=>$resultado,"redirect"=>$this->input->cookie('telenordci_redirect', TRUE)));
        //echo $this->input->cookie('telenordci_redirect', TRUE);
    }


    private function test(){
        $this->load->model(array('mdl_user_validate'));
        $resultado = $this->mdl_user_validate->validate_permisions();

    }

    public function logout() {
        echo "saliendo...";
        $this->load->library(array('funciones', 'chequeousuario'));
        if ($this->session->userdata('idusuario') !== NULL) {
            $this->funciones->limpia_sesion();
        }
        $this->chequeousuario->estara_en_sesion(true);
    }

}