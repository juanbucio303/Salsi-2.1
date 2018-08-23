<ul id="dropdown2" class="dropdown-content">
	<li><a href="alimentos.php">Alimentos</a></li>
	<li><a href="Existencias.php">Surtido</a></li>
   	<li><a href="categorias.php">Categoria de Alimentos</a></li>
   	<li><a href="ingredientes.php">Ingredientes</a></li>
	<li><a href="proveedores.php">Proveedores</a></li>
</ul>
<ul id="dropdown3" class="dropdown-content">
	<li><a href="locaciones.php">Locaciones</a></li>
	<li><a href="tipos_locacion.php">Tipos de Locaciones</a></li>
</ul>
<ul id="dropdown4" class="dropdown-content">
	<li><a href="usuarios.php">Usuarios</a></li>
	<li><a href="empleados.php">Empleados</a></li>
	<li><a href="metodos_pago.php">Metodos de Pago</a></li>
	<li><a href="descuentos.php">Descuentos</a></li>	
	<li><a href="consultas.php">Consultas</a></li>
</ul>
<nav class="align-center" id="nav_p" style="padding-left: 1em;padding-right: 1em; background: #9e9e9e;">
	<div class="nav-wrapper">
		<ul>
			<li style="float: left; margin-right: 0.5%">
				<a id="salir" class="waves-effect waves-teal" href="index.php">Salir</a>
			</li>
					<!-- Dropdown Trigger -->
			<li style="float: center">
				<a class="dropdown-trigger" data-target='dropdown2'>Control de alimentos<i class="material-icons right">arrow_drop_down</i></a>
			</li>
			<li style="float: center"> 
				<a class="dropdown-trigger" data-target='dropdown3'>Control Locacional<i class="material-icons right">arrow_drop_down</i></a>
			</li>
			<li style="float: center">
				<a class="dropdown-trigger" data-target='dropdown4'>Control Administrativo<i class="material-icons right">arrow_drop_down</i></a>
			</li>	
			<li style="float: right;">
				<div class="row">
					<div  class="col s0 m1 l2">
						<img src="img/logo.png" width="100px" style="margin-bottom: -1em">
					</div>
				</div>
				
			</li>
		</ul>
	</div>
</nav>
	<script>
		$("#salir").click(function()
		{
			$.post("core/Login/controller_login.php",{action:'destruir'},
				function()
				{

				});
		});
		$('.dropdown-trigger').dropdown();
		

	</script>
	<style type="text/css">
		.dropdown-content {
   			overflow-y: visible;
   			border-radius: 3px;
   			margin-top: 4em;
		}
		.dropdown-content li a{
			color: black;
		}
	</style>