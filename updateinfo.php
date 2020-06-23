<?php

  session_start();
  if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit();
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>To add list</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet"> 

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <header>
          <!-- Start Navbar -->
          <nav class="navbar-1">
    <ul class="nav justify-content-center">
    <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
    </li>
    <li class="nav-item">
        
        <?php
          if(!isset($_SESSION["username"])){
            echo '<a class="nav-link" href="login.php">Sign in</a>';
          }else {
            echo '<a class="nav-link" href="logout.php">Sign out</a>';
          }
        ?>
        
    </li>
    <li class="nav-item">
        <a class="nav-link" href="profile.php">Profile</a>
    </li>
</ul>
</nav>
<!-- End Navbar -->
<!-- Content -->

  <?php

require('includes/connect.php');
require('includes/class.php');

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = new USER();


  $user->username = stripslashes($_REQUEST['username']);
  $user->username = mysqli_real_escape_string($conn, $user->username);

  $user->email = stripslashes($_REQUEST['email']);
  $user->email = mysqli_real_escape_string($conn, $user->email);

  $user->firstname = stripslashes($_REQUEST['firstname']);
  $user->firstname = mysqli_real_escape_string($conn, $user->firstname);

  $user->lastname = stripslashes($_REQUEST['lastname']);
  $user->lastname = mysqli_real_escape_string($conn, $user->lastname);

  $user->updateinformation($_GET['id'], $user->username, $user->email, $user->firstname, $user->lastname,$conn);



    }

  ?>
<section class="container-fluid ">
    <section class="row justify-content-center">
      <section class="col-12 col-sm-6 col-md-3">
  <form class="form-container" action="" method="post">
  <h1>Update Information </h1>
  <input type="text" class="form-control" name="firstname" value="<?php echo $_SESSION["firstname"] ?>" required />
  <input type="text" class="form-control" name="lastname" value="<?php echo $_SESSION["lastname"] ?>" required />
  <input type="text" class="form-control" name="username" value="<?php echo $_SESSION["username"] ?>" required />
  <input type="text" class="form-control" name="email" value="<?php echo $_SESSION["email"] ?>" required />
  <input type="submit" name="submit" value="Update" class="btn btn-primary btn-block" />
</form>
         
        </form>
      </section>
    </section>
  </section>
<!-- End Content -->

      </header>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>