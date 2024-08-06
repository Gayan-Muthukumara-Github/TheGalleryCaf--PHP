<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update_status'])){

   $reservation_id = $_POST['reservation_id'];
   $status = $_POST['status'];
   $update_status = $conn->prepare("UPDATE `reservations` SET status = ? WHERE id = ?");
   $update_status->execute([$status, $reservation_id]);
   

   if ($status == 'confirmed') {
      $select_table = $conn->prepare("SELECT table_id FROM `reservations` WHERE id = ?");
      $select_table->execute([$reservation_id]);
      $table_id = $select_table->fetchColumn();
      
      if ($table_id) {
         $update_table = $conn->prepare("UPDATE `tables` SET availability = 'No' WHERE id = ?");
         $update_table->execute([$table_id]);
         $message[] = 'Reservation status updated!';
      }
   }
   elseif ($status == 'cancelled') {
      $select_table = $conn->prepare("SELECT table_id FROM `reservations` WHERE id = ?");
      $select_table->execute([$reservation_id]);
      $table_id = $select_table->fetchColumn();
      
      if ($table_id) {
         $update_table = $conn->prepare("UPDATE `tables` SET availability = 'Yes' WHERE id = ?");
         $update_table->execute([$table_id]);
         $message[] = 'Reservation status updated!';
      }
   }

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_reservation = $conn->prepare("DELETE FROM `reservations` WHERE id = ?");
   $delete_reservation->execute([$delete_id]);
   header('location:reserved_tables.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reserved Tables</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- reserved tables section starts  -->

<section class="placed-orders">

   <h1 class="heading">Reserved Tables</h1>

   <div class="box-container">

   <?php
      $select_reservations = $conn->prepare("SELECT * FROM `reservations`");
      $select_reservations->execute();
      if($select_reservations->rowCount() > 0){
         while($fetch_reservations = $select_reservations->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> user id : <span><?= $fetch_reservations['user_id']; ?></span> </p>
      <p> table id : <span><?= $fetch_reservations['table_id']; ?></span> </p>
      <p> reservation time : <span><?= $fetch_reservations['reservation_time']; ?></span> </p>
      <p> number of people : <span><?= $fetch_reservations['number_of_people']; ?></span> </p>
      <p> special requests : <span><?= $fetch_reservations['special_requests']; ?></span> </p>
      <p> status : <span><?= $fetch_reservations['status']; ?></span> </p>
      <form action="" method="POST">
         <input type="hidden" name="reservation_id" value="<?= $fetch_reservations['id']; ?>">
         <select name="status" class="drop-down">
            <option value="" selected disabled><?= $fetch_reservations['status']; ?></option>
            <option value="pending">pending</option>
            <option value="confirmed">confirmed</option>
            <option value="cancelled">cancelled</option>
         </select>
         <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="update_status">
            <a href="reserved_tables.php?delete=<?= $fetch_reservations['id']; ?>" class="delete-btn" onclick="return confirm('delete this reservation?');">delete</a>
         </div>
      </form>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no reservations placed yet!</p>';
   }
   ?>

   </div>

</section>

<!-- reserved tables section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
