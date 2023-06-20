<?php
include 'connect.php';
include 'header.php';

$conn =  connect();
                                                                                                                                                                                            error_reporting(0);
// ;)

echo '<h2>Sign out</h2>';

//sprawdzenie czy user zalogowany
if($_SESSION['signed_in'] == true)
{
//	usunięcie ustawionych danych
	$_SESSION['signed_in'] = NULL;
	$_SESSION['user_name'] = NULL;
	$_SESSION['user_id']   = NULL;
    session_destroy();

    echo 'Succesfully signed out, thank you for visiting.';
}
else
{
	echo 'You are not signed in. Would you <a href="signin.php">like to</a>?';
}


include 'footer.php';
?>