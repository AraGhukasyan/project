<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update_payment'])){

   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = 'վճարման ստատուսը թարմացված է!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>պատվերներ</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php' ?>

<section class="orders">

<h1 class="heading">տեղադրված պատվերներ</h1>

<div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> տեղադրված : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Անուն : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> համար : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> հասցե : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Պրոդուկտների քանակ : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> Վերջնական գին: <span><?= $fetch_orders['total_price']; ?></span> </p>
      <p> Վճարման եղանակ : <span><?= $fetch_orders['method']; ?></span> </p>
      <form action="" method="post">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <select name="payment_status" class="select">
            <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="pending">ընթացքի մեջ է</option>
            <option value="completed">վճարված է</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="Թարմացնել" class="option-btn" name="update_payment">
         <a href="admin_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('ջնջել այս պատվերը?');">ջնջել</a>
        </div>
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">պատվերներ չկան!</p>';
      }
   ?>

</div>

</section>



<script src="js/admin_script.js"></script>

</body>
</html>