
<?php
include 'notes.php';

$link = getDb(); 
// Start the session
session_start();

$_SESSION["loginsuccess"] = true;
			if(isset($_SESSION['emaillogin'])==false)
			{header('Location:index.php');;}


$creatednote = false;
if (isset($_POST['create'])) {
    $jegyzetnev = mysqli_real_escape_string($link, $_POST['jegyzetnev']);
    $jegyzetszoveg = mysqli_real_escape_string($link, $_POST['jegyzetszoveg']);
    $jegyzetdatum = mysqli_real_escape_string($link, date("Y-m-d"));
    $felhasznaloid = mysqli_real_escape_string($link, $_SESSION['id']);

    $createQuery = sprintf("INSERT INTO jegyzet (jegyzetnev, jegyzetszoveg, jegyzetdatum, felhasznaloid) VALUES ('%s', '%s', '%s', '%s')",
        $jegyzetnev,
        $jegyzetszoveg,
        $jegyzetdatum,
        $felhasznaloid
    );
    mysqli_query($link, $createQuery) or die(mysqli_error($link));
    $creatednote = true;
} 
if (isset($_POST['delete'])){
    $pst=$_POST['delete'];
	$ssid=$_SESSION['id'];
	$query1 = sprintf('DELETE FROM jegyzet WHERE id=%s AND felhasznaloid = %s', mysqli_real_escape_string($link, $pst), mysqli_real_escape_string($link, $ssid));
	$ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));
	}
if (isset($_POST['deletepicture'])){
    $pst11=$_POST['deletepicture'];
	$ssid11=$_SESSION['id'];
	$query11 = sprintf("DELETE FROM fenykep WHERE id=%s AND felhasznaloid =%s",mysqli_real_escape_string($link, $pst11),mysqli_real_escape_string($link, $ssid11));
	$ret11 = mysqli_query($link, $query11) or die(mysqli_error($link));
	$targetDir = "uploads/$_SESSION[id]/";
	$file=$targetDir . $_POST['deletefile'];
	unlink($file);

	}
if(isset($_POST['refresh'])){
	$felhasznalonev = mysqli_real_escape_string($link, $_POST['refelhasznalonev']);
    $felhasznaloemail = mysqli_real_escape_string($link, $_POST['reemail']);
    $felhasznalojelszo = mysqli_real_escape_string($link, $_POST["repwd"]);
	$felhasznaloid=mysqli_real_escape_string($link, $_SESSION['id']);

  $query6 = sprintf("UPDATE felhasznalo SET nev='%s', jelszo='%s', email='%s' WHERE id=%s ",
                $felhasznalonev, $felhasznalojelszo, $felhasznaloemail, $felhasznaloid);
        mysqli_query($link, $query6) or die(mysqli_error($link));
}

?>
<!DOCTYPE html>
	<html>
		<head>
			<title>Orange notes</title>
				<meta http-equiv="Content-Type" content="text/html;
				charset=UTF-8" />
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
				<link rel="stylesheet" href="homestyle.css">

					<link rel="stylesheet" type="text/css" href="fancybox/dist/jquery.fancybox.css">
	</head>
	<body>

			<div class="container">
				<div class="page-header">
					<div class ="row">
					<div class="col-sm-6"><h1><a title="Homepage">
						<img src="orglogo.jpg" />
					</a></h1></div><div class="col-sm-3"></div> <div class="col-sm-2"> <h3><div class="text-right"> <p class="a"><a href="logout.php"> <button class="btn btn-outline-warning">Log out</button></a> </p></div></h3> </div>
					</div>
				</div>  
			</div>

			<div class="container">
			 <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
    <li><a data-toggle="tab" href="#Notes">Notes</a></li>
    <li><a data-toggle="tab" href="#Pictures">Pictures</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>Search notes</h3>
	  <?php
            $search = null;
             if (isset($_POST['search'])) {
                 $search = $_POST['search'];
            }
        ?>
        <form class="form-inline" method="post">
            <div class="card">
                <div class="card-body">
                    <input style="width:600px;margin-left:1em;" class="form-control" placeholder="Type here.." type="search" name="search" value="<?=$search?>">
                    <button class="btn btn-warning" style="margin-left:1em;" type="submit" > <span class="glyphicon glyphicon-search"></span>  Search</button>
                </div>
            </div>
        </form>

		<?php
            $eredmeny=NULL;
            if ($search)
			{
                $querySelect = sprintf("SELECT id, jegyzetszoveg, jegyzetnev, jegyzetdatum FROM jegyzet WHERE felhasznaloid='$_SESSION[id]' AND LOWER(jegyzetnev) LIKE '%%%s%%'", mysqli_real_escape_string($link, strtolower($search)));
                $eredmeny = mysqli_query($link, $querySelect) or die(mysqli_error($link));}

			?>
            <table class="table table-striped table-sm table-bordered">

                <tbody>
                <?php if ($eredmeny!=NULL): ?>
				<thead class="thead-dark">
                    <tr>
                        <th>Note name</th>
                        <th>Note text</th>      
                        <th>Date</th>
						<th></th>
						<th></th>
                    </tr> 
                </thead>
				<?php endif; ?> 
				<?php while ($eredmeny!=NULL && $row = mysqli_fetch_array($eredmeny)): ?>
                    <tr>
                        <td><?=$row['jegyzetnev']?></td>
                        <td><?=$row['jegyzetszoveg']?></td>
                        <td><?=$row['jegyzetdatum']?></td>
						<td align="center"><a type="button" class="btn btn-outline-warning" href="noteedit.php?noteid=<?=$row['id']?>">Edit</a></td>
						<form method="post" action="">
						<td align="center"><button type="submit" class="btn btn-outline-danger">Delete</button></td>
						<input type="hidden" name="delete" value="<?=$row['id']?>" />
						</form>
                    </tr>                
                <?php endwhile; ?> 
                </tbody>
            </table>


	 </div>


	<div id="Notes" class="tab-pane fade">
      <h3>Notes</h3>
      <button class="btn btn-outline-warning Circle" onclick="document.getElementById('id02').style.display='block'">+</button>

	  			<div id="id02" class="modal">
  
  <form class="modal-content animate" action="" method="post">
  <div class="imgcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
	  <div class="row"></div>
    </div>
    <div>
	<p><p>
    <h2><p class="b"> Add new note </p></h2>
    </div>

    <div class="container2">
      <label for="other"><b>Note name:</b></label>
      <input type="text" class="form-control" name="jegyzetnev" required>
	  	</div>
	<div class="container2">
      <label for="other"><b>Note text:</b></label>
      <textarea name="jegyzetszoveg"  required> </textarea>
	</div>
	<div class="container2"
      <h3> <p class="a b" ><button type="submit" name="create" class="btn btn-outline-warning">Create</button> </p>
    </div>



    <div class="container2" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn btn btn-outline-danger" >Cancel</button>
    </div>
  </form>
</div>

<script>


// Get the modal
var modal = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>


	  <p> </p>
	  <?php
            $querySelect2 = "SELECT id, jegyzetszoveg, jegyzetnev, jegyzetdatum FROM jegyzet WHERE felhasznaloid='$_SESSION[id]'";         
            $eredmenynotes = mysqli_query($link, $querySelect2) or die(mysqli_error($link));
			?>
            <table class="table table-striped table-sm table-bordered">
                <tbody>
				<thead class="thead-dark">
                    <tr>
                        <th>Note name</th>
                        <th>Note text</th>      
                        <th>Date</th> 
						<th></th>
						<th></th>
                    </tr> 
                </thead>
				<?php while ($row = mysqli_fetch_array($eredmenynotes)): ?>
                    <tr>
                        <td><?=$row['jegyzetnev']?></td>
                        <td><?=$row['jegyzetszoveg']?></td>
                        <td><?=$row['jegyzetdatum']?></td>  
						<td align="center"><a type="button" class="btn btn-outline-warning" href="noteedit.php?noteid=<?=$row['id']?>">Edit</a></td>
						<form method="post" action="">
						<td align="center"><button type="submit" class="btn btn-outline-danger">Delete</button></td>
						<input type="hidden" name="delete" value="<?=$row['id']?>" />
						</form>

					</tr>  
				 <?php endwhile; ?> 
                </tbody>
            </table>


    </div>
    <div id="Pictures" class="tab-pane fade">
      <h3>Pictures</h3>
      <button class="btn btn-outline-warning Circle" onclick="document.getElementById('id04').style.display='block'">+</button>


	  <div id="id04" class="modal">
  
  <form class="modal-content animate" action="upload.php" method="post" enctype="multipart/form-data">
  <div class="imgcontainer">
      <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
	  <div class="row"></div>
    </div>
    <div>
	<p><p>
    <h2><p class="b"> Upload pictures </p></h2>
    </div>


		<div class="container2">
      <label for="other"><b>Description:</b></label>
      <textarea name="kepleiras"  required> </textarea>
	</div>
	<div class="input-group container2">
                <label class="input-group-btn">
                    <span class="btn btn-outline-warning">
                        Browse&hellip; <input type="file" style="display: none;" name="file">
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
	<div class="container2"
      <h3> <p class="a b" ><button type="submit" name="upload" value="Upload" class="btn btn-outline-warning">Upload</button> </p>
    </div>



    <div class="container2" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id04').style.display='none'" class="cancelbtn btn btn-outline-danger" >Cancel</button>
    </div>
  </form>
</div>

<script>


// Get the modal
var modal = document.getElementById('id04');



// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
$(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });
  
});
</script>
	  <p> </p>

	  <div class="container">
    <div class="gallery flex-container4">
        <?php
       
        //get images from database
		$querySelect10 = sprintf("SELECT * FROM fenykep WHERE felhasznaloid='$_SESSION[id]' ORDER BY uploaded_on DESC");
                $eredmeny10 = mysqli_query($link, $querySelect10) or die(mysqli_error($link));
		if ($eredmeny10!=NULL){
		$targetDir = "uploads/$_SESSION[id]/";
				while($row = mysqli_fetch_array($eredmeny10)){
					$imageThumbURL = $targetDir . $row['file_name'];
					$imageURL = $targetDir . $row['file_name'];
        ?>
		<div class="flex-container3">
            <a  href="<?php echo $imageURL; ?>" data-fancybox="gallery" data-caption="<?php echo $row["leiras"]; ?>" >
                <img src="<?php echo $imageThumbURL; ?>" alt="" /> 
            </a>
			<div class="flex-container">
			<form method="" action="">
			<a type="button" class="btn btn-outline-warning" href="pictureedit.php?pictureid=<?=$row['id']?>">Edit</a>
			</form>
			<form method="post" action="">
			<button type="submit" class="btn btn-outline-danger" float="right" >Delete</button>
			<input type="hidden" name="deletepicture" value="<?=$row['id']?>" />
			<input type="hidden" name="deletefile" value="<?=$row['file_name']?>" />
			</form>
				</div>
			</div>

		
		


        <?php }} ?>


    </div>
</div>


<script type="text/javascript">
    $("[data-fancybox]").fancybox({ });


</script>

	  	  <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
			<script src="fancybox/dist/jquery.fancybox.min.js"></script>
	  
	  
	  
	 </div>
  </div>
</div>
























<div class="fixed-bottom footer"><p class="c"><button class="btn btn-outline-warning" onclick="document.getElementById('id05').style.display='block'">My profile</button> &emsp;About us<p></div>

 <div id="id05" class="modal">
  <?php
 $querySelect4 = sprintf("SELECT id, email, nev, jelszo FROM felhasznalo WHERE id='$_SESSION[id]'"); 
                $eredmeny4 = mysqli_query($link, $querySelect4) or die(mysqli_error($link));
$row4 = mysqli_fetch_array($eredmeny4)
	?>

  <form class="modal-content animate" action="" method="post">
  <div class="imgcontainer">
      <span onclick="document.getElementById('id05').style.display='none'" class="close" title="Close Modal">&times;</span>
	  <div class="row"></div>
    </div>
    <div>
	<p><p>
    <h2><p class="b"> My profile </p></h2>
    </div>

    <div class="container6">
      <label for="other"><b>My name:</b></label>
      <input type="text" class="form-control" name="refelhasznalonev" value="<?=$row4['nev']?>" required>
	  	</div>
	<div class="container6">
      <label for="other"><b>Email:</b></label>
     <input type="email" class="form-control" name="reemail" value="<?=$row4['email']?>" required>
	</div>
	<div class="container6">
      <label for="other"><b>Password:</b></label>
     <input type="password" class="form-control" name="repwd" id="repwd" value="<?=$row4['jelszo']?>" pattern=".{8,}" title="A jelszónak minimum 8 karakterből kell állnia." required>
	</div>
	<div class="container6">
      <label for="other"><b>Re-Password:</b></label>
     <input type="password" class="form-control" name="repwd-repeat" id="repwd-repeat" value="<?=$row4['jelszo']?>" pattern=".{8,}" title="A jelszónak minimum 8 karakterből kell állnia." required>
	</div>
	<div class="container6"
      <h3> <p class="a b" ><button type="submit" name="refresh" class="btn btn-outline-warning">Changa data</button> </p>
    </div>


	 <div  class="flex-container" style="background-color:#f1f1f1">
       <button type="button" onclick="document.getElementById('id05').style.display='none'" class="cancelbtn btn btn-outline-danger" >Cancel</button>
						<a href="deleteaccount.php" class="btn btn-outline-danger right" float="right">Delete profile</a></td>
						<input type="hidden" name="deletefelhasznalo" value="<?=$row4['id']?>" />
						<script>
var password = document.getElementById("repwd")
  , confirm_password = document.getElementById("repwd-repeat");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("A két jelszó nem egyezik.");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
    </div>
  </form>
</div>

<script>



// Get the modal
var modal = document.getElementById('id05');



// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>




</body>
</html>