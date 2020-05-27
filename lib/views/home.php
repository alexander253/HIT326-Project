<?php
echo "<h1>$message</h1>";

if(!empty($_SESSION["email"])){
  echo "<h2>You are currently signed in as:</h2>";
  echo $_SESSION['email'];
  echo "<h2>Your cart:</h2>";
}
  else {
    echo "You are not signed in, sign or sign up to start shopping!";}


if(!empty($_SESSION["cart"])){
  foreach($_SESSION['cart'] as $key=>$value)
    {echo $value." <br><br>";}
}
  else {echo " <br> Your cart is empty, start shopping!";}






 ?>
