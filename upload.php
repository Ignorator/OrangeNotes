<?php
// Include the database configuration file
include 'notes.php';
$link = getDb(); 
$statusMsg = '';
$letezik=false;

session_start();

// File upload path

$targetDir = "uploads/$_SESSION[id]/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if (!file_exists($targetDIR)) {
    mkdir($targetDir, 0777, true);
}

if(isset($_POST["upload"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
			$filename = "$fileName";
			$datum = mysqli_real_escape_string($link, date("Y-m-d"));
			$felhasznaloid = mysqli_real_escape_string($link, $_SESSION['id']);
			$kepleiras1= mysqli_real_escape_string($link, $_POST['kepleiras']);


			$result = mysqli_query($link,"SELECT id FROM fenykep WHERE file_name='$fileName' AND felhasznaloid='$felhasznaloid'");
			if(mysqli_num_rows($result) == 0) {
			
			 $createQuery = sprintf("INSERT INTO fenykep (file_name, uploaded_on, leiras, felhasznaloid) VALUES ('%s', '%s', '%s', '%s')",
				 $filename,
				 $datum,
				 $kepleiras1,
				 $felhasznaloid
			 );
				  mysqli_query($link, $createQuery) or die(mysqli_error($link));

			} 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';}

	header('Location: home.php');
?>