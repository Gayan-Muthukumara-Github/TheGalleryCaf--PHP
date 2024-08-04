<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

if (isset($_POST['submit'])) {
    $table_id = $_POST['table_id'];
    $table_id = filter_var($table_id, FILTER_SANITIZE_NUMBER_INT);
    $reservation_time = $_POST['reservation_time'];
    $reservation_time = filter_var($reservation_time, FILTER_SANITIZE_STRING);
    $number_of_people = $_POST['number_of_people'];
    $number_of_people = filter_var($number_of_people, FILTER_SANITIZE_NUMBER_INT);
    $special_requests = $_POST['special_requests'];
    $special_requests = filter_var($special_requests, FILTER_SANITIZE_STRING);

   if ($user_id == '') 
   {
      $message[] = 'Please Login!';
   } 
   else 
   {
         $insert_reservation = $conn->prepare("INSERT INTO `reservations`(user_id, table_id, reservation_time, number_of_people, special_requests) VALUES(?,?,?,?,?)");
         $insert_reservation->execute([$user_id, $table_id, $reservation_time, $number_of_people, $special_requests]);

         if ($insert_reservation->rowCount() > 0) {
            $message[] = 'Reservation successful!';
         } else {
            $message[] = 'Reservation failed!';
         }
   }

    
}


$query = "SELECT t.id 
          FROM `tables` t 
          WHERE t.availability = 'Yes'";
$available_tables_stmt = $conn->prepare($query);
$available_tables_stmt->execute();
$available_tables = $available_tables_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>table reservation</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">

   <form action="" method="post">
      <h3>reserve table now</h3>
      <select name="table_id" required class="box">
         <option value="" disabled selected>Select Available Table	--</option>
         <?php
            foreach ($available_tables as $table) {
               echo "<option value='{$table['id']}'>{$table['id']}</option>";
            }
         ?>
      </select>
      <input type="datetime-local" name="reservation_time" required placeholder="Enter Reservation Time" class="box">
      <input type="number" name="number_of_people" required placeholder="Enter Number of People" class="box" min="1" maxlength="10">
      <textarea name="special_requests" placeholder="Any Special Requests?" class="box" maxlength="500"></textarea>
      <input type="submit" value="Reserve Now" name="submit" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
