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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
      <div class="row">

        <?php
  if(isset($_GET['update'])){
  $id = $_GET["update"];


  $sql = "SELECT * FROM task WHERE id = '$id'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
   ?>

        <div class="form-container3">
          <form class="text-center border border-light p-5" action="" method="post" name="edittask">
            <h1>Edit task!</h1>
            <input type="text" class="form-control mb-4" name="tasktext" value="<?php echo $row['tasktext']; ?>"
              required>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Edit" name="edittask" class="btn btn-outline-dark btn-block my-4">
          </form>
        </div>

        <?php } else { ?>

        <div class="form-container3">
          <form class="text-center border border-light p-5" action="" method="post" name="addtask">
            <h1>Add task!</h1>
            <input type="text" class="form-control mb-4" name="tasktext" placeholder="task" required>
            <input type="hidden" name="idtask" class="input" value="<?php echo $_GET['idtask']; ?>">
            <input type="submit" value="Add task" name="addtask" class="btn btn-outline-dark btn-block my-4">
            <?php if (! empty($message)) { ?>
            <p class="errorMessage"><?php echo $message; ?></p>
            <?php } ?>
          </form>
        </div>
      </div>

      <?php

      } ?>
    </div>
    <?php


    if (isset($_GET['deltask'])) {

        $task = new TASK();
        $task->id = $_GET['deltask'];

        $res = $task->DeletTask($conn,$id);

      }


    if(isset($_POST["addtask"])) {

    $idtask = $_POST['idtask'];

    $task = new TASK();

    $task->tasktext = stripslashes($_REQUEST['tasktext']);
    $task->tasktext = mysqli_real_escape_string($conn, $task->tasktext);

    $task->done = FALSE;

    $query = "INSERT into task (tasktext, done, todolist_id)
    VALUES ('$task->tasktext', '$task->done', '$idtask')";

    $res = mysqli_query($conn, $query);

    header("Location: tasks.php?idtask=$idtask");



    }

    ?>

    <!-- update -->
    <?php

if(isset($_POST["edittask"])){
    $task = new TASK();

  $task->id = $_POST['id'];


  $task->name = stripslashes($_REQUEST['tasktext']);
  $task->name = mysqli_real_escape_string($conn, $task->name);



    $task->Changetasktext($conn);
}


?>
    <!-- end update -->

    <div class="form-container4">

      <table class="table">

        <thead class="black white-text">
          <tr>
            <th class="tasktableleft" scope="col">Done</th>
            <th scope="col">Tasks</th>
            <th scope="col">Edit</th>
            <th class="tasktableright" scope="col" style="width: 60px;">Delete</th>
          </tr>
        </thead>

        <tbody>


    </div>


    <?php
$sql = "SELECT * FROM task WHERE todolist_id = '{$_GET["idtask"]}'";
$result = $conn->query($sql);


$i = 1;
while($row = $result->fetch_assoc()) {

    ?>



    <tr style="background-color:<?php echo $row['color'] ?>;">

      <td><input name="<?php echo $row['id'] ?>" class="checkboox" id="check"
          onclick="cheeck('1','<?php echo $row['id'] ?>')" type="checkbox" value="<?php echo $row['done'] ?>"></td>
      <td>
        <p class="text"> <?php echo $row['tasktext']; ?></p>
      </td>
      <td scope="row"> <a href="tasks.php?update=<?php echo $row['id'] ?>&idtask=<?php echo $_GET["idtask"] ?>"><i
            class="far fa-edit"></i></a> </td>
      <td>
        <a href="tasks.php?deltask=<?php echo $row['id'] ?>&idtask=<?php echo $_GET["idtask"] ?>"><i
            class="far fa-trash-alt"></i></a>
      </td>
    </tr>

    <?php
    $i++;
  }

?>
    </tbody>
    </table>



    </div>
    <script src="checkdone.js">
    </script>




    <!-- End Content -->

  </header>
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