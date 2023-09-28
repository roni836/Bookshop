<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <!-- Brand/logo -->
        <a class="navbar-brand" href="index.php">Bookshop</a>

        <!-- Toggle button for small screens -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <form action="index.php" class="d-flex ms-3">
            <input type="search" name="search" class="form-control" placeholder="Search here anything">
            <input type="submit" value="Search" name="find" class="btn btn-danger ms-2">
        </form>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <?php
                    if(isset($_SESSION['account'])):
                    $email = $_SESSION['account'];
                    $getuser = mysqli_query($connect,"SELECT * FROM accounts WHERE email = '$email'");

                    $getuser = mysqli_fetch_array($getuser);
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link text-capitalize text-white" href="index.php">Welcome <?=$getuser['name'];?></a>
                    </li> 
                <li class="nav-item">
                    <a class="nav-link " href="index.php">Home</a>
                </li>                 
                    <li class="nav-item mt-1 ms-3">
                        <a class="btn btn-sm btn-danger" href="logout.php">Logout</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="register.php">Create an Account</a>
                    </li>
                <?php endif;?>
            </ul>
        </div>
    </div>
</nav>