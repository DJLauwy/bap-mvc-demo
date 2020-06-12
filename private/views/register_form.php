<?php $this->layout('index') ?>

<!DOCTYPE html>
<html>
	<head>
		<title>verificatiemail bap</title>
	</head>
	<body>
		<h1>account aanmaken</h1>
		<form action="<?php echo url('register.handle') ?>" method="post">
			<input type="email" placeholder="e-mail adres" name="email" required>
			<?php if (isset($errors['email'])): ?>
				<span style="color:red;"><?php echo $errors['email'] ?></span>
			<?php endif; ?>
			<input type="password" placeholder="wachtwoord" name="wachtwoord" required>
			<?php if (isset($errors['wachtwoord'])): ?>
				<span style="color:red;"><?php echo $errors['wachtwoord'] ?></span>
			<?php endif; ?>
			<input type="submit" value="registreren">
		</form>
	</body>
</html>