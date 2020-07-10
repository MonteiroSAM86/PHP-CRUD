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
    
    $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error());

    $_SESSION['message']="Os dados foram apagados!"; // ERRO não aparece a mensagem de erro quando apago os dados da base de dados 
    $_SESSION['msg_type']="danger";
    header("location: index.php");
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error());
    if (count($result) == 1){
        $row = $result->fetch_array();
        $name = $row['nome'];
        $location = $row['local'];
        
    }

}

if (isset($_POST['update'])) { // NÃO ESTÀ A FUNCIOMAR 
    $id = $_POST['id'];
    $name = $_POST['nome'];
    $location = $_POST['local'];

    $mysqli->query("UPDATE data SET nome='$name', local='$location' WHERE id='$id'") or die($mysqli->error);

    $_SESSION['message'] = "Os dados foram Atualizados!";
    $_SESSION['msg_type'] ="warning";

    header("location: index.php");
}
