<?php
include "database.php";

function registerHandler($req,$res){
    $code = bin2hex(random_bytes(20));
    $inserted = createRegister($req['email'],$code);
    if (!$inserted) {
        http_response_code(500);
        echo json_encode(['error' => 'Something went wrong']);
        return;
    }

    $url = $req['origin'] . '/create-user?code=' . $code;
    $message = '<div>Click <a href="' . $url. "here</a> to finish the registration.</div>";
    $subject = 'Register your awesome account';

    
}
?>