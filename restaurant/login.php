<?php 

require "config.php";
if(isset($_POST["submit"])){
    $tel = $_POST["tel"];
    $result = tel_existe($tel);
    if(empty($result)){
        header("Location:register.php");
    } else {
        $_SESSION["client"] = $result;
        header("Location:home.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
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

        input[type="tel"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            background-color: #333;
            border: 1px solid #444;
            border-radius: 6px;
            color: #f1f1f1;
            font-size: 16px;
        }

        input[type="tel"]:focus {
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
    </style>
</head>
<body>

<div class="container">
    <h2>Log In</h2>
    <form method="POST">
        <label for="tel">Phone Number:</label>
        <input type="tel" id="tel" name="tel" required placeholder="Enter your phone number">
        
        <button type="submit" name="submit">Log In</button>
    </form>
    
    <a href="index.php"> Don't have an account ?</a>
</div>

</body>
</html>
