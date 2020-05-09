<?php
# Set to noisy error reporting for development. Comment out later for production mode.
ini_set('display_errors','On');
error_reporting(E_ERROR | E_PARSE);

# Paths
DEFINE("LIB",$_SERVER['DOCUMENT_ROOT']."/../lib");
DEFINE("VIEWS",LIB."/views");
DEFINE("PARTIALS",VIEWS."/partials");


# Paths to actual files
DEFINE("MODEL",LIB."/model.php");
DEFINE("APP",LIB."/application.php");


# Define a layout
DEFINE("LAYOUT","standard");

# This inserts our application code which handles the requests and other things
require APP;

#Global, damn it! Oh well we'll take care of this somehow later on ... stay tuned.
$messages = array();

# Below are all the request handlers written as callbacks

get("/",function(){
   force_to_http("/?index");
   $messages["title"]="Home";
   $messages["message"]="Welcome";
   render($messages,LAYOUT,"home");
});

get("/?products",function(){
   force_to_http("/?products");
   $messages["title"]="Products";
   $messages["message"]="These are the products";
   render($messages,LAYOUT,"form.html");
});


get("/?signin",function(){
   force_to_http("/?signin");
   $messages["title"]="Sign in";
   require MODEL;
   try{
     if(is_authenticated()){
        set_flash("Why on earth do you want to sign in again. You are already signed in. Perhaps you want to sign out first.");
     }

   }
   catch(Exception $e){
       set_flash($e->getMessage());
   }
   render($messages,LAYOUT,"signin");
});

get("/?signup",function(){
   force_to_http("/?signup");
   require MODEL;
   $messages["title"]="Sign up";
   try{
     if(is_authenticated()){
        set_flash("You are already signed in. Why do you want to sign up? Do you want another account? OK then ... who am I to complain!");
     }
   }
   catch(Exception $e){
       set_flash($e->getMessage());
   }
   render($messages,LAYOUT,"signup");
});

get("/?change",function(){
   force_to_http("/?change");
   $messages["title"]="Change password";
   render($messages,LAYOUT,"change_password");
});


get("/?signout",function(){
   // should this be GET or POST or PUT?????
   force_to_http("/?signout");
   require MODEL;
   if(is_authenticated()){
      try{
         sign_out();
         set_flash("You are now signed out.");
         redirect_to("/");
      }
      catch(Exception $e){
        set_flash("Something wrong with the sessions.");
        redirect_to("/");
     }
   }
   else{
        set_flash("You can't sign out if you are not signed in!");
        redirect_to("/?signin");
   }



});



post("/?new",function(){
  $productno = form('productno');
  $description = form('description');
  $price = form('price');
  $category = form('category');
  $colour = form('colour');
  $size = form('size');


  if($productno && $description && $price && $category && $colour && $size ){
     require MODEL;
     try{
        new_product($productno,$description,$price,$category,$colour,$size);
        set_flash("congrats u added a product, ".htmlspecialchars(form('fname'))." Now sign in!");
     }
     catch(Exception $e){
          set_flash($e->getMessage());
          redirect_to("/");
     }
  }
  else{
     set_flash("You are not signed up. Try again and don't leave any fields blank.");
     redirect_to("/");
  }
  redirect_to("/");
});








post("/?signup",function(){
  $email = form('email');
  $fname = form('fname');
  $lname = form('fname');
  $title = form('title');
  $address = form('address');
  $city = form('city');
  $state = form('state');
  $country = form('country');
  $postcode = form('postcode');
  $phone = form('phone');

  $pw = form('password');
  $confirm = form('password-confirm');

  if($email && $fname && $lname && $title && $address && $city && $state && $country && $postcode && $phone && $pw && $confirm){
     require MODEL;
     try{
        sign_up($email,$fname, $lname, $title, $address, $city, $state, $country, $postcode, $phone,$pw,$confirm);
        set_flash("Lovely, you are now signed up, ".htmlspecialchars(form('fname'))." Now sign in!");
     }
     catch(Exception $e){
          set_flash($e->getMessage());
          redirect_to("/?signup");
     }
  }
  else{
     set_flash("You are not signed up. Try again and don't leave any fields blank.");
     redirect_to("/?signup");
  }
  redirect_to("/?signin");
});

post("/?signin",function(){
  $email = form('email');
  $password = form('password');
  if($email && $password){
    require MODEL;
    try{
       sign_in($email,$password);
    }
    catch(Exception $e){
      set_flash("Could not sign you in. Try again. {$e->getMessage()}");
      redirect_to("/?signin");
    }
  }
  else{
       set_flash("Something wrong with name or password. Try again.");
       redirect_to("/?signin");
  }
  set_flash("Lovely, you are now signed in!");
  redirect_to("/");
});

put("/?change",function(){
  // Not complete of course
  set_flash("Password is changed");
  redirect_to("/");
});

# The Delete call back is left for you to work out

# This function is automatically run if the scrupt gets this far
error_404(function(){
    header("HTTP/1.0 404 Not Found");
    render($messages,LAYOUT,"404");
});




#Try list products


if(isset($_GET['new'])){
    require LIB.'/views/form.html.php';
	exit();
}


if(isset($_GET['list'])){
   $errors = array();
   $db = get_db($errors);
   if(!$db){
      $errors[] = "Can't get database connection.";
      require LIB.'/views/db_error.html.php';
	  exit();
   }
   $list = null;
   try{
       $query = "SELECT fname,sname,games FROM players";
       $statement = $db->prepare($query);
       $statement -> execute();
       $list = $statement->fetchall(PDO::FETCH_ASSOC);
       require LIB.'/views/list.html.php';
   }
   catch(PDOException $e){
      $errors[] = "Problem with query: {$e->getMessage()}.";
      require LIB.'/views/db_error.html.php';
	  exit();

   }
   exit();
}


if(isset($_POST['_method']) && $_POST['_method']=='post'){
   if(!empty($_POST['fname']) && !empty($_POST['sname']) && !empty($_POST['games'])){
         $db = get_db();
         if(!$db){
            set_session_message("flash","Problem with database - new player cannot be created");
            header('Location: index.php?new');
            exit();
         }
         $fname = $_POST['fname'];
         $sname = $_POST['sname'];
         $games = $_POST['games'];
         try{
           $query = "INSERT INTO players (fname,sname,games) VALUES (?,?,?)";
           $statement = $db->prepare($query);
           $binding = array($fname,$sname,$games);
           $statement -> execute($binding);
         }
         catch(PDOException $e){
           set_session_message("flash","Problem with database: {$e->getMessage()}");
           header('Location: index.php?new');
           exit();

         }
         set_session_message("flash","New player has been created.");
         header('Location: index.php?new');

         exit();
    }
    else{
       set_session_message("flash","Unable to create new player. Did you fill out all the fields?");
       header('Location: index.php?new');
       exit();
    }

}


require LIB.'/views/home.html.php';
