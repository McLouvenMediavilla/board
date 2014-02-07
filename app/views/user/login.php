<h1>User Login</h1>
<?php if ($user->hasError()): ?>
<div class="alert alert-block">
    <h5 class="alert-heading">Incorrect username/password.</h5>
</div>
<?php endif ?>

<form class="well" method="post" action="<?php eh(url('user/login')) ?>">
	<label>Username</label>
	<input type="text" class="span2" name="username" value="<?php eh(Param::get('username')) ?>">
	<label>Password</label>
	<input type="password" class="span2" name="password" value="<?php eh(Param::get('password')) ?>">
	<br />
	<input type="hidden" name="page_next" value="login_end">
	<button type="submit" class="btn btn-primary">Submit</button>
	<a class="btn btn-primary" href="<?php eh(url('user/register')) ?>">Register</a>
</form>