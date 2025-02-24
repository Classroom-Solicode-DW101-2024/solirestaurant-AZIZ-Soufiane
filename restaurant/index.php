<?php
require 'config.php';

if(isset($_POST["btnSubmit"])){
    $nom=trim($_POST["nom"]);
    $prenom=trim($_POST["prenom"]);
    $tel=trim($_POST["tel"]);
    $tel_is_exist=tel_existe($tel);
    
    if(!empty($nom) && !empty($prenom) && !empty($tel) && empty($tel_is_exist)){
        $sql_insert_client="insert into CLIENT values(:id,:nom,:prenom,:tel)";
        $stmt_insert_client=$pdo->prepare($sql_insert_client);
        $idvalue=getLastIdClient()+1;

        $stmt_insert_client->bindParam(':id',$idvalue);
        $stmt_insert_client->bindParam(':nom',$nom);
        $stmt_insert_client->bindParam(':prenom',$prenom);
        $stmt_insert_client->bindParam(':tel',$tel);

        $stmt_insert_client->execute();
        echo '<p class="notification">Client added successfully !!</p>';
    } else {
        if(empty($nom)){
            $erreurs['nom']="Surname is required.";
        }
        if(empty($prenom)){
            $erreurs['prenom']="Name is required.";
        }
        if(empty($tel)){
            $erreurs['tel']="Phone is required.";
        }
        if(!empty($tel_is_exist)){
            $erreurs['tel']="This phone number already exists.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registration</title>
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }


        .container {
            background-color: #1f1f1f;
            border-radius: 10px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.6);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #f1f1f1;
        }

        label {
            font-size: 16px;
            color: #ddd;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"], input[type="tel"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            background-color: #333;
            border: 1px solid #444;
            border-radius: 6px;
            color: #f1f1f1;
            font-size: 16px;
        }

        input[type="text"]:focus, input[type="tel"]:focus {
            outline: none;
            border-color: #ff6347;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #ff6347;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #e5533c;
        }

        .erreur {
            color: #ff6347;
            font-size: 14px;
            text-align: center;
            margin-top: -15px;
            margin-bottom: 20px;
        }

        a {
            display: block;
            text-align: center;
            color: #4caf50;
            margin-top: 20px;
            font-size: 16px;
            text-decoration: none;
            transition: color 0.3s;
        }

        a:hover {
            color: #66bb6a;
        }

        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            display: none;
            animation: slide-up 0.5s ease-out forwards;
        }

@keyframes slide-up {
    0% {
        transform: translateY(20px);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

    </style>
</head>
<body>

<div class="container">
    <h2>Register Client</h2>
    <form method="POST">
        <label for="nom">Surname:</label>
        <input type="text" name="nom" id="nom" placeholder="Enter your surname" value="<?= isset($nom) ? $nom : ''; ?>">
        
        <label for="prenom">Name:</label>
        <input type="text" name="prenom" id="prenom" placeholder="Enter your name" value="<?= isset($prenom) ? $prenom : ''; ?>">
        
        <label for="numTel">Phone Number:</label>
        <input type="tel" name="tel" id="numTel" placeholder="Enter your phone number" value="<?= isset($tel) ? $tel : ''; ?>">
        
        <button type="submit" name="btnSubmit">Register</button>

        <?php if (isset($erreurs) && count($erreurs) > 0): ?>
            <div class="erreur">
                <?php foreach ($erreurs as $erreur): ?>
                    <p><?= $erreur ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </form>
    
    <a href="login.php">Back to log-in</a>
</div>

</body>
</html>
