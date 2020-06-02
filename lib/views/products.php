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

  echo "
     <form  method='POST'>
       <div class='product'>
            <input type='hidden' name='code' value= '{$productno}' />
              <ul>
                <li>Description: {$description}</li>
                <li>Price: {$price}</li>
                <li>Category: {$category}</li>
                <li>Colour: {$colour}</li>
                <li>Size: {$size}</li>
              </ul>
            <input type='submit' value='Add to cart' name='addtocart' />
          </div>
     </form>
           ";

 }
}


 else{
   echo "<h2>Product list is empty</h2>";}

   if(isset($_POST['addtocart'])) {
     session_start();
     $code = $_POST['code'];
     array_push($_SESSION['cart'],$code);
   }



 ?>
