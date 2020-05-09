<h1>Sign up</h1>
<div>
<form action='?signup' method='POST'>
 <input type='hidden' name='_method' value='post' />
 <?php
    require PARTIALS."/form.email.php";
    require PARTIALS."/form.fname.php";
    require PARTIALS."/form.lname.php";
    require PARTIALS."/form.title.php";
    require PARTIALS."/form.address.php";
    require PARTIALS."/form.city.php";
    require PARTIALS."/form.state.php";
    require PARTIALS."/form.country.php";
    require PARTIALS."/form.postcode.php";
    require PARTIALS."/form.phone.php";

	require PARTIALS."/form.password.php";
	require PARTIALS."/form.password-confirm.php";

 ?>
 <input type='submit' value='Sign up' />
</form>
</div>
