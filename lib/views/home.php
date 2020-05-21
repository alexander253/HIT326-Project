<?php
echo "<h1>$message</h1>";
echo "<h2>You are currently signed in as:</h2>";
echo $_SESSION['email'];
echo "<h2>Your cart:</h2>";

foreach($_SESSION['cart'] as $key=>$value)
    {
    echo $value." ";
    }





    if(isset($_POST['addtocart'])) {
      session_start();
      $doggo= "daisy";
      array_push($_SESSION['cart'],$doggo);

 }

 ?>

 <form  method='POST'>
    <input type='submit' value='Add to cart' name="addtocart" />
 </form>
