<?php

	namespace Website\Controllers;

	/**
	 * Class WebsiteController
	 *
	 * Deze handelt de logica van de homepage af
	 * Haalt gegevens uit de "model" laag van de website (de gegevens)
	 * Geeft de gegevens aan de "view" laag (HTML template) om weer te geven
	 *
	 */
	class RegistrationController {

		public function registrationForm() {

			$template_engine = get_template_engine();
			echo $template_engine->render('index');

		}

		public function handleRegistrationForm(){
			//Form afhandelen
			$errors = [];

			//E-mail adres controleren
			$email = filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL );
			$wachtwoord = trim( $_POST['wachtwoord'] );

			if ( $email === false ) { 
				$errors['email'] = 'Geen geldig email ingevuld';
			}

			//Wachtwoord 6 tekens bevat
			if ( empty( $wachtwoord ) || strlen( $wachtwoord ) < 6 ) { 
				$errors['wachtwoord'] = 'Geen geldig wachtwoord (minimaal 6 tekens)';
			}

			if (count($errors) === 0 ){
				//Opslaan gebruiker
				//Checken of gebruiker al bestaat
				$connection = dbConnect();
				$sql = "SELECT * FROM `gebruikers` WHERE `email` = :email";
				$statement = $connection->prepare($sql);
				$statement->execute(['email' => $email]);

				if ($statement->rowCount() === 0){
					//Als die er niet is dan doorgaan
					$sql = "INSERT INTO `gebruikers` (`email`, `wachtwoord`) VALUES (:email, :wachtwoord)";
					$statement = $connection->prepare($sql);
					$safe_password = password_hash($wachtwoord, PASSWORD_DEFAULT);
					$params = [
						'email' => $email,
						'wachtwoord' => $safe_password
					];
					$statement->execute($params);
					echo "Klaar! Account opgeslagen.";
					exit;
				} else {
					//Anders foutmelding
					$errors['email'] = 'Dit account bestaat al';
				}
			}
		}
	}
?>