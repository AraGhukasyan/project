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
      <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="admin_page.php">Գլխավոր</a>
         <a href="admin_products.php">պրոդուկտներ</a>
         <a href="admin_orders.php">պատվերներ</a>
         <a href="admin_accounts.php">ադմին</a>
         <a href="users_accounts.php">օգտվող</a>
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
         <a href="admin_profile_update.php" class="btn">թարմացնել պրոֆիլը</a>
         <a href="logout.php" class="delete-btn">դուրս գալ</a>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">մուտք գործել</a>
            <a href="admin_register.php" class="option-btn">գրանցվել</a>
         </div>
      </div>
   </section>

</header>