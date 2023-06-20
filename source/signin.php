<?php
include 'connect.php';
include 'header.php';

$conn =  connect();


echo '<h3>Sign in</h3><br />';

//sprawdzenie czy user jest signed in
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
}
else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
        //    formularz nie wysłany, wyświetl go
        echo '<form method="post" action="">
			Username: <input type="text" name="user_name" /><br />
			Password: <input type="password" name="user_pass"><br />
			<input type="submit" value="Sign in" />
		 </form>';
	}
	else
	{

//			1.	Sprawdzenie danych
//			2.	Poprawienie błędnie wprowadzonych danych
//			3.	Sprawdzenie czy dane są poprawne, wyświetlenie odpowiedzi

		$errors = array();
		
		if(!isset($_POST['user_name']))
		{
			$errors[] = 'The username field must not be empty.';
		}
		
		if(!isset($_POST['user_pass']))
		{
			$errors[] = 'The password field must not be empty.';
		}


//      sprawdzenie tablicy
		if(!empty($errors))
		{
			echo 'Uh-oh.. a couple of fields are not filled in correctly..<br /><br />';
			echo '<ul>';

//          sprawdzenie całej tablicy pod względem błędów
			foreach($errors as $key => $value)
			{
//                ładna lista błędów ponoć hah
				echo '<li>' . $value . '</li>';
			}
			echo '</ul>';
		}
		else
		{
//			formularz bezbłedów
			$sql = "SELECT * FROM users WHERE user_name = \"{$_POST['user_name']}\"";
            $result = $conn->query($sql);
			if(!$result)
			{
				echo 'Something went wrong while signing in. Please try again later.';
			}
			else
			{
//				1. zapytanie zwróciło dane, można zrobić login
//				2. zapytanie zwróciło pusty result, złe dane
				if(mysqli_num_rows($result) == 0)
				{
					echo 'You have supplied a wrong user/password combination. Please try again.';
				}
				else
				{
//					ustawienie $_SESSION['signed_in'] true, user jest zalogowany
					$_SESSION['signed_in'] = true;
					
//					ustawienie user_id oraz user_name wartości w $_SESSION, do użytku na wszystkich podstronach
					while($row = mysqli_fetch_assoc($result))
					{
						$_SESSION['user_id'] 	= $row['user_id'];
						$_SESSION['user_name'] 	= $row['user_name'];
						$_SESSION['user_level'] = $row['user_level'];
					}
					
					echo 'Welcome, ' . $_SESSION['user_name'] . '. <br /><a href="index.php">Proceed to the forum overview</a>.';
				}
			}
		}
	}
}

include 'footer.php';
?>