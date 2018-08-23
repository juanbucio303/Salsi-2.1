<nav class="align-center" id="nav_p" style="padding-left: 1em;padding-right: 1em; background: #9e9e9e;">
	<div>
		<ul>
			<li style="float: left; margin-right: 10%"><a id="salir" class="waves-effect waves-teal" href="index.php">Salir</a></li>		<!-- Dropdown Trigger -->
			<li><a href="ventas.php">Ventas</a></li>
			<li><a href="consultas_v.php">Consultas</a></li>
			<div class="row" style="float: right;">
					<div  class="col s0 m1 l2">
						<img src="img/logo.png" width="100px" style="margin-bottom: -1em">
					</div>
			</div>
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

	</script>
