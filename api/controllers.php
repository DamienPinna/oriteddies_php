<?php

function getAllTeddies() {
    $pdo = getConnexion();
    $req = "SELECT * FROM produit";
    $statement = $pdo->prepare($req);
    $statement->execute();
    $res = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    sendJSON($res);
}

function getOneTeddie($id) {
    $pdo = getConnexion();
    $req = "SELECT * FROM produit WHERE id = :id";
    $statement = $pdo->prepare($req);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $statement->execute();
    $res = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    sendJSON($res);
}

function getConnexion() {
    return new PDO("mysql:host=localhost;dbname=oriteddies;charset=utf8","root","admin");
}

function sendJSON($res) {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
}