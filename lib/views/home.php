<?php
echo "<h1>$message</h1>";

if(!empty($_SESSION["email"])){
  echo "<h2>You are currently signed in as:</h2>";
  echo $_SESSION['email'];
  echo "<h2>Your cart:</h2>";
}
  else {
    echo "You are not signed in, sign or sign up to start shopping!";}

#Display cart items
session_start();
if(!empty($_SESSION["cart"])){
  foreach($_SESSION['cart'] as $key=>$value)
        {
          $db = get_db();
          $query = "SELECT description, price FROM product where productno = ? ";
          $statement = $db->prepare($query);
          $productno= $value;
          $binding = array($value);
          $statement -> execute($binding);
          $list = $statement->fetchall(PDO::FETCH_ASSOC);


    foreach($list As $product){
          $description = htmlspecialchars($product['description'],ENT_QUOTES, 'UTF-8');
          $price = htmlspecialchars($product['price'],ENT_QUOTES, 'UTF-8');

              echo "
                      <ul>
                         <li>Description: {$description}</li>
                         <li>Price: {$price}</li>
                       </ul>
                    ";}
      ;}
    }
  else {echo " <br> Your cart is empty, start shopping!";}






 ?>
