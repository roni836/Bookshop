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

          <a href=" index.php?cat_id=<?=$row['cat_id'];?>" class="list-group-item list-group-item-action"><?=$row['cat_title'];?></a>

        <?php endwhile; ?>

        </div>
        </div>
        <div class="col-9">
           
            <?php
            $book_id = $_GET['book_id'];
            $query = mysqli_query($connect,"SELECT * FROM books JOIN categories ON books.category = categories.cat_id WHERE id='$book_id'");
            $data = mysqli_fetch_array($query);
            ?>
             <div class="row">
                <div class="col-3">
                    <div class="card">
                        <img src="<?= 'images/'.$data['cover_image'];?>" alt="" class="w-100" style='height:300px;object-fit:cover'>
                    </div>
                </div>
                <div class="col-9">
                    <table class="table">
                        <tr>
                            <th>Title: </th>
                            <td><?= $data['title'];?></td>
                        </tr>
                        <tr>
                            <th>Author: </th>
                            <td><?= $data['author'];?></td>
                        </tr>
                        <tr>
                            <th>Category: </th>
                            <td><?= $data['cat_title'];?></td>
                        </tr>
                        <tr>
                            <th>No of Pages: </th>
                            <td><?= $data['no_of_page'];?></td>
                        </tr>
                        <tr>
                            <th>ISBN: </th>
                            <td><?= $data['isbn'];?></td>
                        </tr>
                        <tr>
                            <th>Price: </th>
                            <th class="d-flex align-item-center gap-2 ">
                                <h3 class="text-danger h3">Rs.<?=$data['discount_price'];?></h3>
                                <del><h6 class="text-secondary">Rs.<?=$data['price'];?></h6></del>
                            </th>
                        </tr>
                        
                  
                    </table>
                    <div class="d-flex gap-3">
                        <a href="" class="btn btn-success btn-lg">Buy Now</a>
                        <a href="" class="btn btn-warning btn-lg">Add To Cart</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h5>Description:</h5>
                    </div>
                    <div class="card-body">
                        <p><?=$data['description'];?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
