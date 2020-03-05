<?php
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["fname"]));
        $subject = "";
        // strip_tags(trim($_POST["subject"]));
        $number = strip_tags(trim($_POST["phone"]));
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["srcPage"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($number) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! Message Not Send.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "aviadmiz1@gmail.com";

        // Set the email subject.
        $subject = "דף נחיתה - $message | פנייה מאת : $name";

        $message = "Name: $name\n Email: $email\n Number: $number";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Subject: $subject\n\n";
        $email_content .= "Number: $number\n\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";
//mail($recipient, $subject, $email_content, $email_headers)
        // Send the email.
        if (mail($recipient, $subject,$email_content)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thanks! Message sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong. 2222";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Oops! Something went wrong. 1111 ";
    }
?>