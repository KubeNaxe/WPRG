<?php
include 'connect.php';
include 'header.php';

$conn =  connect();

echo '<h3>Sign up</h3><br />';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
//    formularz nie wysłany, wyświetl go
    echo '<form method="post" action="">
 	 	Username: <input type="text" name="user_name" /><br />
 		Password: <input type="password" name="user_pass"><br />
		Password again: <input type="password" name="user_pass_check"><br />
		E-mail: <input type="email" name="user_email"><br />
 		<input type="submit" value="Add category" />
 	 </form>';
}
else
{
//    		formularz nie wysłany, wyświetl go
//		1.	sparwadzenie danych
//		2.	pozwolenie user'owi na poprawę błędów
//		3.	zapis danych

	$errors = array();
	
	if(isset($_POST['user_name']))
	{
//		ten user_name już istnieje
		if(!ctype_alnum($_POST['user_name']))
		{
			$errors[] = 'The username can only contain letters and digits.';
		}
		if(strlen($_POST['user_name']) > 30)
		{
			$errors[] = 'The username cannot be longer than 30 characters.';
		}
	}
	else
	{
		$errors[] = 'The username field must not be empty.';
	}
	
	
	if(isset($_POST['user_pass']))
	{
		if($_POST['user_pass'] != $_POST['user_pass_check'])
		{
			$errors[] = 'The two passwords did not match.';
		}
	}
	else
	{
		$errors[] = 'The password field cannot be empty.';
	}

//	sprawdzenie tablicy
	if(!empty($errors))
	{
//		wstawka z Wiedźmina
		echo 'O zaraza... a couple of fields are not filled in correctly..<br /><br />';
		echo '<ul>';

//			sprawdzenie całej tablicy pod względem błędów
		foreach($errors as $key => $value)
		{
//			znowu ładna ponoć lista błędów hah
			echo '<li>' . $value . '</li>';
		}
		echo '</ul>';
	}
	else
	{
//    		zapis danych
		$sql = "INSERT INTO users(user_name, user_pass, user_email ,user_date, user_level) VALUES (\"{$_POST['user_name']}\", \"{$_POST['user_pass']}\", \"{$_POST['user_email']}\", NOW(), 0)";
		$result = $conn->query($sql);

		if(!$result)
		{
			echo 'Something went wrong while registering. Please try again later.';
		}
		else
		{
			echo 'Succesfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)';
		}
	}
}

include 'footer.php';
?>
