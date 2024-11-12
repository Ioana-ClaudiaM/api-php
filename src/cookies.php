<?php
$cookieName = "authCookie";

function getCookie($req, $name) {
    if (isset($_COOKIE[$name])) {
        return json_decode($_COOKIE[$name], true); 
    }
    return null;
}

function setAuthCookie($res, $data) {
    global $cookieName;
    
    $expires = time() + 3600; 
    $data['expires'] = $expires;

    $value = json_encode($data);

    setcookie($cookieName, $value, $expires, "/");
}

function unsetAuthCookie($res) {
    global $cookieName;
    
    setcookie($cookieName, '', time() - 3600, "/");
}

function cookies(&$req, &$res) {
    $req['getCookie'] = function($name) use ($req) {
        return getCookie($req, $name);
    };

    $req['auth'] = $req['getCookie']($GLOBALS['cookieName']);

    $res['setAuthCookie'] = function($data) use ($res) {
        setAuthCookie($res, $data);
    };

    $res['unsetAuthCookie'] = function() use ($res) {
        unsetAuthCookie($res);
    };
}
?>