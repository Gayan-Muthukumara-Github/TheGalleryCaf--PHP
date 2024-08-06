<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo"></a>

      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="about.php">About Us</a>
         <a href="menu.php">Menu</a>
         <a href="orders.php">Orders</a>
         <a href="table_reservation.php">Table Reservation</a>
         <a href="contact.php">Contact</a>
      </nav>

      <div class="icons">
         
      </div>

      <div class="profile">
         
      </div>

   </section>

</header>

