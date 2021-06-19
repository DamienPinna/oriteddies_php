<?php

require_once "models/model.php";
define("URL", str_replace("routes.php", "", (isset($_SERVER['HTTPS'])? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));

class ApiManager extends Model {
   
   public function getDbAllTeddies() {
      $req = "SELECT * FROM produit";
      $stmt = $this->getConnexion()->prepare($req);
      $stmt->execute();
      $teddies = $stmt->fetchAll(PDO::FETCH_ASSOC);

      for ($i=0; $i < count($teddies); $i++) {
         $teddies[$i]['imageUrl'] = URL."public/images/".$teddies[$i]['imageUrl'];
      }

      $stmt->closeCursor();
      return $teddies;
   }

   public function getDbOneTeddie($id) {
      $req = "SELECT * FROM produit WHERE id = :id";
      $stmt = $this->getConnexion()->prepare($req);
      $stmt->bindValue(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
      $teddie = $stmt->fetch(PDO::FETCH_ASSOC);
      $teddie['imageUrl'] = URL."public/images/".$teddie['imageUrl'];
      $stmt->closeCursor();
      return $teddie;
   }

   public function traitementDeLaCommande() {
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Methods: POST");
      header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");

      $order = json_decode(file_get_contents('php://input'));

      $products = [];
      foreach ($order->products as $product) {
         $products[] = $this->getDbOneTeddie($product);
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