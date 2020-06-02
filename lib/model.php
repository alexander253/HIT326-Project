<?php

#get database connection
function get_db(){
    $db = null;
    try{
        $db = new PDO('mysql:host=localhost:3308;dbname=art_db', 'root','hit325');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        // notice how we THROW the exception. You can catch this in your controller code in the usual way
        throw new Exception("Something wrong with the database: ".$e->getMessage());
    }
    return $db;
}


#add to cart function
function addtocart(){
  if(isset($_POST['addtocart'])) {
    session_start();
    $code = $_POST['code'];
    array_push($_SESSION['cart'],$code);
  }
}

#get all cart items and return into "list" for later use
function cart(){
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
      return $list;
    }
  }
}

#Add product
function addproduct( $description, $price, $category, $colour, $size){
    $db = get_db();
    $query = "INSERT INTO product (description, price, category, colour, size) VALUES (?,?,?,?,?)";
    $statement = $db->prepare($query);
    $binding = array($description, $price, $category, $colour, $size);
    $statement -> execute($binding);
}

#place order stores data into "purchase" and "purchaseitem" tables
function placeorder($date, $email, $purchaseno, $itemno, $productno){
    session_start();
    $db = get_db();

    #store purchase number,date and email into database
    $query1 = "INSERT INTO purchase (purchaseno, date, email) VALUES (?,?,?)";
    $statement = $db->prepare($query1);
    $binding = array($purchaseno, $date, $email);
    $statement -> execute($binding);

    #generate random number for item number
    $autogen= mt_rand(1,255);
    #iterate through cart array and store each item into database
    if(!empty($_SESSION["cart"])){
    foreach($_SESSION['cart'] as $key=>$value)
        { $productno= $value;
          $itemno= $autogen;

    $query2 = "INSERT INTO purchaseitem (itemno, purchaseno, productno) VALUES (?,?,?)";
    $statement = $db->prepare($query2);
    $binding = array($itemno, $purchaseno, $productno);
    $statement -> execute($binding);

      }
    }
  }

#get all product items from database
function product_list(){
  try{
    $db = get_db();
    $query = "SELECT productno, description, price, category, colour, size FROM product";
    $statement = $db->prepare($query);
    $statement ->execute();
    $list = $statement->fetchall(PDO::FETCH_ASSOC);
    return $list;
  }
  catch(PDOException $e){
    throw new Exception($e->getMessage());
    return "";
  }
  }

#get all account details from database
  function my_account(){
    session_start();
    try{
      $db = get_db();
      $query = "SELECT email,fname,lname,title,address,city,state,country,postcode,phone,salt,hashed_password FROM customer where email = ? ";
      $statement = $db->prepare($query);
      $email= $_SESSION["email"];
      $binding = array($email);
      $statement -> execute($binding);
      $list = $statement->fetchall(PDO::FETCH_ASSOC);
      return $list;
    }
    catch(PDOException $e){
      throw new Exception($e->getMessage());
      return "";
    }
    }

#signup function
  function sign_up($email,$fname, $lname, $title, $address, $city, $state, $country, $postcode, $phone, $password, $password_confirm){
     try{
       $db = get_db();

       if(validate_user_name($db,$email) && validate_passwords($password,$password_confirm)){
            $salt = generate_salt();
            $password_hash = generate_password_hash($password,$salt);
            $query = "INSERT INTO customer (email,fname,lname,title,address,city,state,country,postcode,phone,salt,hashed_password) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            if($statement = $db->prepare($query)){
               $binding = array($email,$fname, $lname, $title, $address, $city, $state, $country, $postcode, $phone,$salt,$password_hash);
               if(!$statement -> execute($binding)){
                   throw new Exception("Could not execute query.");
               }
            }
            else{
              throw new Exception("Could not prepare statement.");
            }
       }
       else{
          throw new Exception("Invalid data.");
       }
     }
     catch(Exception $e){
         throw new Exception($e->getMessage());
     }
  }

function get_user_id(){
   $id="";
   session_start();
   if(!empty($_SESSION["id"])){
      $id = $_SESSION["id"];
   }
   session_write_close();
   return $id;
}

function get_user_name(){
   $email="";
   $name="";
   session_start();
   if(!empty($_SESSION["email"])){
      $email = $_SESSION["email"];
   }
   session_write_close();

   try{
      $db = get_db();
      $query = "SELECT fname FROM customer WHERE email=?";
      if($statement = $db->prepare($query)){
         $binding = array($email);
         if(!$statement -> execute($binding)){
                 throw new Exception("Could not execute query.");
         }
         else{
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $name = $result['name'];

         }
      }
      else{
            throw new Exception("Could not prepare statement.");
      }

   }
   catch(Exception $e){
      throw new Exception($e->getMessage());
   }
   return $name;
}

#sign in function with cart array intiated
function sign_in($user_name,$password){
   try{
      $db = get_db();
      $query = "SELECT email, salt, hashed_password FROM customer WHERE email=?";
      if($statement = $db->prepare($query)){
         $binding = array($user_name);
         if(!$statement -> execute($binding)){
                 throw new Exception("Could not execute query.");
         }
         else{
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $salt = $result['salt'];
            $hashed_password = $result['hashed_password'];
            if(generate_password_hash($password,$salt) !== $hashed_password){
                throw new Exception("Account does not exist!");
            }
            else{
               $email = $result["email"];
               $cart = array();
               set_authenticated_session($email,$hashed_password, $cart);
            }
         }
      }
      else{
            throw new Exception("Could not prepare statement.");
      }
   }
   catch(Exception $e){
      throw new Exception($e->getMessage());
   }
}

#checks if database is empty
function is_db_empty(){
   $is_empty = false;
   try{
      $db = get_db();
      $query = "SELECT email FROM customer WHERE email=?";
      if($statement = $db->prepare($query)){
	     $email="god@hotmail.com";
         $binding = array($email);
         if(!$statement -> execute($binding)){
                 throw new Exception("Could not execute query.");
         }
         else{
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if(empty($result)){
	          $is_empty = true;
            }
         }
      }
      else{
            throw new Exception("Could not prepare statement.");
      }
   }
   catch(Exception $e){
      throw new Exception($e->getMessage());
   }
   return $is_empty;

}

#added cart array
function set_authenticated_session($email, $password_hash, $cart){
      session_start();
      //Make it a bit harder to session hijack
      session_regenerate_id(true);
      $_SESSION["email"] = $email;
      $_SESSION["hash"] = $password_hash;
      $_SESSION["cart"] = $cart;
      session_write_close();
}

function generate_password_hash($password,$salt){
      return hash("sha256", $password.$salt, false);
}

function generate_salt(){
    $chars = "0123456789ABCDEF";
    return str_shuffle($chars);
}

#not implemented
function validate_user_name($db,$user_name){
    return true;
}

function validate_passwords($password, $password_confirm){
   if($password === $password_confirm && validate_password($password)){
      return true;
   }
   return false;
}

#not implemented
function validate_password($password){
  return true;
}


function is_authenticated(){
    $email = "";
    $hash="";
    session_start();
    if(!empty($_SESSION["email"]) && !empty($_SESSION["hash"] )){
       $email = $_SESSION["email"];
       $hash = $_SESSION["hash"];
    }
    session_write_close();

    if(!empty($email) && !empty($hash)){

        try{
           $db = get_db();
           $query = "SELECT hashed_password FROM customer WHERE email=?";
           if($statement = $db->prepare($query)){
             $binding = array($email);
             if(!$statement -> execute($binding)){
                return false;
             }
             else{
                 $result = $statement->fetch(PDO::FETCH_ASSOC);
                 if($result['hashed_password'] === $hash){
                   return true;
                 }
             }
           }

        }
        catch(Exception $e){
           throw new Exception("Authentication not working properly. {$e->getMessage()}");
        }

    }
    return false;

}

function sign_out(){
    session_start();
    if(!empty($_SESSION["email"]) && !empty($_SESSION["hash"])){
       $_SESSION["email"] = "";
       $_SESSION["hash"] = "";
       $_SESSION = array();
       session_destroy();
    }
    session_write_close();
}
