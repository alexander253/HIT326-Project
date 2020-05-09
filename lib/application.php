<?php
/* DEFINE THE CALLBACKS HERE */
function get($route,$callback){
   if($route === get_request() && get_method() === "GET"){
     echo $callback($route);
   }
   else{
      return false;
   }
}

function post($route,$callback){
   if($route === get_request() && get_method() === "POST"){
     echo $callback($route);
   }
   else{
      return false;
   }
}

function put($route,$callback){
   if($route === get_request() && get_method() === "PUT"){
     echo $callback($route);
   }
   else{
      return false;
   }
}

# The DELETE callback is left to you to work out

# We need this for when none of the routes match or some other problem i.e. "page not found"
function error_404($callback){
	echo $callback();
}


/* Application functions called by the controller code */
function render($messages, $layout, $content){

   foreach($messages As $key => $val){
       $$key = $val;
   }

   $flash = get_flash(kkkk);

   if(!empty($layout)){
      require VIEWS."/{$layout}.layout.php";
   }
   else{
      // What is this part for? When would we not need a layout? Think about it.
   }
   exit();
}

function get_request(){
  return $_SERVER['REQUEST_URI'];
}

function force_to_https($path="/"){
    if(!(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']==='on')){
       $host = $_SERVER['HTTP_HOST'];
       $redirect_to_path = "https://".$host.$path;
       redirect_to($redirect_to_path);
       exit();
    }
}

function force_to_http($path="/"){
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']==='on'){
       $host = $_SERVER['HTTP_HOST'];
       $redirect_to_path = "http://".$host.$request;
       redirect_to($redirect_to_path);
       exit();
    }
}

function get_method(){
   if(strtoupper(form("_method")) === strtoupper("post")){
      return "POST";
   }
   if(strtoupper(form("_method")) === strtoupper("put")){
      return "PUT";
   }
   if(strtoupper(form("_method")) === strtoupper("delete")){
      return "DELETE";
   }
   return "GET";
}

function form($key){
   if(!empty($_POST[$key])){
      return $_POST[$key];
   }
   return false;
}

function redirect_to($path="/"){
   header("Location: {$path}");
   exit();
}

function set_session_message($key,$message){
   if(!empty($key) && !empty($message)){
      session_start();
      $_SESSION[$key] = $message;
      session_write_close();
   }
}

function get_session_message($key){
   $msg = "";
   if(!empty($key) && is_string($key)){
      session_start();
      if(!empty($_SESSION[$key])){
         $msg = $_SESSION[$key];
         unset($_SESSION[$key]);
      }
      session_write_close();
   }
   return $msg;
}

function set_flash($msg){
      set_session_message("flash",$msg);
}

function get_flash($msg){
      return get_session_message("flash");
}
