<?php
include 'connect.php';
include 'header.php';

$conn =  connect();
																																																				error_reporting(0);


echo '<h2>Create a category</h2>';
if($_SESSION['signed_in'] == false | $_SESSION['user_level'] != 1 )
{
	//użytkownik nie jest adminem
	echo 'Sorry, you do not have sufficient rights to access this page.';
}
else
{
	//użytkownik jest adminem
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
//    formularz nie wysłany, wyświetl go
		echo '<form method="post" action="">
			Category name: <input type="text" name="cat_name" /><br />
			Category description:<br /> <textarea name="cat_description" /></textarea><br /><br />
			<input type="submit" value="Add category" />
		 </form>';
	}
	else
	{
		//zapis wprowadzonych danych do bazy
		$sql = "INSERT INTO categories(cat_name, cat_description) VALUES (\"{$_POST['cat_name']}\",\"{$_POST['cat_description']}\")";

		$result = $conn->query($sql);

		if(!$result)
		{
			//coś poszło nie tak, błąd
			echo 'Error' . mysqli_error();
		}
		else
		{
			echo 'New category succesfully added.';
		}
	}
}

include 'footer.php';
?>
