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

					//Verificatiecode
					$code = md5(uniqid(rand(), true));

					$sql = "INSERT INTO `gebruikers` (`email`, `wachtwoord`, `code`) VALUES (:email, :wachtwoord, :code)";
					$statement = $connection->prepare($sql);
					$safe_password = password_hash($wachtwoord, PASSWORD_DEFAULT);

					$params = [
						'email' => $email,
						'wachtwoord' => $safe_password,
						'code' => $code
					];
					$statement->execute($params);  

					//verificattielink sturen naar mail
					sendConfirmationMail($email ,$code);

					$bedanktUrl = url('register.thankyou');
					redirect($bedanktUrl);
					

				} else {
					//Anders foutmelding
					$errors['email'] = 'Dit account bestaat al';
				}
			}

			$template_engine = get_template_engine();
			echo $template_engine->render('register_form', ['errors' => $errors]);

		}

		public function registrationThankYou(){	
			$template_engine = get_template_engine();
			echo $template_engine->render("register_thankyou");
		}

		public function confirmRegistration($code){
			//code lezen
			//gebruiker ophalen
			$user = getUserByCode($code);
			if ($user === false /*!$user*/ ){
				echo "onbekende gebruiker of als bevestigd?";
				exit;
			}
			//echo print_r($user);
			/*------------------*/
			//gebruiker activeren
			confirmAccount($code);
			//doorsturen bevestigings pagina
			$template_engine = get_template_engine();
			echo $template_engine->render("register_confirmed");
		}

	}
?>