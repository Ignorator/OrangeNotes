<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head><title>Orange notes</title>
<meta http-equiv="refresh" content="0.1; index.php"><meta name="keywords" content="automatic redirection"></head>
<body>

<?php
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
?>

</body>
</html>