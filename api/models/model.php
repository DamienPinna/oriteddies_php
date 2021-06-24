<?php

abstract class Model {
   private static $pdo;

   private static function setDB() {
      self::$pdo = new PDO("mysql:host=".HOST_NAME.";dbname=".DB_NAME.";charset=utf8",USER_NAME,PASSWORD);
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