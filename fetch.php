<?php
//fetch.php;
if(isset($_POST["view"]))
{
 session_start();
 include("connect.php");
 $email = $_SESSION['email'];
 $name = $_SESSION['name'];
 $username = $_SESSION['username'];
 $mobile = $_SESSION['mobile'];

 $query = "SELECT * FROM comments ORDER BY comment_id DESC LIMIT 5";
 $result = mysqli_query($connect, $query);
 $output = '';
 
 if(mysqli_num_rows($result) > 0)
 {
    while($row = mysqli_fetch_array($result))
    {
       $comment_id = $row['comment_id'];
       $query_read = "SELECT * FROM comments, user_read WHERE user_read.comment_id = comments.comment_id AND user_read.comment_id = '$comment_id' AND user_read.username = '$username' ";
       $result_read = mysqli_query($connect, $query_read);
       $row_read = mysqli_fetch_assoc($result_read);
       if ($row['comment_id'] != $row_read['comment_id']) 
       {
          $output .= '
           <li> 
              <a href="view.php?id='.$row["comment_id"].'">
                 <strong style="text-size: 26px; color: red;">'.$row["comment_subject"].'</strong><br />
                 <small style="text-size: 20px; color: red;"><em>'.$row["comment_text"].'</em></small>
              </a>
           </li>
           <li class="divider"></li>
           ';
       }

       else
       {
          $output .= '
           <li>
            <a href="view.php?id='.$row["comment_id"].'">
             <span>'.$row["comment_subject"].'</span><br />
             <span><em>'.$row["comment_text"].'</em></span>
            </a>
           </li>
           <li class="divider"></li>
           ';
       }
       
    }
 }
 else
 {
  $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
 }
 
 $query_1 = "SELECT * FROM comments, user_read WHERE comments.comment_id = user_read.comment_id AND user_read.username = '$username' group by user_read.comment_id";
 $result_1 = mysqli_query($connect, $query_1);
 $count_1 = mysqli_num_rows($result_1);

 $query_2 = "SELECT * FROM comments ORDER BY comment_id";
 $result_2 = mysqli_query($connect, $query_2);
 $count_2 = mysqli_num_rows($result_2);

 $count = $count_2 - $count_1 ;

 $data = array(
  'notification'   => $output,
  'unseen_notification' => $count
 );
 echo json_encode($data);
}
?>