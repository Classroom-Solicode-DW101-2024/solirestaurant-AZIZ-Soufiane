<?php
session_start();
$host = 'localhost';
$dbname = 'SoliRestaurant';
$username = 'root';
$password = '';

try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Échec de la connexion : " . $e->getMessage());
}


function getLastIdClient() {
    global $pdo;
        $sql = "SELECT MAX(idClient) AS maxId FROM client";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result= $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($result(['maxId']))) {
            $MaxId = 0;
        } else {
            $MaxId = $result['maxId'];
        }
        return $MaxId;
    }

function tel_existe($tel){
    global $pdo;
    $sql = "SELECT * FROM client where telCl=:tel";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tel', $tel);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}


?>