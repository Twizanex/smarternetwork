<?php
$address = "scott.jenkins@smarternetwork.com";
 
$subject = 'Test email.';
 
$body = 'If you can read this, your email is working.';
 
echo "Attempting to email $address...<br />";
 
if (mail($address, $subject, $body)) {
        echo 'SUCCESS!  PHP successfully delivered email to your MTA.  If you don\'t see the email in your inbox in a few minutes, there is a problem with your MTA.';
} else {
        echo 'ERROR!  PHP could not deliver email to your MTA.  Check that your PHP settings are correct for your MTA and your MTA will deliver email.';
}

