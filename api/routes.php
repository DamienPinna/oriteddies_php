<?php

require_once('./controllers.php');

$request_method = $_SERVER["REQUEST_METHOD"];

try {
    switch($request_method) {
        case 'GET':
           if (!empty($_GET["id"])) {
              // Récupérer un seul produit
              $id = intval($_GET["id"]);
              getOneTeddie($id);
           } else {
              // Récupérer tous les produits
              getAllTeddies();
           }
           break;
        case 'POST':
           header("Access-Control-Allow-Origin: *");
           header("Content-Type: application/json; charset=UTF-8");
           header("Access-Control-Allow-Methods: POST");
           header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
           $donnees = json_decode(file_get_contents("php://input"));
           echo json_encode($donnees, JSON_UNESCAPED_UNICODE);
     
        default:
        // Requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
    }
} catch (Exception $e) {
    $error = [
        "message" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    print_r($error);
}