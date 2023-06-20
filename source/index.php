<?php
include 'connect.php';
include 'header.php';

$conn =  connect();


$query = "SELECT *, COUNT(topics.topic_id) AS topics FROM categories LEFT JOIN topics ON topics.topic_id = categories.cat_id GROUP BY categories.cat_name, categories.cat_description, categories.cat_id";
$result1 = $conn->query($query);

if(!$result1)
{
	echo 'The categories could not be displayed, please try again later.';
}
else
{
	if($result1->num_rows == 0)
	{
		echo 'No categories defined yet.';
	}
	else
	{
		echo '<table border="1">
			  <tr>
				<th>Category</th>
				<th>Last topic</th>
			  </tr>';	
			
		while($row = $result1->fetch_assoc())
		{				
			echo '<tr>';
				echo '<td class="leftpart">';
					echo '<h3><a href="category.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
				echo '</td>';
				echo '<td class="rightpart">';
				
				//wybierz ostatni topic z danymi dla każdej category
					$topicsql = "SELECT * FROM topics WHERE topic_cat = " . $row['cat_id'] . " ORDER BY topic_date DESC LIMIT 1";

			$result = $conn->query($topicsql);
				
					if(!$result)
					{
						echo 'Last topic could not be displayed.';
					}
					else
					{
						if($result->num_rows == 0)
						{
							echo 'no topics';
						}
						else
						{
							while($topicrow = $result->fetch_assoc())
							{
								echo '<a href="topic.php?id=' . $topicrow['topic_id'] . '">' . $topicrow['topic_subject'] . '</a> at ' . date('d-m-Y', strtotime($topicrow['topic_date']));
							}
						}
					}
				echo '</td>';
			echo '</tr>';
		}
	}
}

include 'footer.php';
?>
