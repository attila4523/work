<?php

$servername = "localhost";
$username = "wordpress";
$password = "titok";
$dbname = "wordpress";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM wp_posts WHERE post_status=\"publish\" ORDER by rand() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	$update_id=0;
    while($row = $result->fetch_assoc()) {
        $update_id=$row["ID"];
	echo "id: " . $update_id. " - TITLE: " . $row["post_title"]. " \n<br> " . $row["post_content"]. "\n<br>".$row["post_date"];
    }
	$datum=date("Y-m-d H:m:s");
	$sql = "UPDATE wp_posts SET post_date = \"$datum\" WHERE ID = \"$update_id\";";

	if ($conn->query($sql) === TRUE) {
    	echo "\n\nRecord updated successfully";
		$sql = "INSERT INTO wp_comments (comment_post_ID, comment_content) VALUES (\"$update_id\", 'Nagyon jó cikk')";

		if ($conn->query($sql) === TRUE) {
		    echo "\nNew record created successfully";
		} else {
		    echo "\nError: " . $sql . "<br>" . $conn->error;
		}
	} else {
    	echo "\nError updating record: " . $conn->error;
	}
	echo "\n\n<br>update_id:".$update_id;
	echo "\n<br".$datum."\n<br>";
} else {
    echo "\n0 results";
}
$conn->close();


?>
