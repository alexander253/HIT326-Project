<h1>Change password</h1>
<h2>User name goes here</h2>
<p>See if you can this going yourself. It needs a PUT request, right? See comments in HTML code too.</p>
<div>
<!-- Think about the action? Perhaps it could be something like this "?user/6" which a bit more RESTful. -->
<form action='?change' method='POST'>
 <input type='hidden' name='_method' value='put' />
 <?php
	require PARTIALS."/form.old-password.php";
	require PARTIALS."/form.password.php";
	require PARTIALS."/form.password-confirm.php";
 ?>
 <input type='submit' value='Update' />
</form>
</div>


