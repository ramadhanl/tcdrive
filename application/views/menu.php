<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8"/>
		<title>TCDrive</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="http://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet" />
		<link href="<?php  echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
		<link href="<?php  echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" />
	</head>

	<body>
	<div class="logout">
		<a href="<?php  echo base_url(); ?>menu/logout">Logout</a>
	</div>
		<a class="back"></a>

		<div id="stage">
			<div id="step1">
				<div class="content">
					<h1>Hai <?php echo $this->session->userdata('nama');?>, welcome to TCDrive</h1>
					<a class="button encrypt green">Upload to Cloud</a>
					<a class="button decrypt magenta">Download</a>
				</div>
			</div>

			<div id="step2">

				<div class="content if-encrypt">
					<h1>Choose file to upload</h1>
					<h2>An encrypted copy of the file will be generated. No data is sent to our server.</h2>
					<a class="button browse blue">Browse</a>
					<input type="file" id="encrypt-input" />
				</div>

				<div class="content if-decrypt">
					<h1>Choose which file to download</h1>
					<div class="files">
						<?php 
						foreach ($files as $key) {
							echo '<div class="file"><a href="#">'.$key.'</a></div>'."<br>";
						}
						?>
					</div>
					<a class="button browse blue">Download</a>

					<input type="file" id="decrypt-input" />
				</div>

			</div>

			<div id="step3">

				<div class="content if-encrypt">
					<h1>File has been encrypted</h1>
					<h2>This phrase will be used as an encryption key. Write it down or remember it; you won't be able to restore the file without it. </h2>

					<input type="hidden" name="password" value='<?php echo $this->session->userdata('password')?>'/>
					<a class="button process red">Upload to Cloud!</a>
				</div>

				<div class="content if-decrypt">
					<h1>File has been downloaded</h1>
					<h2>Enter the pass phrase that was used to encrypt this file. It is not possible to decrypt it without it.</h2>

					<input type="hidden" name="password" value='<?php echo $this->session->userdata('password')?>'/>
					<a class="button process red">Decrypt!</a>
				</div>

			</div>

			<div id="step4">

				<div class="content">
					<h1>Your file is ready!</h1>
					<a class="button download green">Download</a>
				</div>

			</div>
		</div>

	</body>

	<script src="<?php  echo base_url(); ?>assets/js/aes.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="<?php  echo base_url(); ?>assets/js/script.js"></script>

</html>