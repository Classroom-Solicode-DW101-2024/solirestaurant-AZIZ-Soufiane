<?php 

require "config.php";
if(isset($_POST["submit"])){
    $tel = $_POST["tel"];
    $result = tel_existe($tel);
    if(empty($result)){
        header("Location:register.php");
    } else {
        $_SESSION["client"] = $result;
        $_SESSION["isLogin"] = true ;
        header("Location:home.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Log In</title>

</head>
<body>

<div class="container">
    <img src="images/logo.png" alt="">
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
