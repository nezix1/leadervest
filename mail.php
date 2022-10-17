<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // access
        //$secretKey = '6LeRt8kdAAAAAPpMQk6oQJDNmJSsvKq9fJ4Krifh';
        //$captcha = $_POST['g-recaptcha-response'];

        //if(!$captcha){
        //  echo '<p class="alert alert-warning">Please check the captcha form.</p>';
        //  exit;
        //}

        # Recipient email
        $mail_to = 'ross.campbell@leadervest.com, AIi.arif@leadervest.com, Brett.suarez@leadervest.com, Carlo.iera@leadervest.com';
        
        # Sender Data
        $subject = "New request through services.leadervest.com landing page";
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
		$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
		$phone = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["phone"])));
		$company = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["company"])));
        $message = trim($_POST["message"]);
        
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($subject) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo '<p class="alert alert-warning">Please complete the form and try again.</p>';
            exit;
        }

        //$ip = $_SERVER['REMOTE_ADDR'];
        //$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        //$responseKeys = json_decode($response,true);

        //if(intval($responseKeys["success"]) !== 1) {
        //  echo '<p class="alert alert-warning">Please check the captcha form.</p>';
        //} else {
            # Mail Content
            $content = "Name: $name\n\n";
            $content .= "Email: $email\n\n";
			$content .= "Phone: $phone\n\n";
			$content .= "Company: $company\n\n";
            $content .= "Message:\n$message\n";

            # email headers.
            $headers = "From: $name <$email>";

            # Send the email.
            $success = mail($mail_to, $subject, $content, $headers);
            if ($success) {
                # Set a 200 (okay) response code.
                http_response_code(200);
				header('Location: /thank-you.html');
            } else {
                # Set a 500 (internal server error) response code.
                http_response_code(500);
                echo '<p class="alert alert-warning">Oops! Something went wrong, we could not send your message.</p>';
            }
        //}

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo '<p class="alert alert-warning">There was a problem with your submission, please try again.</p>';
    }

?>
