<?php
require_once '../admin/header.php';

$page = 'login';
//see if a password was entered and save value
$password = $_POST['password'] ?? '';

//if the password matches value or if the page is alread logged in set cookie and redirect to index page
if ($password == 'IamachildofGod' || loggedIn($page)) {
    setcookie('loggedIn', true, time() + 3600);
    header('Location: index.php');
    exit;
}

?>

<div class="content center-text above-center">
    <h1>Hyrum 16th Ward Primary Substitutes</h1>
    <h2>Please enter the password to generate a sub list.</h2>
    <form action="login.php" method="post">
        <input type="password" name="password">
        <input type="submit" value="Login">
    </form>
    <p>This is not an official website of The Church of Jesus Christ of Latter-Day Saints and is only for Church use in finding substitutes teachers for ward primary classes. </p>
</div><!-- end .content -->

<?php require_once '../admin/footer.php'; ?>