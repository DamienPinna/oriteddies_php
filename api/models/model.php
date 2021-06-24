<?php

// require_once "config/config.php";

abstract class Model {
   private static $pdo;

   private static function setDB() {
      self::$pdo = new PDO("mysql:host=localhost;dbname=oriteddies;charset=utf8","root","admin");
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   }

   protected function getConnexion() {
      if (self::$pdo === null) self::setDB();
      return self::$pdo;
   }

   public static function sendJSON($data) {
      header("Access-Control-Allow-Origin: *");
      header("Content-Type: application/json");
      echo json_encode($data);
   }
}