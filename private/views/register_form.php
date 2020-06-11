<?php $this->layout('webiste') ?>

<!DOCTYPE html>
<html>
	<head>
		<title>verificatiemail bap</title>
	</head>
	<body>
		<h1>account aanmaken</h1>
		<form action="register.php" method="post">
			<input type="text" placeholder="naam" name="naam" required>
			<input type="email" placeholder="e-mail adres" name="email" required>
			<input type="password" placeholder="wachtwoord" name="wachtwoord" required>
			<input type="submit" value="registreren">
		</form>
	</body>
</html>