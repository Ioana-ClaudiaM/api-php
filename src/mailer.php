<?php
require 'vendor/autoload.php';
use Mailtrap\Config;
use Mailtrap\EmailHeader\CategoryHeader;
use Mailtrap\EmailHeader\CustomVariableHeader;
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Header\UnstructuredHeader;

function sendMail($to, $subject, $messageBody) {
    $apiKey = "0a5099be57c44ab6da06885475d605c3";
    echo "Mailtrap API Key: " . $apiKey;

    $mailtrap = MailtrapClient::initSendingEmails(
        apiKey: $apiKey,
        inboxId: 3222635,
        isSandbox: true,
    );

    $email = (new Email())
        ->from(new Address('no-reply@my-awesome-app.com', 'My Awesome App'))
        ->to(new Address($to))
        ->priority(Email::PRIORITY_HIGH)
        ->subject($subject)
        ->html($messageBody);
    try {
        $response = $mailtrap->send($email);
        echo 'Email sent successfully!';
        var_dump(ResponseHelper::toArray($response));
    } catch (Exception $e) {
        echo 'Error sending email: ', $e->getMessage();
    }
}
?>