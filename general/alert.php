<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="theStyle.css">
		<title>Alert</title>
	</head>
	<body>
		<script>
			alert("<?php
				echo $_GET["alert"];
			?>");
			window.location = "<?php echo $_GET['direct'] ?>";
		</script>
	</body>
</html>