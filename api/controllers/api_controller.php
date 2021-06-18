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

}