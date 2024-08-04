<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update'])){

   $tid = $_POST['tid'];
   $tid = filter_var($tid, FILTER_SANITIZE_STRING);
   $location = $_POST['location'];
   $location = filter_var($location, FILTER_SANITIZE_STRING);
   $capacity = $_POST['capacity'];
   $capacity = filter_var($capacity, FILTER_SANITIZE_STRING);
   $availability = $_POST['availability'];
   $availability = filter_var($availability, FILTER_SANITIZE_STRING);

   $update_tables = $conn->prepare("UPDATE `tables` SET capacity = ?, location = ?, availability = ? WHERE id = ?");
   $update_tables->execute([$capacity, $location, $availability, $tid]);

   $message[] = 'table updated!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update table</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- update product section starts  -->

<section class="update-product">

   <h1 class="heading">update table</h1>

   <?php
      $update_id = $_GET['update'];
      $show_tables = $conn->prepare("SELECT * FROM `tables` WHERE id = ?");
      $show_tables->execute([$update_id]);
      if($show_tables->rowCount() > 0){
         while($fetch_tables = $show_tables->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="tid" value="<?= $fetch_tables['id']; ?>">
      <img src="../images/table.jpeg" alt="">
      <span>update location</span>
      <input type="text" required placeholder="enter table location" name="location" maxlength="100" class="box" value="<?= $fetch_tables['location']; ?>">
      <span>update capacity</span>
      <input type="number" min="0" max="9999999999" required placeholder="enter table capacity" name="capacity" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_tables['capacity']; ?>">
      <span>update Availability</span>
      <select name="availability" class="box" required>
         <option selected value="<?= $fetch_tables['availability']; ?>"><?= $fetch_tables['availability']; ?></option>
         <option value="Yes">Yes</option>
         <option value="No">No</option>
      </select>
      <div class="flex-btn">
         <input type="submit" value="update" class="btn" name="update">
         <a href="table.php" class="option-btn">go back</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no tables added yet!</p>';
      }
   ?>

</section>

<!-- update product section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>