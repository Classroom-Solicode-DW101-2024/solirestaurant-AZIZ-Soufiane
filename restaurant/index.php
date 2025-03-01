<?php
require 'config.php';

$erreurs = []; // Initialize error array

if (isset($_POST["btnSubmit"])) {
    $nom = trim($_POST["nom"] ?? '');
    $prenom = trim($_POST["prenom"] ?? '');
    $tel = trim($_POST["tel"] ?? '');
    $tel_is_exist = tel_existe($tel);

    if (empty($nom)) {
        $erreurs['nom'] = "Surname is required.";
    }
    if (empty($prenom)) {
        $erreurs['prenom'] = "Name is required.";
    }
    if (empty($tel)) {
        $erreurs['tel'] = "Phone number is required.";
    } elseif (!empty($tel_is_exist)) {
        $erreurs['tel'] = "This phone number already exists.";
    }

    if (empty($erreurs)) {
        $sql_insert_client = "INSERT INTO CLIENT VALUES (:id, :nom, :prenom, :tel)";
        $stmt_insert_client = $pdo->prepare($sql_insert_client);
        $idvalue = getLastIdClient() + 1;

        $stmt_insert_client->execute([
            ':id' => $idvalue,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':tel' => $tel
        ]);

        echo '<p class="notification">Client added successfully!</p>';
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
        /* Global Styles */
        body {
            background-color: #121212;
            color: #e0e0e0;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Container */
        .container {
            background-color: #1f1f1f;
            border-radius: 10px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.6);
            text-align: center;
        }

        .container img {
            width: 80px;
            margin-bottom: 15px;
        }

        /* Form Styling */
        label {
            font-size: 16px;
            color: #ddd;
            margin-bottom: 8px;
            display: block;
            text-align: left;
        }

        input[type="text"], input[type="tel"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            background-color: #333;
            border: 1px solid #444;
            border-radius: 6px;
            color: #f1f1f1;
            font-size: 16px;
            transition: 0.3s;
        }

        input[type="text"]:focus, input[type="tel"]:focus {
            border-color: #ff6347;
            outline: none;
            background-color: #2a2a2a;
        }

        /* Button */
        button {
            width: 100%;
            padding: 14px;
            background-color: #ff6347;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #e5533c;
            transform: scale(1.05);
        }

        /* Error Messages */
        .erreur {
            color: #ff6347;
            font-size: 14px;
            text-align: center;
            margin: 10px 0;
            background: rgba(255, 99, 71, 0.1);
            padding: 8px;
            border-radius: 5px;
        }

        /* Notification Message */
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #4caf50;
            color: white;
            padding: 12px 20px;
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

        /* Back to login link */
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
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var notification = document.querySelector(".notification");
            if (notification) {
                notification.style.display = "block";
                setTimeout(() => {
                    notification.style.display = "none";
                }, 3000);
            }
        });
    </script>
</head>
<body>

<div class="container">
    <img src="images/logo.png" alt="Logo">
    <h2>Register Client</h2>

    <form method="POST">
        <label for="nom">Surname:</label>
        <input type="text" name="nom" id="nom" placeholder="Enter your surname" value="<?= htmlspecialchars($nom ?? '') ?>">

        <label for="prenom">Name:</label>
        <input type="text" name="prenom" id="prenom" placeholder="Enter your name" value="<?= htmlspecialchars($prenom ?? '') ?>">

        <label for="tel">Phone Number:</label>
        <input type="tel" name="tel" id="tel" placeholder="Enter your phone number" value="<?= htmlspecialchars($tel ?? '') ?>">

        <button type="submit" name="btnSubmit">Register</button>

        <?php if (!empty($erreurs)): ?>
            <div class="erreur">
                <?php foreach ($erreurs as $erreur): ?>
                    <p><?= htmlspecialchars($erreur) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </form>

    <a href="login.php">Back to log-in</a>
</div>

</body>
</html>
