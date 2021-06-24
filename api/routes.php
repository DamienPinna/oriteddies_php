<?php

require_once "controllers/api_controller.php";
require_once "config/securite.php";
$apiController = new ApiController();

try {

   $page = secureHTML($_GET['page']);

   if (empty($page)) {
      throw new Exception("La page n'existe pas");
   } else {
      $url = explode("/", filter_var($page, FILTER_SANITIZE_URL));

      switch ($url[0]) {
         case "teddies" :
            if (empty($url[1])) {
               $apiController->getAllTeddies();
            } else if (!empty($url[1]) && $url[1] !== "order" && empty($url[2])) {
               $apiController->getOneTeddie($url[1]);
            } else if ($url[1] === "order" && empty($url[2])) {
               $apiController->retourCommande();
            } else {
               throw new Exception("La page n'existe pas");
            }
         break;
         default: throw new Exception("La page n'existe pas");
      }
   }
   
} catch (Exception $e) {
   $error = [
      "message" => $e->getMessage(),
      "code" => $e->getCode()
   ];
   print_r($error);
}