<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8"/>
		<title>TCDrive</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="http://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet" />
		<link href="<?php  echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
	</head>

	<body>

		<a class="back"></a>

		<div id="stage">

			<div id="step1">
				<div class="content">
					<h1>TCDrive </h1>
					<form action="<?php echo base_url(); ?>menu/login_proses" method="POST">
					<input type="text" name="username" class="login" /><br>
					<input type="password" name="password" class="login" /><br>
					<input type="submit" value="Sign in" class="button red button-login">
				</form>
				</div>
			</div>

	</body>

	<script src="<?php  echo base_url(); ?>assets/js/aes.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="<?php  echo base_url(); ?>assets/js/script.js"></script>

</html>