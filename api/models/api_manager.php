<?php

require_once "models/model.php";
define("URL", str_replace("routes.php", "", (isset($_SERVER['HTTPS'])? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));

class ApiManager extends Model {
   
   public function getDbAllTeddies() {
      $req = "SELECT p.id, p.name, p.price, p.description, p.imageUrl, c.couleur AS colors
            FROM produit p
            INNER JOIN produit_couleur pc ON p.id = pc.id
            INNER JOIN couleur c ON pc.id_couleur = c.id_couleur;";
   
      $stmt = $this->getConnexion()->prepare($req);
      $stmt->execute();
      $teddies = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt->closeCursor();

      $array = [];
      foreach ($teddies as $teddy) {
         if (!array_key_exists($teddy['id']-1, $array)) {
            $array[] = [
               "id" => $teddy['id'],
               "name" => $teddy['name'],
               "price" => $teddy['price'],
               "description" => $teddy['description'],
               "imageUrl" => URL."public/images/".$teddy['imageUrl'],
            ];
         };
         $array[$teddy['id']-1]['colors'][] = $teddy['colors'];
      }
   
      return $array;

   }

   public function getDbOneTeddie($id) {
      $req = "SELECT p.id, p.name, p.price, p.description, p.imageUrl, c.couleur AS colors
            FROM produit p
            INNER JOIN produit_couleur pc ON p.id = pc.id
            INNER JOIN couleur c ON pc.id_couleur = c.id_couleur
            WHERE p.id = :id;";

      $stmt = $this->getConnexion()->prepare($req);
      $stmt->bindValue(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
      $teddies = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $stmt->closeCursor();

      $array = [];
      foreach ($teddies as $teddy) {
         if (!array_key_exists('id', $array)) {
            $array = [
               "id" => $teddy['id'],
               "name" => $teddy['name'],
               "price" => $teddy['price'],
               "description" => $teddy['description'],
               "imageUrl" => URL."public/images/".$teddy['imageUrl'],
            ];
         };
         $array['colors'][] = $teddy['colors'];
      }

      return $array;

   }

   public function traitementDeLaCommande() {
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Methods: POST");
      header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");

      $orderObject = json_decode(file_get_contents('php://input'));
    
      $products = [];
      foreach ($orderObject->products as $product) {
         for ($i=0; $i < $product->quantite; $i++) {
            $products[] = $this->getDbOneTeddie($product->id);
         }
      }
     
      $orderId = random_int(1000, 9999) . "-" . random_int(1000, 9999) . "-" . random_int(1000, 9999) . "-" . random_int(1000, 9999);

      $retourOrder = [

         "contact" =>
         [
            "firstName" => $orderObject->contact->firstName,
            "lastName" => $orderObject->contact->lastName,
            "address" => $orderObject->contact->address,
            "city" => $orderObject->contact->city,
            "email"=> $orderObject->contact->email
         ],

         "products" => $products,
         "orderId" => $orderId
      ];

      $this->sendMail($retourOrder);

      return $retourOrder;
   }

   public function sendMail($retourOrder) {
      $to = $retourOrder['contact']['email'];
      $subject = "Confirmation de votre commande n° ". $retourOrder['orderId'];
      $message = "Bonjour M." . $retourOrder['contact']['lastName'] . ",\n\nVotre commande n° " . $retourOrder['orderId'] . " a bien été prise en compte.\nVous recevrez un mail à l'expédition de votre colis.\n\nCordialement\nL'équipe d'Oriteddies";
      $headers = "From : damien.pinna@gmail.com";

      mail($to, $subject, $message, $headers);
   }
}