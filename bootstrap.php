<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$conn = [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
];

// obtaining the entity manager
global $entityManager;
$entityManager = EntityManager::create($conn, $config);

// setup email
$mail = new \PHPMailer\PHPMailer\PHPMailer(true);
try {
    $mail->isSMTP(); // Use SMTP
    $mail->Host        = 'smtp.gmail.com'; // Sets SMTP server
    $mail->SMTPAuth    = true; // enable SMTP authentication
    $mail->SMTPSecure  = "tls"; //Secure conection
    $mail->Port        = 587; // set the SMTP port
    $mail->Username    = 'pm.pivo.sld@gmail.com'; // SMTP account username
    $mail->Password    = getenv('SMTP_PASS'); // SMTP account password
    $mail->setFrom('pm.pivo.sld@gmail.com', 'Pivo\'s');
    $mail->addReplyTo('pivos@descouting.nl', 'Pivo\'s');
} catch (Exception $e) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}