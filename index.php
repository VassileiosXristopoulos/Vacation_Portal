<?php 
require('header.php');
require('login.php');
?>
<!-- Form for logging in the users -->

<div class="register-form">

    <h1>Login</h1>
    <p>Please login to continue</p>
    <form action="" method="POST">
        <p><label>User Name : </label>
        <input id="username" type="text" name="username" required placeholder="username" /></p>

        <p><label>Password&nbsp;&nbsp; : </label>
        <input id="password" type="password" name="password" required placeholder="password" /></p>

        <input class="btn" type="submit" name="submit" value="Login" />
    </form>
</div>

<?php
require('footer.php');