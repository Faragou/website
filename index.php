<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Webes Masodik Beadando</title>
</head>

<body>
    <h1>Faragó Patrik Bálint - ZAO46Z</h1>
    <form action="index.php" method="post">
        <label>Username:</label><br>
        <input type="text" name="username"><br>
        <label>Password:</label><br>
        <input type="password" name="password"><br>
        <input class="login" type="submit" name="login" value="Login">
    </form>

<?php
include("database.php");



//DEKÓDOLÁS
$filename = "password.txt";
$fp = fopen($filename, "r") or die("Error: Couldn't open {$filename}");
$lines = fread($fp, filesize($filename));
fclose($fp);

$lines = explode("\n", $lines);
$arr = array(5, -14, 31, -9, 3);

foreach ($lines as $password) {
    $pass = "";
    $current_index = 0;
    for ($i = 0; $i < strlen($password); $i++) {
        $char = ord($password[$i]);
        $char -= $arr[$current_index];
        $current_index++;

        $char = chr($char);
        $pass = $pass . $char;

        if ($current_index == 5) {
            $current_index = 0;
        }
    }

    $curr = explode("*", $pass);
    if (isset($curr[1])) {
        $passwords[$curr[0]] = $curr[1];
        //Ezzel tudtam ellenőrizni, hogy helyesen dekódoltam-e
        //echo "{$curr[0]}*{$curr[1]} <br>";  
    } else {
        $passwords[$curr[0]] = "";
    }
    
    /*
    katika@gmail.com*katica85
    arpi40@freemail.hu*polip
    zsanettka@hotmail.com*csillag12
    hatizsak@protonmail.com*tracking
    terpeszterez@citromail.hu*cukorka
    nagysanyi@gmail.hu*julcsika
    */
}



//SZINEK BEÁLLÍTÁSA
function getSecretColor($secret)
{
    if ($secret == "piros") {
        return "#FF0000";
    } else if ($secret == "zold") {
        return "#25FE00";
    } else if ($secret == "sarga") {
        return "#FCFE00";
    } else if ($secret == "kek") {
        return "#001BFE";
    } else if ($secret == "fekete") {
        return "#000000";
    } else if ($secret == "feher") {
        return "#FFFFFF";
    }
}



// Lekérdezés és helyes adatok esetén a szín beállítása
echo "<div class='scrpt'>";
if (isset($_POST["login"])) {

    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (array_key_exists($username, $passwords)) {

            if ($passwords[$username] == $password) {
                echo "Login successful. <br>";
                $sql = "SELECT * FROM tabla WHERE Username = '{$username}'";
                $result = mysqli_query($connection, $sql);
                $secret = mysqli_fetch_assoc($result)["Titkos"];
                $color = getSecretColor($secret);
            } else {
                echo "Error: Incorrect password.";
                echo ("<script>setTimeout(function(){location.href='https://www.police.hu/'} , 3000);</script>");
            }
        } else {
            echo "Error: No such username {$username}.";
        }
    } else {
        echo "Error: Missing username or password. <br>";
    }
}
echo "</div>";

mysqli_close($connection);

?>

    <style>
        body {
            /*Itt állítjuk be a háttér színét*/
            background-color: <?php echo $color; ?> !important;
        }
    </style>
</body>

</html>
