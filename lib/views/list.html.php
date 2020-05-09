<!doctype html>
<html>
<head>
<meta charset='utf-8' />
<title>Week 4 example - Part 2</title>
</head>
<body>
<h1>Team List</h1>
<p><a href='?new'>Add new player</a></p>
<p><a href='index.php'>Home</a></p>

<?php
  if($msg = get_session_message('flash')){
     echo "<p>{$msg}</p>";
  }

   //Print the list of players
   if(!empty($list)){
     echo "<h2>Players</h2>";
     foreach($list As $player){
       $fname = htmlspecialchars($player['fname'],ENT_QUOTES, 'UTF-8');
       $sname = htmlspecialchars($player['sname'],ENT_QUOTES, 'UTF-8');
       $games = htmlspecialchars($player['games'],ENT_QUOTES, 'UTF-8');
	   echo "<p>{$fname}, {$sname}, {$games}</p>";
	 }
   }
   else{
     echo "<h2>Players list is empty</h2>";
   }
?>
</body>
</html>
