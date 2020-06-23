<?php
  session_start();
  require('includes/connect.php');
    require('includes/class.php');
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
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
   
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
                    <a class="nav-link" href="profile.php"><?php echo htmlspecialchars($_SESSION["username"]); ?> </a>
                </li>
                <li>
                    <a href="profile.php">
                        <?php

              $sql = "SELECT * FROM user WHERE id = '{$_SESSION[ "id" ]}'";
              $result = $conn->query($sql);
              $row = $result->fetch_assoc();

           echo '<img src="' . $row["photo"] . '" class="nav-link rounded-circle z-depth-0" alt="Image" height="50">';
          ?>

                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Navbar -->
        <!-- Content -->
        <figure class="snip1336">
  <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/sample87.jpg" alt="sample87" />
  <figcaption>    <?php
        echo '<img src="'.$row["photo"].'" width="100px" class="profile" alt="...">';
       ?>
       <h3 for="">Information General</h3>
    <p>First name :  <?php echo $row["firstname"]; ?></p>
    <p>Last name :  <?php echo $row["lastname"]; ?></p>
    <p>Username :  <?php echo $row["username"]; ?></p>
    <p>Email :  <?php echo $row["email"]; ?></p>
    <p>Password : <a class="info" href="updatepassword.php?id=<?php echo $_SESSION['id'] ?>">Click to update</a></p>
    <a href="updateimage.php?id=<?php echo $_SESSION['id'] ?>" class="edituser">Update Photo</a>
    <a href="updateinfo.php?id=<?php echo $_SESSION['id'] ?>" class="edituser">Update User</a>
    
  </figcaption>
</figure>
        <!-- End Content -->

   
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>