<?php
echo "<h1>$message</h1>";

foreach($_SESSION['cart'] as $key=>$value)
    {
    echo $value." ";
    }


 ?>
