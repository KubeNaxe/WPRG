<?php
include 'connect.php';
include 'header.php';

$conn =  connect();
																																																	error_reporting(0);


echo '<h2>Create a topic</h2>';
if($_SESSION['signed_in'] == false)
{
	//user nie jest zalogowany
	echo 'Sorry, you have to be <a href="/source/signin.php">signed in</a> to create a topic.';
}
else
{
	//user jest zalogowany
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		//pobierz dane tabelki categories z bazy danych
		$sql = "SELECT cat_id, cat_name, cat_description FROM categories";
		$result = $conn->query($sql);

		if(!$result)
		{
			echo 'Error while selecting from database. Please try again later.';
		}
		else
		{
			if(mysqli_num_rows($result) == 0)
			{
				//brak category, nie można staworzyc topic'a
				if($_SESSION['user_level'] == 1)
				{
					echo 'You have not created categories yet.';
				}
				else
				{
					echo 'Before you can post a topic, you must wait for an admin to create some categories.';
				}
			}
			else
			{
		
				echo '<form method="post" action="">
					Subject: <input type="text" name="topic_subject" /><br />
					Category:'; 
				
				echo '<select name="topic_cat">';
					while($row = mysqli_fetch_assoc($result))
					{
						echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
					}
				echo '</select><br />';	
					
				echo 'Message: <br /><textarea name="post_content" /></textarea><br /><br />
					<input type="submit" value="Create topic" />
				 </form>';
			}
		}
	}
	else
	{

		$query  = "BEGIN WORK;";
		$result = $conn->query($query);

		if(!$result)
		{
			echo 'An error occured while creating your topic. Please try again later.';
		}
		else
		{
			//zapis danych o stworzonym topic'u do bazy

			$sql = "INSERT INTO topics(topic_subject, topic_date, topic_cat, topic_by) VALUES(\"{$_POST['topic_subject']}\", NOW(), \"{$_POST['topic_cat']}\", \"{$_SESSION['user_id']}\")";
			$result = $conn->query($sql);
			if(!$result)
			{
				echo 'An error occured while inserting your data. Please try again later.<br /><br />' . mysqli_error();
				$sql = "ROLLBACK;";
				$result = $conn->query($sql);
			}
			else
			{
				//pobierz id stworzonego topic'a
				$topicid = mysqli_insert_id($conn);

				$sql = "INSERT INTO posts(post_content, post_date, post_topic, post_by) VALUES (\"{$_POST['post_content']}\", NOW(), " . $topicid . ", \"{$_SESSION['user_id']}\")";
				$result = $conn->query($sql);
				
				if(!$result)
				{
					echo 'An error occured while inserting your post. Please try again later.<br /><br />' . mysqli_error();
					$sql = "ROLLBACK;";
					$result = $conn->query($sql);
				}
				else
				{
					$sql = "COMMIT;";
					$result = $conn->query($sql);

					echo 'You have succesfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.';
				}
			}
		}
	}
}

include 'footer.php';
?>
