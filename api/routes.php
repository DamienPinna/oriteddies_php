<?php

require_once('./controllers.php');

try {
    if (!empty($_GET["demande"])) {
        $url = explode("/", filter_var($_GET["demande"], FILTER_SANITIZE_URL));

        if ($url[0] === "teddies") {
            if (empty($url[1])) {
                getAllTeddies();
            } else {
                getOneTeddie($url[1]);
            }
        } else {
            throw new Exception("Cet URL est iconnue");
        }

    } else {
        throw new Exception("Cet URL est iconnue");
    }
} catch (Exception $e) {
    $error = [
        "message" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    print_r($error);
}