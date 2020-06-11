<!DOCTYPE html>
<html>
	<head>
		<title>verificatiemail bap</title>
	</head>
	<body>
		<h1>account aanmaken</h1>
		<form action="<?php echo url('register.handle') ?>" method="post">
			<input type="email" placeholder="e-mail adres" name="email" required>
			<input type="password" placeholder="wachtwoord" name="wachtwoord" required>
			<input type="submit" value="registreren">
		</form>
	</body>
</html>