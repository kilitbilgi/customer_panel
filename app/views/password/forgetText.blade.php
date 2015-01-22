<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Sayın <?php echo $fname." ".$lname;?></h2>

		<div>
			Şifrenizi sıfırlamak için : <?php echo URL::to('password/reset/'.$reset_code);?>
		</div>
	</body>
</html>
