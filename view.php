<?php 
	session_start();
	include("connect.php");

	$email = $_SESSION['email'];
    $name = $_SESSION['name'];
    $username = $_SESSION['username'];
    $mobile = $_SESSION['mobile'];
	$comment_id = $_GET['id'];

	if (isset($comment_id)) 
	{
		$query = "SELECT * FROM comments WHERE comment_id = '$comment_id' ";
		$res = mysqli_query($connect, $query);
		$row = mysqli_fetch_assoc($res);

		$update_query = "UPDATE comments SET comment_status = 1 WHERE comment_id = '$comment_id' ";
        mysqli_query($connect, $update_query); 

        $sql = "INSERT INTO user_read (comment_id, username, read_status)
				VALUES ('$comment_id', '$username', '1')";
		mysqli_query($connect, $sql); 		
	}
	

?>

<button> <a href="index.php">Home</a> </button>

<h2 align="center">Notification using PHP Ajax Bootstrap</h2>
<br />
<div class="form-group">
	<label>Enter Subject</label>
	<input type="text" value="<?php echo $row['comment_subject']; ?>" name="subject" id="subject" class="form-control" readonly>
</div>
<div class="form-group">
	<label>Enter Comment</label>
	<input type="text" value="<?php echo $row['comment_text']; ?>" name="comment" id="comment" class="form-control" readonly>
</div>