<?php
echo "<h1>$message</h1>";


if(!empty($_SESSION["cart"])){
foreach($_SESSION['cart'] as $key=>$value)
    {
    echo "
    <ul>
      <li> Product: $value</li>
    </ul>
    "
  ;}
}
    else {echo " <br> Your cart is empty, start shopping!";}







 ?>
