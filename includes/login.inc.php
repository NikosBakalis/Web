<?php

/* This one right here we will chech if the user entered
this sections using the submit button
If that's true then we will let him continue
else he will not see a thing!*/
if(isset($_POST['login_submit'])){
  require 'dbhandler.inc.php';

  $email = $_POST['email'];
  $password = $_POST['password'];

  if(empty($email) || empty($password)){ //This one right here checks if the user has left any blank value.
    header("Location: ../login.php?error=empty_fields&email=".$email);
    exit();
  }
  else { //This one right here checks if the email of the user exists in the database.
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly.
      header("Location: ../login.php?error=sql_error");
      exit();
    }
    else { //This one right here is called if the sql statement is working properly and executes it.
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($result)) { //This one right here checks if we get an actual result from the database.
        $passwordCheck = password_verify($password, $row['pwd']); //This one right here verifies the password we typed with tha hashed password that is stored in the database.
        if ($passwordCheck == false) { //This one right here activates if we entered the password wrong.
          header("Location: ../login.php?error=wrong_password");
          exit();
        }
        else if ($passwordCheck == true){ //This one right here activates when we enter the password correct.
          session_start(); //This one right here starts a session between the user and the server, with some importan parameters like these right below.
          $_SESSION['userID'] = $row['id'];
          $_SESSION['userUsername'] = $row['username'];
          $_SESSION['userEmail'] = $row['email'];
          header("Location: ../index.php?login=success");
          exit();
        }
      }
      else { //This one right here sends the user a no user error because he searched something that not exists in our database.
        header("Location: ../login.php?error=no_user");
        exit();
      }
    }
  }
}
else { //This one right here sent the curious user back to home when he tries to enter the include page in other way that from the button I mentioned on lines 3-4-5-6.
  header("Location: ../index.php");
  exit();
}

?>