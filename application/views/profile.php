<html>
<head>
	<title> Profile </title>

	<link rel="stylesheet" type="text/css" href="http://localhost/shorturl/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="http://localhost/shorturl/css/profile.css">
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-sm-12 header center well">
				<a href="http://localhost/shorturl/index.php/shorturl"><h1>Short Url</h1></a>
			</div>
		</div>

		<div class = "content">

			<div class="row">
				<div class="col-sm-12 center convert">
					<h3>Create Short Url </h3>

					<?php
						if(isset($url_error) && $url_error != null){ echo "<div class='alert alert-danger'>".$url_error."</div><br />"; }
						if(isset($url_info) && $url_info != null){ echo "<div class='alert alert-success'>".$url_info."</div><br />"; }

					?>
					<form action="<?php echo '../profileConvert/'.$userid ?>" method="POST" >
						<label>Enter the url to convert : http://</label><input class="form-control" type="text" name="urlToConvert" placeholder="Enter your Url" value="<?php echo set_value('urlToConvert');?>"><br />
						<label>Enter the preferred url:  http://localhost/shorturl/index.php/shorturl/home/<?php echo $userid; ?>/</label><input class="form-control" type="text" name="preferred"><br />
						<input class="btn btn-primary" type="submit" value="Convert it">
						<a href="../logout"><input class="btn btn-danger" type="button" value="LogOut"></a>
					</form>

				</div>
			</div>

			<?php 
				

				if(isset($not_found)){
					echo "".$not_found."";
				}

				else{
					foreach ($result as $urls) {
						?>
						<div class="panel panel-success">
						  <div class="panel-heading">Converted <strong><?php echo $urls['url'];?></strong> to</div>
						  <div class="panel-body"><?php echo "http://localhost/shorturl/index.php/shorturl/home/".$userid."/".$urls['shorturl']?></div>
						  <div class="panel-body"><a href='<?php echo "../delete/".$urls['shorturl'].""; ?>'><button class="btn btn-danger">Delete</button></a></div>
						</div>
						<?php
						
					}
				}
			?>

		</div>

		<div class="row">
			<div class="col-sm-12 footer center well">
				<label>Short Url Copyright@ 2016.</label>
			</div>
		</div>
	</div>
</body>
</html>



