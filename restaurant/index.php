<?php
require 'config.php';

$erreurs = [];

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
    <link rel="stylesheet" href="index.css">

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
