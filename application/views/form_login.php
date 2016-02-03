<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="uft-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
	 <link href="<?php echo base_url('assets/css/form_login.css')?>" rel="stylesheet">
	 

</head>
<body>
   <div class="site-wrapper" id="molestoso">

        <div class="site-wrapper-inner intro-background">

            <div class="cover-container">

                <div class="masthead clearfix">
                    <div class="inner">
                        <h1 class="masthead-brand text-muted">Telenord</h1>
                        <?php if (isset($mensaje))  echo "<p style='background: -moz-linear-gradient(top,  rgba(255,0,0,0.65) 0%, rgba(0,0,0,0) 100%); /* FF3.6+ */
                                                                    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,0,0,0.65)), color-stop(100%,rgba(0,0,0,0))); /* Chrome,Safari4+ */
                                                                    background: -webkit-linear-gradient(top,  rgba(255,0,0,0.65) 0%,rgba(0,0,0,0) 100%); /* Chrome10+,Safari5.1+ */
                                                                    background: -o-linear-gradient(top,  rgba(255,0,0,0.65) 0%,rgba(0,0,0,0) 100%); /* Opera 11.10+ */
                                                                    background: -ms-linear-gradient(top,  rgba(255,0,0,0.65) 0%,rgba(0,0,0,0) 100%); /* IE10+ */
                                                                    background: linear-gradient(to bottom,  rgba(255,0,0,0.65) 0%,rgba(0,0,0,0) 100%); /* W3C */
                                                                    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a6ff0000', endColorstr='#00000000',GradientType=0 ); /* IE6-9 */
                                                                    '>$mensaje</p>" ?>
                    </div>
                </div>
                <div id="contenedor" class="caja-sombra">
                    <div class="inner cover">
                        <h1 class="cover-heading texto-sombra">Entrada al Sistema</h1>
                        <?php echo form_open('', 'role="form"'); ?>
                            <div class="form-group">
                                <label class="control-label texto-sombra" for="InputUsuario">Usuario</label>
                                <input type="text" class="form-control caja-sombra" id="InputUsuario" name="InputUsuario" placeholder="Nombre del Usuario" value = "<?php echo set_value('InputUsuario'); ?>">
                                <?php echo form_error('InputUsuario'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label texto-sombra" for="InputPassword">Contraseña</label>
                                <input type="password" class="form-control caja-sombra" id="InputPassword" name="InputPassword" placeholder="Contraseña del Usuario">
                                <?php echo form_error('InputPassword'); ?>
                                <input type="hidden" id="parametro" name="parametro" value="">
                                <input type="hidden" id="hoja" name="hoja" value="">
                            </div>
                            <button type="submit" class="btn btn-lg btn-success caja-sombra">Entrar</button>
                        </form>
                    </div>
                </div>

                <div class="mastfoot">
                    <div class="inner">
                        <p>Entrada al sistema de cobros</p>
                    </div>
                </div>

            </div>

        </div>

    </div>
    	  <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>

</body>
</html>
