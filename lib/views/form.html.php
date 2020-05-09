<!doctype html>
<html>
<head>
<meta charset='utf-8' />
<title>Week 4 example - Part 2</title>
</head>
<body>
<h1>Add player</h1>
<p><a href='/'>Team list</a></p>
<p><a href='/'>Home</a></p>

<?php
  if($msg = get_session_message('flash')){
     echo "<p>{$msg}</p>";
  }
?>

<form action='?new' method='POST'>
 <input type='hidden' name='_method' value='post' />


 <label for='productno'>Productno</label>
 <input type='text' id='productno' name='productno' />

 <label for='description'>description</label>
 <input type='text' id='description' name='description' />

 <label for='price'>price</label>
 <input type='number' id='price' name='price' />


 <label for='category'>Category</label>
 <input type='text' id='category' name='category' />

 <label for='colour'>colour</label>
 <input type='text' id='colour' name='colour' />

 <label for='size'>size</label>
 <input type='text' id='size' name='size' />

 <input type='submit' value='Create new user' />
</form>


</body>
</html>
