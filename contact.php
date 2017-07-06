<?php
header('Content-type: application/json');
$response = array();
if(!isset($_POST['prenom']) || $_POST['prenom'] == '') {
    $response['errors'][] = "Le prénom doit être défini.";
} else {
    $prenom = $_POST['prenom'];
}
if(!isset($_POST['nom']) || $_POST['nom'] == '') {
    $response['errors'][] = "Le nom doit être défini.";
} else {
    $nom = $_POST['nom'];
}
if(!isset($_POST['email']) || $_POST['email'] == '') {
    $response['errors'][] = "L'email doit être défini.";
} else {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $response['errors'][] = "L'email est incorrect.";
    } else {
        $email = $_POST['email'];
    }
}
if(!isset($_POST['message']) || $_POST['message'] == '') {
    $response['errors'][] = "Le message doit être défini.";
} else {
    $message = $_POST['message'];
}
if(!isset($_POST['g-recaptcha-response']) || $_POST['g-recaptcha-response'] == '') {
    $response['errors'][] = "Le captha doit être défini.";
} else {
    $captcha = $_POST['g-recaptcha-response'];
}

if(!isset($prenom) || !isset($nom) || !isset($email) || !isset($message) || !isset($captcha)) {
    http_response_code(400);
    echo json_encode($response);
    return false;
}

$url = 'https://www.google.com/recaptcha/api/siteverify';
$fields = array(
	'secret' => urlencode('6Lch_RkTAAAAAGNXo9FxBRmXuzKAzkkxNj8fmxJR'),
	'response' => urlencode($captcha)   
);

foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

$ch = curl_init();

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resultCaptcha = curl_exec($ch);
if(!$resultCaptcha['success']) {
    http_response_code(400);
    $response['errors'][] = "Vous n'etes pas humain.";
    echo json_encode($response);
    return false;
}

curl_close($ch);

require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->SetFrom($email, 'Expéditeur');
$mail->Subject = 'Demande de contact de '.$prenom.' '.$nom;
$mail->Body = $message;
$mail->AddAddress('contact@test.fr');
if(!$mail->send()) {
    http_response_code(400);
    $response['errors'][] = "Echec de l'envoi : réessayer plus tard.";
}
else {
    $response['message'] = 'OK';
}

echo json_encode($response);

?>
