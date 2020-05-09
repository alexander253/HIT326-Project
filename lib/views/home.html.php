<!doctype html>
<html>
<head>
<meta charset='utf-8' />
<title>Week 4 example - Part 2</title>
</head>
<body>
<h1>Home</h1>
<p><a href='/index.html'>Team list</a></p>
<p><a href='index.php?new'>Add player</a></p>

<?php
  if($msg = get_session_message('flash')){
     echo "<p>{$msg}</p>";
  }
?>
</body>
</html>
