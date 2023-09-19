<?php include_once "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
</head>
<body>

<?php include_once "header.php";?>

<div class="container mt-4">
    <div class="row">
        <div class="col-3">
        <div class="list-group">
            <a href="" class="list-group-item list-group-item-action active">Categories</a>
            <?php
                $query = mysqli_query($connect,"SELECT * FROM categories");
                while($row = mysqli_fetch_array($query)):
            ?>

          <a href="" class="list-group-item list-group-item-action"><?=$row['cat_title'];?></a>

        <?php endwhile; ?>

        </div>
        </div>
        <div class="col-9">
            <div class="row">
            <?php
                $query = mysqli_query($connect,"SELECT * FROM books");
                while($data = mysqli_fetch_array($query)):
            ?>
                <div class="col-3">
                    <div class="card">
                        <img src="<?= 'images/'.$data['cover_image'];?>" alt="" class="w-100 ">
                        <div class="card-body">
                            <h2 class="h5">Rs.<?= $data['price'];?>/-<del><?= $data['discount_price'];?>/-</del></h2>
                            <h2 class="h6"><?= $data['title'];?></h2>
                            <span class="bg-success text-white badge"><?= $data['category'];?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile;?>
            </div>
        </div>
    </div>
</div>

</body>
</html>
