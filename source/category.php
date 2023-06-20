<?php
include 'connect.php';
include 'header.php';

$conn =  connect();

//wybierz category po id
$query = "SELECT * FROM categories WHERE cat_id = \"{$_GET['id']}\"";
$result = $conn->query($query);

if(!$result)
{
	die ('The category could not be displayed, please try again later.' . $conn->connect_error);
}
else
{
	if($result->num_rows == 0)
	{
		echo 'This category does not exist.';
	}
	else
	{
		//wyswietl dane category
		while($row = $result->fetch_assoc())
		{
			echo '<h2>Topics in &prime;' . $row['cat_name'] . '&prime; category</h2><br />';
		}
	
		//wykonaj zapytanie dla wszystkich topics
		$query = "SELECT * FROM topics WHERE topic_cat = \"{$_GET['id']}\"";
		$result = $conn->query($query);
		
		if(!$result)
		{
			echo 'The topics could not be displayed, please try again later.';
		}
		else
		{
			if($result->num_rows == 0)
			{
				echo 'There are no topics in this category yet.';
			}
			else
			{
				echo '<table border="1">
					  <tr>
						<th>Topic</th>
						<th>Created at</th>
					  </tr>';	
					
				while($row = $result->fetch_assoc())
				{				
					echo '<tr>';
						echo '<td class="leftpart">';
							echo '<h3><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><br /><h3>';
						echo '</td>';
						echo '<td class="rightpart">';
							echo date('d-m-Y', strtotime($row['topic_date']));
						echo '</td>';
					echo '</tr>';
				}
			}
		}
	}
}

include 'footer.php';
?>
