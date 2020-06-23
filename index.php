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
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
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
<div class="container">
<div class="row inputs">

  <?php
  if(isset($_GET['update'])){
  $id = $_GET["update"];


  $sql = "SELECT * FROM todolist WHERE id = '$id'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
   ?>

   <div class="form-container2">

       <form class="text-center border border-light p-5" action="" method="post" name="update">
         <h1>Edit to do list!</h1>
         <input type="text" class="form-control mb-4" name="name" value="<?php echo $row['name']; ?>" required>
         <input type="hidden" name="id" class="input" value="<?php echo $id; ?>"  >
         <select class="browser-default custom-select" name="color" required>
           <option disabled selected>Pick Color</option>
           <option value="#808080">gray</option>
           <option value="#C0C0C0">silver</option>
           <option value="#800000">maroon</option>
           <option value="#000080">navy</option>
         </select><br>
         <input type="submit" value="Edit" name="update" class="btn btn-outline-dark btn-block my-4">
       </form>
   </div>

<?php } else { ?>

  <div class="form-container2">

      <form class="text-center border border-light p-5" action="" method="post" name="addtodolist">
        <h1>Add TODO list!</h1>
        <input type="text" class="form-control mb-4" name="name" placeholder="Name" required>
        <select class="browser-default custom-select" name="color" required>
          <option value="" disabled selected>Pick Color</option>
          <option value="#808080">gray</option>
           <option value="#C0C0C0">silver</option>
           <option value="#800000">maroon</option>
           <option value="#000080">navy</option>
        </select><br>
        <input type="submit" value="Add list" name="submit" class="btn btn-outline-dark btn-block my-4">
        <?php if (! empty($message)) { ?>
        <p class="errorMessage"><?php echo $message; ?></p>
        <?php } ?>
      </form>
  </div>

  <?php

      } ?>
</div>
  <?php

if (isset($_GET['del'])) {

  $todolist= new TODOLIST();
  $todolist->id = $_GET['del'];

  $res = $todolist->DeleteToDoList($conn);

}

if(isset($_POST["submit"])) {

  $todolist = new TODOLIST();

  $todolist->name = stripslashes($_REQUEST['name']);
  $todolist->name = mysqli_real_escape_string($conn, $todolist->name);

  $todolist->color = stripslashes($_REQUEST['color']);
  $todolist->color = mysqli_real_escape_string($conn, $todolist->color);

  $todolist->user_id = $_SESSION['id'];




  $query = "INSERT into todolist (name, color, user_id)
  VALUES ('$todolist->name', '$todolist->color', '$todolist->user_id')";

  $res = mysqli_query($conn, $query);

  }

?>


<!-- update -->
<?php

if(isset($_POST["update"])){
  $todolist = new TODOLIST();

$todolist->id = $_POST['id'];


$todolist->name = stripslashes($_REQUEST['name']);
$todolist->name = mysqli_real_escape_string($conn, $todolist->name);

$todolist->color = stripslashes($_REQUEST['color']);
$todolist->color = mysqli_real_escape_string($conn, $todolist->color);



  $todolist->UpdateToDolist($todolist->id,$todolist->name,$todolist->color,$conn);
}


?>
<!-- end update -->

<div class="container row">




<?php
$sql = "SELECT * FROM todolist WHERE user_id = '{$_SESSION[ "id" ]}'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
$i = 1;

while($row = $result->fetch_assoc()) {

    ?>

            <div class="todos col-md-12" style="background-color:<?php echo $row['color'] ?>;">
                <span class="cornersleft"> <a href="index.php?update=<?php echo $row['id'] ?>"><i class="far fa-edit"></i></a> </span>
                <span><a href="tasks.php?idtask=<?php echo $row['id']; ?>"> <?php echo $row['name']; ?></a> </span>
                <span  class="cornersright"><a href="index.php?del=<?php echo $row['id'] ?>"><i class="far fa-trash-alt"></i></a></span>
            </div>



    <?php
    $i++;
  }
}
?>
</div>



</div>
<!-- End Content -->

      </header>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>