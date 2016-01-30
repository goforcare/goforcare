<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name1 = strip_tags(trim($_POST["name1"]));
        $name1 = str_replace(array("\r","\n"),array(" "," "),$name1);
        $name2 = strip_tags(trim($_POST["name1"]));
        $name2 = str_replace(array("\r","\n"),array(" "," "),$name2);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $details = trim($_POST["details"]);
        $phonenumber = trim($_POST["phonenumber"]);
        $country = trim($_POST["country"]);
        $state = trim($_POST["state"]);
        $city = trim($_POST["city"]);
        $chosenpackage = trim($_POST["chosenpackage"]);
        $specialities = trim($_POST["specialities"]);


        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "contact@goforcare.co";

        // Set the email subject.
        $subject = "$name1 $name2 is interested in $speciality";

        // Build the email content.
        $email_content = "Name: $name1 $name2\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Phone number: $phonenumber\n";
        $email_content .= "Location: $country , $state , $city\n";
        $email_content .= "Area of interest: $specialities\n";
        $email_content .= "Chosen package: $chosenpackage\n";        
        $email_content .= "Details:\n$details\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        $email_confirmation = "Dear $name1 $name2,\n\n";
        $email_confirmation .= "Thank you for contacting us. We will contact you in the next business day to address your $specialities needs.\n";
        $email_confirmation .= "We wish you a wonderful day and a fabulous time in Colombia!\n\n"
        $email_confirmation .= "Best regards,\n"
        $email_confirmation .= "Brenda Sanchez, Medical Travel Manager at GoForCare Colombia."

        $subject_confirmation = "Thank you for contacting GoForCare!"

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent. We will get in touch with you as soon as possible.";
            mail($email, $subject_confirmation, $email_confirmation);
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>