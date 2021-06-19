<?php

require_once "models/api_manager.php";
require_once "models/model.php";

class ApiController {

   private $apiManager;

   public function __construct() {
      $this->apiManager = new ApiManager();
   }

   public function getAllTeddies() {
      $teddies = $this->apiManager->getDbAllTeddies();
      Model::sendJSON($teddies);
   }

   public function getOneTeddie($id) {
      $teddie = $this->apiManager->getDbOneTeddie($id);
      Model::sendJSON($teddie);
   }

   public function retourCommande() {
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Methods: POST");
      header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");

      $order = json_decode(file_get_contents('php://input'));

      $products = [];
      foreach ($order->products as $product) {
         $products[] = $this->apiManager->getDbOneTeddie($product);
      }

      $orderId = random_int(1000, 9999) . "-" . random_int(1000, 9999) . "-" . random_int(1000, 9999) . "-" . random_int(1000, 9999);

      $retourOrder = [

         "contact" =>
         [
            "firstName" => $order->contact->firstName,
            "lastName" => $order->contact->lastName,
            "address" => $order->contact->address,
            "city" => $order->contact->city,
            "email"=> $order->contact->email
         ],

         "products" => $products,
         "orderId" => $orderId
      ];

      Model::sendJSON($retourOrder);

      
      // $to = "contact@h2prog.com";
      // $subject = "Message du site MyZoo de : ".$obj->nom;
      // $message = $obj->contenu;
      // $headers = "From : ".$obj->email;
      // mail($to, $subject, $message, $headers);

      // $messageRetour = [
      //     'from' => $obj->email,
      //     'to' => "contact@h2prog.com"
      // ];

      // echo json_encode($messageRetour);
   }
}