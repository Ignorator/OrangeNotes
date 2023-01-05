<?php
include 'notes.php';
session_start();
$link = getDb(); 
$querySelect10 = sprintf("SELECT * FROM fenykep WHERE felhasznaloid='$_SESSION[id]'");
                $eredmeny10 = mysqli_query($link, $querySelect10) or die(mysqli_error($link));
		if ($eredmeny10!=NULL){
		$targetDir = "uploads/$_SESSION[id]/";
				while($row = mysqli_fetch_array($eredmeny10)){
					$imageURL = 'uploads/'.$row['file_name'];
					$file=$targetDir . $row['file_name'];
					unlink($file);
					}}
  $query1 = sprintf('DELETE FROM jegyzet WHERE felhasznaloid = %s', 
        mysqli_real_escape_string($link, $_SESSION['id']));
	$query3 = sprintf('DELETE FROM fenykep WHERE felhasznaloid = %s', 
        mysqli_real_escape_string($link, $_SESSION['id']));
    $query2 = sprintf('DELETE FROM felhasznalo WHERE id = %s', 
        mysqli_real_escape_string($link,  $_SESSION['id']));
    $ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));
	$ret3 = mysqli_query($link, $query3) or die(mysqli_error($link));
    $ret2 = mysqli_query($link, $query2) or die(mysqli_error($link));

	// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
    header("Location: index.php");
    return;
?>
<!DOCTYPE html>
<html>
<head><title>Orange notes</title>
<body>





</body>
</html>