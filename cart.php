<?php include_once "connect.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
</head>
<body>

<?php include_once "header.php"; 

    // Calling Orders and order item
    $user_id = $getuser['user_id'];
    $order = mysqli_query($connect,"SELECT * FROM orders WHERE user_id='$user_id' and is_ordered='0'");
    $myorder = mysqli_fetch_array($order);

    $myorderid = $myorder['order_id'];

    // getting order items

    $myorderitems = mysqli_query($connect,"SELECT * FROM order_items JOIN books ON order_items.book_id=books.id  where order_id = '$myorderid' AND is_ordered='0'");

?>

<div class="container p-5">
    <div class="row">
        <div class="col-9">
            <h1> My Cart(3)</h1>

            <div class="row">
                <?php

                $total_amt = $total_discounted_amt = 0;

                while($order_item = mysqli_fetch_array($myorderitems)):
                
                    $price = $order_item['qty'] * $order_item['price'];
                    $discount_price = $order_item['qty'] * $order_item['discount_price'];
                
                ?>
                <div class="col-12 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <img src="images/<?=$order_item['cover_image'];?>" class="w-100" alt="">
                                </div>
                                <div class="col-10">
                                    <h2 class="h6 text-truncate"><?=$order_item['title'];?></h2>
                                    <h6>Author: <?=$order_item['author'];?></h6>
                                    <h6><span class="text-primary">Rs.<?=$order_item['discount_price'];?></span> <span class="text-muted small">Rs.<del class="text-danger"><?=$order_item['price'];?></del></span></h6>
                                    
                                    <div class="d-flex">
                                        <a href=""class="btn btn-danger">-</a>
                                        <span class="btn btn-lg"><?=$order_item['qty'];?></span>
                                        <a href="cart.php?book_id=<?=$order_item['id'];?>&atc=true"class="btn btn-success">+</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    $total_amt += $price;
                    $total_discounted_amt += $discount_price;

                endwhile;?>
            </div>
        </div>
        <div class="col-3">
        <h2>Price Break</h2>    
        <div class="list-group">
            <span class="list-group-item list-group-action d-flex justify-content-between bg-primary text-white">
                <span>Total Amount</span>
                <span><?=$total_amt;?>/-</span>
            </span>
            <span class="list-group-item list-group-action d-flex justify-content-between bg-warning text-white">
                <span>Total Discount</span>
                <span><?=$amount_before_tax = $total_amt - $total_discounted_amt;?>/-</span>
            </span>
            <?php
                if($myorder['coupon_id']):
            ?>
                <span class="list-group-item list-group-action d-flex justify-content-between bg-warning text-white">
                <span>Coupon Discount</span>
                <span>0/-</span>
            </span>
            <?php endif;?>

            <span class="list-group-item list-group-action d-flex justify-content-between bg-danger text-white">
                <span>Total TAX(GST)</span>
                <span><?=$tax = $total_discounted_amt*0.18;?>/-</span>
            </span>
            <span class="list-group-item list-group-action d-flex justify-content-between bg-success text-white">
                <span><h5>Payable Amount</h5></span>
                <span><h5><?=$total_discounted_amt + $tax;?>/-</h5></span>
            </span>
        </div>
            <div class="d-flex mt-3 justify-content-between">
                <a href="" class="btn btn-dark btn-lg">Go Back</a>
                <a href="" class="btn btn-primary btn-lg">Checkout</a>
            </div>

            <?php
                if(!$myorder['coupon_id']):
            ?>
            <div class="mt-3">
                <form action="" method="post" class="d-flex mt-5">
                    <input type="text" placeholder="Enter Coupon Code" name="code"class="form-control">
                    <input type="submit" value="Apply"class="btn btn-dark">
                </form>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>


<?php
if(isset($_GET['book_id']) && isset($_GET['atc'])){
    //  Check User Login or Not

    if(!isset($_SESSION['account'])){
        echo "<script>window.open('login.php','_self')</script>";
    }

    //  And if Login.... Page will be Continue..

    $book_id = $_GET['book_id'];
    $user_id = $getuser['user_id'];

    // Checking Order already exists or not

    $check_order = mysqli_query($connect,"SELECT * FROM orders where user_id='$user_id' and is_ordered='0'");
    $count_check_order = mysqli_num_rows($check_order);
   
    if($count_check_order < 1){
        // Not exists previously that's why we need to create new order in order table
        $create_order = mysqli_query($connect,"INSERT INTO orders(user_id) value('$user_id')");
        $created_order_id = mysqli_insert_id($connect);

         // Inserting new order item
        $create_order_item = mysqli_query($connect,"INSERT INTO order_items(order_id,book_id) value('$created_order_id','$book_id')");
    }
    else{
        // Already Exixts order work
        $current_order = mysqli_fetch_array($check_order);
        $current_order_id = $current_order['order_id'];

        // Checking if order item already  exist or not
        $check_order_item = mysqli_query($connect,"SELECT * FROM order_items where (order_id='$current_order_id' AND book_id='$book_id') AND is_ordered='0'");
        $current_order_item = mysqli_fetch_array($check_order_item);
        $count_current_order_item = mysqli_num_rows($check_order_item);

        if($count_current_order_item > 0){
            // ONly need to update quantity of item in order_items table
            $current_order_item_id = $current_order_item['oi_id'];
            $query_for_qty_update = mysqli_query($connect,"UPDATE order_items SET qty=qty+1 WHERE oi_id='$current_order_item_id'");
        }
        else{
            $create_order_item = mysqli_query($connect,"INSERT INTO order_items(order_id,book_id) value('$current_order_id','$book_id')");
        }
    }

    // Refresh page
    echo "<script>window.open('cart.php','_self')</script>";
}
?>