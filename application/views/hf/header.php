<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php 
    $ajax_url = base_url().'index.php/'.$this->router->class;
    $js_directory = base_url()."/js/";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8" />
        <?php if (isset($title)){ 
        echo "<title> $title </title>"; }?>

         <?php
        if (isset($precss)){
            foreach ($precss as $value) {
                echo "<link rel='stylesheet' type='text/css' media='screen' href='$value' />";
            }
        }
        ?>

        <?php
        if (isset($css)){
            foreach ($css as $value) {
                echo "<link rel='stylesheet' type='text/css' media='screen' href='" . base_url() . "css/$value.css' />";
            }
        }
        ?>

        <script type="text/javascript">
                var ajax_url = '<?php echo $ajax_url; ?>';
                var real_path = '<?php echo base_url(); ?>';

                
                function link_to(url)
                {
                    return ajax_url + "/" + url;
                }

                function OpenInNewTab(url)
                {
                    var win=window.open(real_path + 'index.php/' + url ,'_blank');
                    win.focus();
                }

                function OpenInSelfTab(url)
                {
                    var win=window.open(real_path + 'index.php/' + url ,'_self');
                    win.focus();
                }
                
        </script>
        <?php if (isset($prejs)){
            foreach ($prejs as $value) {
               echo "<script type='text/javascript'> " . $value . "</script>";
            }
        }
        ?>

         <?php
        if (isset($js)){
            foreach ($js as $value) {
                echo "<script type='text/javascript' src='" . base_url() . "js/$value.js'></script>";

            }
        }

        ?>
        
    </head>
<body>
 
<div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://telenord.com.do/" target="_blank">Telenord</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo base_url();?>index.php/busquedacliente/index">Inicio</a></li>
            <li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Registros<b class='caret'></b></a>
                <ul class='dropdown-menu'>               
                    <li><a href="<?php echo base_url();?>index.php/cliente/registro_cliente">Registro Cliente</a></li>
                </ul>
            </li>      
            <?php
                if (isset($menu_servicios)){
                    echo    "<li class='dropdown'>
                                        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Servicios<b class='caret'></b></a>
                                        <ul class='dropdown-menu'>";                
                       if (isset($contract) || isset($pagos_adelantados) || isset($extensiones)){
                         if ($contract){
                            echo "<li><a href='" . base_url() . "index.php/cliente/traslados/$contract' id='btn_traslados'>Traslados</a></li>";        
                        }
                         if ($pagos_adelantados){
                            echo "<li><a href='#' id='btn_pagos_adelantados'>Pagos Adelantados</a></li>";
                         }
                         if ($extensiones){
                            echo "<li><a href='#' id='btn_extensiones'>Extensiones</a></li>";
                         }

                       }

                    echo "</ul></li>";
                    } 
            ?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <p class="navbar-text"><?php if (empty($usuario)) echo "Usuario "; else echo ucfirst($usuario). " " ;?><a href="<?php echo site_url() . '/validacion/logout/';?>" class="navbar-link">Salir Sesíon</a></p>
          </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<!-- end header -->
