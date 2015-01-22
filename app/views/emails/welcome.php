<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Hoşgeldiniz Sayın <?php echo $fname." ".$lname;?></h2>

		<div>
			Üyeliğinizi aktif etmek için : <?php echo URL::to('password/activation/'.$activation_code);?>
		</div>
	</body>
</html>
