<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
if ($username === 'admin' && $password === 'admin123') {
    $_SESSION['username'] = $username;
    header('Location: dashboard.php');
    exit();
} else {
echo '
    <html>
    <head>
    <style>
    body{
        background-image: url(https://files.porsche.com/filestore/image/multimedia/none/modelseries-macan3-highlights-design-exterieur/normal/dedceaf8-d4e2-11eb-80d9-005056bbdc38;sM;twebp065;c1692;gc/porsche-normal.webp);}
    .warning{
        text-align: center;
        display: block;
        position: fixed;
        top:100px;
        left:100px;
        border-radius: 20%;
        margin: 10px;
        padding: 10px;
        background: rgba(74, 74, 74, 0.408);
        color:white;
        font-weight: 700;
        width: 400px ;
        font-size: 2rem;
        height: 350px;}
        }</style>
    </head> 
    <div class="warning"><br><br><br>Invalid Username or Password.<br>Please try again.</div>
    </html>';
 exit();
}
?>