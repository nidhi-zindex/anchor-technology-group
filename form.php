<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/OAuth.php";
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $your_name = $_POST['name'];
    $company = $_POST['company'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $tell = $_POST['tell-us'];

    $date_of_register = date('m-d-Y');

    // Email content
    $subject = "Scheduled Call by " . $company;
    $message = "<html><body>";
    $message .= '<table style="font-family: arial, sans-serif; border-collapse: collapse; ">';

    $message .= '<tr style="background-color: #528094;">';
    $message .= '<th style="border: 1px solid #dddddd; padding: 8px; font-weight:bold;">Name: </th>';
    $message .= '<td style="border: 1px solid #dddddd; padding: 8px;">' . $your_name . '</td>';
    $message .= '</tr>';

    $message .= '<tr>';
    $message .= '<th style="border: 1px solid #dddddd; padding: 8px; font-weight:bold;">Company: </th>';
    $message .= '<td style="border: 1px solid #dddddd; padding: 8px;">' . $company . '</td>';
    $message .= '</tr>';

    $message .= '<tr style="background-color: #528094;">';
    $message .= '<th style="border: 1px solid #dddddd; padding: 8px; font-weight:bold;">Role: </th>';
    $message .= '<td style="border: 1px solid #dddddd; padding: 8px;">' . $role . '</td>';
    $message .= '</tr>';

    $message .= '<tr>';
    $message .= '<th style="border: 1px solid #dddddd; padding: 8px; font-weight:bold;">E-Mail: </th>';
    $message .= '<td style="border: 1px solid #dddddd; padding: 8px;">' . $email . '</td>';
    $message .= '</tr>';

    $message .= '<tr style="background-color: #528094;">';
    $message .= '<th style="border: 1px solid #dddddd; padding: 8px; font-weight:bold;">Tell Us More: </th>';
    $message .= '<td style="border: 1px solid #dddddd; padding: 8px;">' . $tell . '</td>';
    $message .= '</tr>';

    $message .= '<tr>';
    $message .= '<th style="border: 1px solid #dddddd; padding: 8px; font-weight:bold;">Date of Appoiment Request: </th>';
    $message .= '<td style="border: 1px solid #dddddd; padding: 8px;">' . $date_of_register . '</td>';
    $message .= '</tr>';

    $message .= '</table>';
    $message .= '<br/><br/> Thank You.';
    $message .= "</body></html>";

    // SMTP Details
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.dreamhost.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact@drcoders.com';
        $mail->Password = '^qTTONt8FUW*4tqO';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465; // Use Port 465 for SSL

        //Recipients
        $mail->setFrom('contact@drcoders.com', 'Scheduled Call');
        $mail->addAddress('drcoders1@gmail.com', 'Support');


        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        $response['success'] = true;
        $response['message'] = "Success! Your call has been scheduled. Thank you!";
    } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = "Error: Unable to send email. Please try again later. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Return the JSON response
echo json_encode($response);
