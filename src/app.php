<?php
include "database.php";
include "mailer.php";

$email = "test2222111us2r@example.com";
$code = "1211253";
$name="Claudia";

$result = createRegister($email, $code);

if ($result) {
    echo "Înregistrare reușită!";
} else {
    echo "Eroare la înregistrare.";
}

createUser($email,$name);
deleteRegister(2);
$result = getUser("test2222111us2r@example.com");
echo $result['email'];

sendMail('no-reply@my-awesome-app.com', 'Awesome Login', '<p>Acesta este un e-mail de test.</p>');

?>
