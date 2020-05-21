<?php
echo "<h1>$message</h1>";

 //Print the list of products
 if(!empty($list)){
   foreach($list As $product){
     $productno = htmlspecialchars($product['productno'],ENT_QUOTES, 'UTF-8');
     $description = htmlspecialchars($product['description'],ENT_QUOTES, 'UTF-8');
     $price = htmlspecialchars($product['price'],ENT_QUOTES, 'UTF-8');
     $category= htmlspecialchars($product['category'],ENT_QUOTES, 'UTF-8');
     $colour = htmlspecialchars($product['colour'],ENT_QUOTES, 'UTF-8');
     $size = htmlspecialchars($product['size'],ENT_QUOTES, 'UTF-8');
     if(isset($_POST['addtocart'])) {
       session_start();
       array_push($_SESSION['cart'],$description);
  }


   echo "<p>{$productno}, {$description}, {$price},{$category},{$colour}, {$size}, </p>";
   echo "<form  method='POST'>
      <input type='submit' value='Add to cart' name='addtocart' />
   </form>";

 }
}

 else{
   echo "<h2>Product list is empty</h2>";}



 ?>

<form  method='POST'>
  <input type='submit' value='Add to cart' name="addtocart" />
</form>
