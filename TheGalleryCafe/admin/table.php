<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_table'])){

   $location = $_POST['location'];
   $location = filter_var($location, FILTER_SANITIZE_STRING);
   $capacity = $_POST['capacity'];
   $capacity = filter_var($capacity, FILTER_SANITIZE_STRING);
   $availability = $_POST['availability'];
   $availability = filter_var($availability, FILTER_SANITIZE_STRING);
   
   $insert_table = $conn->prepare("INSERT INTO `tables`(capacity, location, availability) VALUES(?,?,?)");
   $insert_table->execute([$capacity, $location, $availability]);

   $message[] = 'new table added!';

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_table = $conn->prepare("DELETE FROM `tables` WHERE id = ?");
   $delete_table->execute([$delete_id]);
   header('location:table.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>tables</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add table</h3>
      <input type="text" required placeholder="enter location" name="location" maxlength="100" class="box">
      <input type="number" min="0" max="9999999999" required placeholder="enter capacity" name="capacity" onkeypress="if(this.value.length == 10) return false;" class="box">
      <select name="availability" class="box" required>
         <option value="Yes">Yes</option>
         <option value="No">No</option>
      </select>
      <input type="submit" value="add table" name="add_table" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_tables = $conn->prepare("SELECT * FROM `tables`");
      $show_tables->execute();
      if($show_tables->rowCount() > 0){
         while($fetch_tables = $show_tables->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <img src="../images/table.jpeg" alt="">
      <div class="flex">
         <div class="capacity"><span>Capacity : </span><?= $fetch_tables['capacity']; ?></div>
      </div>
      <div class="location"><span>Location : </span><?= $fetch_tables['location']; ?></div>
      <div class="location"><span>Availability : </span><?= $fetch_tables['availability']; ?></div>
      <div class="flex-btn">
         <a href="update_table.php?update=<?= $fetch_tables['id']; ?>" class="option-btn">update</a>
         <a href="table.php?delete=<?= $fetch_tables['id']; ?>" class="delete-btn" onclick="return confirm('delete this table?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no tables added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>