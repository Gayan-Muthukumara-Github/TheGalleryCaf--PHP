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

$admin_id = $_SESSION['admin_id'];
$select_admin = $conn->prepare("SELECT type FROM `admin` WHERE id = ?");
$select_admin->execute([$admin_id]);
$fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);
$admin_type = $fetch_admin['type'];
?>

<header class="header">

   <section class="flex">
         <?php 
         if ($admin_type === 'Operational Staff') 
            { 
         ?>
            <a href="staff_dashboard.php" class="logo">Operational Staff<span> Panel</span></a>
         <?php 
            } else{
         ?>
            <a href="dashboard.php" class="logo">Admin<span> Panel</span></a>
         <?php 
            } 
         ?>

      <nav class="navbar">
         
         <?php 
         if ($admin_type === 'Operational Staff') 
            { 
         ?>
            <a href="staff_dashboard.php">home</a>
            <a href="staff_placed_orders.php">orders</a>
            <a href="staff_reserved_tables.php">reservation</a>
         <?php 
            } else{
         ?>
         <a href="dashboard.php">home</a>
         <a href="products.php">products</a>
         <a href="table.php">tables</a>
         <a href="placed_orders.php">orders</a>
         <a href="reserved_tables.php">reservation</a>
         <a href="admin_accounts.php">admins</a>
         <a href="users_accounts.php">users</a>
         <a href="messages.php">messages</a>
         <?php 
            } 
         ?>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">update profile</a>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">login</a>
            <a href="register_admin.php" class="option-btn">register</a>
         </div>
         <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
      </div>

   </section>

</header>