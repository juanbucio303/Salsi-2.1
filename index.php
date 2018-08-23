<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device‐width, initial‐scale=1.0"> 
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/materialize.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="fonts/icons/material-icons.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.js"></script>
	
	<title>Login</title>
	<script>
		$(document).ready(function()
		{
			$("#entrar").click(function()
			{
				var user= $("#user").val();
				var	pass= $("#password").val();
				$.post("core/Login/controller_login.php",{action:'get_user',user:user,password:pass}, 
				function(res)
				{
					$("#user_req").html(res);
				});
				
			});
		});

	

	</script>
</head>
<body>
	<section class="container">
		<div class="row"></div>
		<div class="container s10 m6 l6">
		<div class="card-panel" style="background-color: #00bdfb; border-radius: 10px;">
			<form id="login" class="container center-align">
				<div>
			      <img src="img/logo.png" class="responsive-img" style="margin: 1em;">
			  	</div>
					<span class="material-icons" style="font-size: 4em; color: white">person</span>
					<div class="input-field row s4 m4 l4">
				    	<input type="text" class="validate" id="user" style="text-align:center;color: white;">
				    	<label for="user" style="color: white">Usuario</label>
			    	</div>
			  		<div class="input-field row s4 m4 l4">
			  		<input type="password" class="validate" id="password" style="text-align:center;color: white;">
			    	<label for="pass" style="color: white">Contraseña</label>
			    	
			  		</div>		
			  		<a id="entrar" class="waves-effect waves-light btn-flat" href="#!" style="margin-bottom: 1em; color: white; font-weight: 500; background: #d50113;">Entrar</a>
			</form>
		</div>
		</div>
	</section>
	<div id="user_req"></div>
</body>
</html>
