<?php

session_start();

include 'dbhandler.inc.php';

// if (!empty($_POST['className'])) { // This one right here checks if we are here from the 'type_of_activity' button in frontend.
  // $name = $_POST['type_of_activity']; // This one right here stores the value that the user inserted into a variable.
$name = "no";
$current_userID = $_SESSION['userID'];
$typeArray = array();
$percentageArray = array();
$bothArray = array();

  if (empty($name)) { // This one right here checks if the input of the user is empty.
    echo "<span class='form-error'>Fill in all fields!</span>"; // This one right here echo this message if the input is empty.
    // $error_empty = true;
  } elseif (!empty($name)) { // This one right here checjs if the input of the user is not empty.
    // echo "<span class='form-success'>Success!</span>"; // This one right here echo this message if the input is not empty.
    if ($_SESSION['type'] == 'admin'){
      $sql_1 = "SELECT * FROM activity_details"; // This one right here selects everything from activity_details table. I want only the count but I will retrieve it with mysqli_num_rows() function.
      $sql_3 = "SELECT DISTINCT type FROM activity_details";
    } else {
      $sql_1 = "SELECT * FROM activity_details WHERE userID = '$current_userID'"; // This one right here selects everything from activity_details table. I want only the count but I will retrieve it with mysqli_num_rows() function.
      $sql_3 = "SELECT DISTINCT type FROM activity_details WHERE userID = '$current_userID'";
    }
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql_1) || !mysqli_stmt_prepare($stmt, $sql_3)) { //This one right here will check if the sql statement above working properly.
      echo "Connection failed!";
      exit();
    }
    else{
      $result_1 = mysqli_query($connection, $sql_1); // This one right here stores the query into a variable.
      $resultCheck_1 = mysqli_num_rows($result_1); // This one right here stores the mysqli_num_rows() into a variable.
      $result_3 = mysqli_query($connection, $sql_3); // This one right here stores the query into a variable.
      while($resultCheck_3 = mysqli_fetch_array($result_3)){
        $name = $resultCheck_3["type"];
        if ($_SESSION['type'] == 'admin'){
          $sql_2 = "SELECT * FROM activity_details WHERE type = '$name'"; // This one right here selects everything from activity_details table where type is something that the admin choose in frontend. I want only the count but I will retrieve it with mysqli_num_rows() function.
        } else {
          $sql_2 = "SELECT * FROM activity_details WHERE type = '$name' AND userID = '$current_userID'"; // This one right here selects everything from activity_details table where type is something that the admin choose in frontend. I want only the count but I will retrieve it with mysqli_num_rows() function.
        }
        $result_2 = mysqli_query($connection, $sql_2); // This one right here stores the query into a variable.
        $resultCheck_2 = mysqli_num_rows($result_2); // This one right here stores the mysqli_num_rows() into a variable.
        array_push($typeArray, $resultCheck_3["type"]); // This one right here pushes to the array the type of the activity
        array_push($percentageArray, ($resultCheck_2 / $resultCheck_1) * 100); // This one right here pushes to the array the activity_percentage of the activity.
      }
      // echo array_sum($percentageArray);

      $bothArray['typeArray'] = $typeArray;
      $bothArray['percentageArray'] = $percentageArray;
      echo json_encode($bothArray); // This one right here encodes both array to a JSON.
    }
  }

  // echo $float_latitide;
// } else { //This one right here sent the curious user back to home when he tries to enter the include page in other way that from the button I mentioned on line 5.
//   echo "There was an error!";
// }

?>
