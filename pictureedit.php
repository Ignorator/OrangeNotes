
<?php
include 'notes.php';
$link = getDb(); 
// Start the session
session_start();
			if(isset($_SESSION['emaillogin'])==false)
			{header('Location:index.php');;}


$creatednote = false;
if (isset($_POST['modify'])) {
    $kepleiras = mysqli_real_escape_string($link, $_POST['kepleiras']);
	$id=$_GET['pictureid'];
	$felhasznaloid=$_SESSION['id'];

  $query4 = sprintf("UPDATE fenykep SET leiras='%s' WHERE id=%s AND felhasznaloid=%s",
                $kepleiras, $id, $felhasznaloid);
        mysqli_query($link, $query4) or die(mysqli_error($link));
header("location: home.php");
}

else if (isset($_POST['delete'])){
    $pst=$_POST['delete'];
	$ssid=$_SESSION['id'];
	$query1 = sprintf("DELETE FROM fenykep WHERE id=%s AND felhasznaloid =%s",mysqli_real_escape_string($link, $pst),mysqli_real_escape_string($link, $ssid));
	$ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));
	$targetDir = "uploads/$_SESSION[id]/";
	$file=$targetDir . $_POST['deletefile'];
	unlink($file);
	header("location: home.php");

	/*$pst=$_POST['delete'];
	$ssid=$_SESSION['id'];
	echo "a jegyzetid: $pst a sessionid: $ssid";*/
	}

?>
<!DOCTYPE html>
	<html>
		<head>
			<title>Orange notes</title>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
				<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
				<script src="/jquery.bpopup.min.js"></script>
		<style>
		body {font-family: Bahnschrift;}

		.btn-outline-warning{color:#ffc107;background-color:transparent;background-image:none;border-color:#ffc107}.btn-outline-warning:hover{color:#212529;background-color:#ffc107;border-color:#ffc107}.btn-outline-warning.focus,.btn-outline-warning:focus{box-shadow:0 0 0 .2rem rgba(255,193,7,.5)}.btn-outline-warning.disabled,.btn-outline-warning:disabled{color:#ffc107;background-color:transparent}.btn-outline-warning:not(:disabled):not(.disabled).active,.btn-outline-warning:not(:disabled):not(.disabled):active,.show>.btn-outline-warning.dropdown-toggle{color:#212529;background-color:#ffc107;border-color:#ffc107}.btn-outline-warning:not(:disabled):not(.disabled).active:focus,.btn-outline-warning:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-warning.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(255,193,7,.5)}
		 .btn-outline-danger{color:#dc3545;background-color:transparent;background-image:none;border-color:#dc3545}.btn-outline-danger:hover{color:#fff;background-color:#dc3545;border-color:#dc3545}.btn-outline-danger.focus,.btn-outline-danger:focus{box-shadow:0 0 0 .2rem rgba(220,53,69,.5)}.btn-outline-danger.disabled,.btn-outline-danger:disabled{color:#dc3545;background-color:transparent}.btn-outline-danger:not(:disabled):not(.disabled).active,.btn-outline-danger:not(:disabled):not(.disabled):active,.show>.btn-outline-danger.dropdown-toggle{color:#fff;background-color:#dc3545;border-color:#dc3545}.btn-outline-danger:not(:disabled):not(.disabled).active:focus,.btn-outline-danger:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-danger.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(220,53,69,.5)}	
			.flex-container{
				display: flex;
				flex-direction: row;
				justify-content: space-between;
				padding: 16px;}
			.flex-container4{
				display: flex;
				flex-direction: row;
				justify-content: space-between;
				flex-flow:wrap;
				padding: 16px;}
			.flex-container2{
				display: flex;
				flex-direction: column;
			}
			.flex-container3{
				display: flex;
				flex-direction: column;
				width: 30%;
			}
			.flex-container3 .btn{
				width: 45%;
			}
			.gallery img {
				 width: 100%;
				height: auto;
				border-radius: 10px;
				padding: 6px;
				cursor: pointer;
				transition: .3s;
		}
		
			
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
			p.a {
			font-family: "Bahnschrift";
				}
			p.b{
			text-align: center;
			    }
			p.c{
				color: #ffc107;
			}
			.lh{
				line-height: 60px
			}
			textarea {
			width:100%;
			border: 1px solid #ccc;
			height: 150px;
			resize: none;
}
		
			.container6{
				padding: 10px;
			}
			.container3{
				padding-top:193px;
			}
			.container2 {
			padding: 16px;
				}
			.mh1 div {
			height: 100vh;}

			.Circle {
			 border-radius: 50%;
			 border: 2px solid ffc107;
			 width: 36px;
			 height: 36px;
			 }



		
			 }


			.nav-tabs{
			 background-color:#ffc107;
					}
			.tab-content{
			  background-color:#fff
			 color:#fff;
			 padding:5px
					}
			.nav-tabs > li > a{
			 border: medium none;
			 color: black;
}
			.nav-tabs > li > a:hover{
			 background-color: #ffc107 !important;
			  border: medium none;
			 border-radius: 0;
				color:#fff;
					}
			
			.footer{
				position:  static;
				text-align: right;
				bottom: 5px;
				width: 87%;
			}
			.bts-popup {
				position: fixed;
				z-index: 1; /* Sit on top */
				left: 30%;
				top: 10%;
				width: 40%; 
				height: 100%; /* Full height */
				overflow: auto; /* Enable scroll if needed */
				padding-top: 70px;
				}

			/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 30%;
    top: 10%;
    width: 40%; 
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    padding-top: 70px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #fecb6f;
    width: 80%; /* Could be more or less, depending on screen size */
	opacity: 80%
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }}

			</style>
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
    <li><a data-toggle="tab" href="">Home</a></li>
    <li><a data-toggle="tab" href="">Notes</a></li>
    <li  class="active"><a data-toggle="tab" href="">Pictures</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade">
      <h3>Search</h3>
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
                    </tr> 
                </thead>
				<?php endif; ?> 
				<?php while ($eredmeny!=NULL && $row = mysqli_fetch_array($eredmeny)): ?>
                    <tr>
                        <td><?=$row['jegyzetnev']?></td>
                        <td><?=$row['jegyzetszoveg']?></td>
                        <td><?=$row['jegyzetdatum']?></td>                        
                    </tr>                
                <?php endwhile; ?> 
                </tbody>
            </table>




	 </div>
	<div id="Notes" class="tab-pane fade">
      <h3>Notes</h3>
	  <button class="btn btn-outline-warning Circle">+</button>
	  			



















	  <p> </p>
	  <?php
            $querySelect2 = "SELECT id, jegyzetszoveg, jegyzetnev, jegyzetdatum FROM jegyzet WHERE felhasznaloid='$_SESSION[id]'";         
            $eredmenynotes = mysqli_query($link, $querySelect2) or die(mysqli_error($link));
			?>
            <table class="table table-striped table-sm table-bordered">
                <tbody>
				<thead class="thead-dark">
                    <tr>
                        <th>jegyzetnév</th>
                        <th>jegyzetszöveg</th>      
                        <th>dátum</th> 
						<th></th>
						<th></th>
						<th></th>
                    </tr> 
                </thead>
				<?php while ($row = mysqli_fetch_array($eredmenynotes)): ?>
                    <tr>
                        <td><?=$row['jegyzetnev']?></td>
                        <td><?=$row['jegyzetszoveg']?></td>
                        <td><?=$row['jegyzetdatum']?></td>  
						<td align="center"><a type="button" class="btn btn-outline-warning">Edit</a></td>
						<td align="center"><button type="submit" class="btn btn-outline-danger">Delete</button></td>
					

					</tr>  
				 <?php endwhile; ?> 
                </tbody>
            </table>


    </div>
    <div id="Pictures"  class="tab-pane fade in active">
      <h3>Pictures</h3>
      <button class="btn btn-outline-warning Circle">+</button>
	  <p> </p>



	  <div id="id02" class="bts-popup">

  <?php
            $querySelect3 = "SELECT * FROM fenykep WHERE felhasznaloid='$_SESSION[id]' AND id='$_GET[pictureid]'";         
            $eredmenynotes2 = mysqli_query($link, $querySelect3) or die(mysqli_error($link));
			$row = mysqli_fetch_array($eredmenynotes2);
			?>
  <form class="modal-content animate" action="" method="post">
  <div class="imgcontainer">
      <a href="home.php" class="close" title="Close Modal">&times;</a>
	  <div class="row"></div>
    </div>
    <div>
	<p><p>
    <h2><p class="b"> Edit picture </p></h2>
    </div>

 
	<div class="container2">
      <label for="other"><b>Description:</b></label>
      <textarea name="kepleiras" value="<?=$row['leiras']?>" ><?=$row['leiras']?>  </textarea>
	</div>
	<div class="container2"
      <h3> <p class="a b" ><button type="submit" name="modify" class="btn btn-outline-warning">Modify</button> </p>
    </div>



    <div  class="flex-container" style="background-color:#f1f1f1">
      <a href="home.php" class="cancelbtn btn btn-outline-danger" >Cancel</a>
						<button class="btn btn-outline-danger right" float="right">Delete picture</button></td>
						<input type="hidden" name="delete" value="<?=$_GET['pictureid']?>" />
						<input type="hidden" name="deletefile" value="<?=$row['file_name']?>" />

    </div>
  </form>
</div>

<script  type="text/javascript">
// Get the modal
var modal = document.getElementById('id02');



</script>
<script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="fancybox/jquery.fancybox.js"></script>
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
			<a type="button" class="btn btn-outline-warning" >Edit</a>
			<button class="btn btn-outline-danger" float="right" >Delete</button>
				</div>
			</div>

		
		


        <?php }} ?>


    </div>
</div>


<script type="text/javascript">
    $("[data-fancybox]").fancybox({ });


</script>
	 </div>
  </div>
</div>

<div class="fixed-bottom footer"><p class="c"><button class="btn btn-outline-warning" onclick="">My profile</button> &emsp;About us<p></div>




</body>
</html>