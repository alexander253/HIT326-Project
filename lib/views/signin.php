<h1>Sign in</h1>
<div>
<form action='/signin' method='POST'>
 <input type='hidden' name='_method' value='post' />
 <?php
    require PARTIALS."/form.name.php";
	require PARTIALS."/form.password.php";
 ?>
 <input type='submit' value='Sign in' />
</form>
</div>


