<?php
  session_start();
  include('config.php');
  $flag=false;

  if (isset($_POST['transfer']))
  {
          $sender=$_SESSION['sender'];
          $receiver=$_POST["reciever"];
          $amount=$_POST["amount"];
      
      $sql = "SELECT user_balance FROM users WHERE user_name='$sender'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
      // output data of each row
          while($row = $result->fetch_assoc()) {
      if($amount>$row["user_balance"] or $row["user_balance"]-$amount<100){
      $location='details.php?user='.$sender;
      header("Location: $location&message=transactionDenied");
      }
      else{
          $sql = "UPDATE `users` SET user_balance=(user_balance-$amount) WHERE user_name='$sender'";
          

      if ($conn->query($sql) === TRUE) {
      $flag=true;
      } else {
      echo "Error in updating record: " . $conn->error;
      }
      }
      
      }
      } else {
      echo "0 results";
      } 

      if($flag==true){
      $sql = "UPDATE `users` SET user_balance=(user_balance+$amount) WHERE user_name='$receiver'";

      if ($conn->query($sql) === TRUE) {
      $flag=true;  
      
      } else {
      echo "Error in updating record: " . $con->error;
      }
      }
      if($flag==true){
          $sql = "SELECT * from users where user_name='$sender'";
          $result = $conn-> query($sql);
          while($row = $result->fetch_assoc())
          {
              $s_acc=$row['user_acc_no'];
      }

      $sql = "SELECT * from users where user_name='$receiver'";
      $result = $conn->query($sql);
      while($row = $result->fetch_assoc())
      {
          $r_acc=$row['user_acc_no'];
      }        
      $sql = "INSERT INTO `transfer`(sender_name,sender_acc_no,receiver_name,receiver_acc_no,transfer_amount) 
              VALUES ('$sender','$s_acc','$receiver','$r_acc','$amount')";
      if ($conn->query($sql) === TRUE) {
      } else 
      {
      echo "Error updating record: " . $conn->error;
      }
      }

      if($flag==true){
      $location='details.php?user='.$sender;
      header("Location: $location&message=success");//for redirecting it to detail page with message
      }
  }
?>