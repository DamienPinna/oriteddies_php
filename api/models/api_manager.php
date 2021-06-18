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
         $teddies[$i]['imageUrl'] = URL."images/".$teddies[$i]['imageUrl'];
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
      $teddie['imageUrl'] = URL."images/".$teddie['imageUrl'];
      $stmt->closeCursor();
      return $teddie;
   }
}