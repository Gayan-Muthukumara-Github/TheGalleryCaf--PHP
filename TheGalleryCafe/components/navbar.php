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

<header class="headertop">

   <section class="flex">

      <img src="images/logo.png" class="logo" alt="">

      <div class="icons">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <a href="login.php"><i class="fas fa-user"></i></a>
         <a href="register.php"><i class="fas fa-user-plus"></i></a>
         <a href="profile.php"><i class="fa-solid fa-address-card"></i></a>
         <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         <?php
            }else{
         ?>
            <a href="login.php"><i class="fas fa-user"></i></a>
            <a href="register.php"><i class="fas fa-user-plus"></i></a>
         <?php
          }
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>
   </section>

</header>

