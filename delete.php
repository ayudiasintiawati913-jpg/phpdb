<?php

include_once("config.php");


$no = $_GET['no'];


$result = mysqli_query($mysqli, "DELETE FROM mahasiswati WHERE no=$no");

header("Location:index.php");

?>