<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<title><?php echo $title ?></title>
 <link rel="stylesheet" href="/css/different.css" />
</head>
<body>

<div id="main">
<nav>
<ul>
  <li><a href='/'>Home</a></li>
  <li><a href='/signin'>Sign in</a></li>
  <li><a href='/signup'>Sign up</a></li>
  <li><a href='/signout'>Sign out</a></li>
  <li><a href='/change'>Change password</a></li>
</ul>
</nav>


<div id='content'>
<?php
  if(!empty($flash)){
    echo "<p id='flash'>{$flash}</p>";
  }
  require VIEWS."/{$content}.php";
?>
</div> <!-- end content -->

</div> <!-- end main -->

</body>
</html>