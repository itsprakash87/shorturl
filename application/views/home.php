<html>
<head>
	<title>Short Url</title>
	<link rel="stylesheet" type="text/css" href="http://localhost/shorturl/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="http://localhost/shorturl/css/home.css">

	<script type="text/javascript">

		function check(){
			if(document.getElementById('userid').value == "" || document.getElementById('password').value == "" || document.getElementById('repassword').value == ""){
				alert("All Fields are required.");
				return false;
			}
			if(document.getElementById('password').value != document.getElementById('repassword').value){
				alert("Password and confirm password fields does not match");
				return false;
			}
			if(document.getElementById('userid').value == "guest"){
				alert("Userid cannot be guest.");
				return false;
			}
			else{
				return true;
			}
		}
	</script>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-sm-12 header center well">
				<a href="http://localhost/shorturl/index.php/shorturl"><h1>Short Url</h1></a>
			</div>
		</div>


		<div class="row">
			<div class="col-sm-12 center convert">
				
				<h3>Create without sign in </h3><br />
				
				<?php
					if(isset($url_error) && $url_error != null){ echo "<div class='alert alert-danger'>".$url_error."</div><br />"; }
					if(isset($url_info) && $url_info != null){ echo "<div class='alert alert-success'>".$url_info."</div><br />"; }

				?>
				<form action="convert" method="POST" >
					<label>Enter the url to convert : </label><input class="form-control" type="text" name="urlToConvert" placeholder="Enter your Url" value="<?php echo set_value('urlToConvert');?>"><br />
					<label>Enter the preferred url:  http://localhost/shorturl/index.php/shorturl/home/</label><input class="form-control" type="text" name="preferred"><br />
					<input class="btn btn-primary" type="submit" value="Convert it">
				</form>

			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 center login">

				<h3>Login </h3><br />

				<form action="login" method="POST" >
					<?php if(isset($login_error)){ ?>
					<p><?php echo "<div class='alert alert-danger'>".$login_error."</div><br />"; ?></p>
					<?php } ?>
					<label>Your Id : </label><input class="form-control" type="text" name="userid" placeholder="Enter your id"><br />
					<label>Password : </label><input class="form-control" type="password" name="password"><br />
					<input class="btn btn-success" type="submit" value="Login">
				</form>
			</div>
		
			<div class="col-sm-6 center register">
				<h3>Sign Up </h3><br />

				<?php
					if(isset($reg_error) && $reg_error != null){ echo "<div class='alert alert-danger'>".$reg_error."</div><br />"; }

				?>
				<form action="register" method="POST" onsubmit = "return check();" >
					<label>Your Id : </label><input class="form-control" type="text" name="userid" placeholder="Enter your id" id="userid"><br />
					<label>Password : </label><input class="form-control" type="password" name="password" id="password"><br />
					<label>Confirm Password : </label><input class="form-control" type="password" name="repassword" id="repassword"><br />
					<input class="btn btn-success" type="submit" value="Register">
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 footer center well">
				<label>Short Url Copyright@ 2016.</label>
			</div>
		</div>
	</div>
</body>
</html>