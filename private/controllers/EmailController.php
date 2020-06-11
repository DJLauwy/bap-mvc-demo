<?php

	namespace Website\Controllers;

	class EmailController{

		public function sendTestEmail(){

			$mailer = getSwiftMailer();

			$message = createEmailMessage('armin@astateoftrance.com', 'Dit is een test e-mail', 'Lau de Hoop', 'laudehoop@hotmail.com');
			$message->setBody('Dit is de inhoud van mijn test bericht!');

			$aantal_verstuurd = $mailer->send($message);
			
			echo "Aantal = " . $aantal_verstuurd;
		}

	}

?>