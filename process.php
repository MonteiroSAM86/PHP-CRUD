<?php 

session_start();

$mysqli = new mysqli('localhost', 'root','', 'crud') or die (mysqli_error($mysqli));

$id = 0;
$name ='';
$location ='';
$update = false;

if (isset($_POST['guardar'])) {
    $nome = $_POST['nome'];
    $local = $_POST['local'];

    $mysqli->query("INSERT INTO data (nome, local) VALUES('$nome', '$local')") or 
        die($mysqli->error);

    $_SESSION['message'] = "Os dados foram guardados!";
    $_SESSION['msg_type'] ="success";

    header("location: index.php");
}



if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Perform the deletion
    $result = $mysqli->query("SELECT nome FROM data WHERE id=$id") or die($mysqli->error);
    $row = $result->fetch_assoc();  // Fetch the result
    $nome = $row['nome'];  // Get the 'nome' value from the result

    // JavaScript confirmation
    echo "<script>
            var confirmDelete = confirm('Deseja apagar o registo \"$nome\"?');
            if (confirmDelete) {
                window.location.href='index.php?confirmedDelete=$id';
            } else {
                window.location.href='index.php';
            }
          </script>";
}


if (isset($_GET['confirmedDelete'])) {
    $id = $_GET['confirmedDelete'];
    
    // Perform the deletion
    $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error);
    
    // Set success message
    $_SESSION['message'] = "Os dados foram eliminados com sucesso!";
    $_SESSION['msg_type'] = "danger";


}




if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error());

    // Check the number of rows returned
    if ($result->num_rows == 1) {
        $row = $result->fetch_array();
        $name = $row['nome'];
        $location = $row['local'];
    } else {
        echo "No records found with ID: $id";
    }
}


if (isset($_POST['update'])) { 
    $id = $_POST['id'];
    $name = $_POST['nome'];
    $location = $_POST['local'];

    $mysqli->query("UPDATE data SET nome='$name', local='$location' WHERE id='$id'") or die($mysqli->error);

    $_SESSION['message'] = "Os dados foram Atualizados!";
    $_SESSION['msg_type'] ="warning";

    header("location: index.php");
}
