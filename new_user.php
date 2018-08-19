<?php 

require("lib.php");
if (!isLogin()) header("location: index.php");
$desig = getDesig();
if ($desig != 1) header("location: index.php");
if ($_SERVER['REQUEST_METHOD'] == "POST"){
	$conn=getConnection();
	$id=$_POST['id'];
    $name=$_POST['first_name'];
    $user=$_POST['username'];
    $pass=$_POST['password'];
    $desig=$_POST['desig'];
    $date=date("y-m-d");
    if($_POST['desig']==2)
      {$sql="INSERT INTO `staff_details` (`user`, `name`,`fac_id`) VALUES ('$user', '$name', '$id' )";}
    else if($_POST['desig']==3)
      {$sql="INSERT INTO `teacher_details` (`user`, `name`, `reg_date`, `fac_id ) VALUES ('$user', '$name', '$date', '$id' )";}
    else if($_POST['desig']==4)
      {$sql="INSERT INTO `student_details` (`user`, `name`, `enroll_num`, `reg_date`) VALUES ('$user', '$name', '$id', '$date' )";}    
    $sql1="INSERT INTO `login` (`user`, `pass`, `desig`) VALUES ('$user', '$pass', '$desig')";
    mysqli_query($conn,$sql);
    mysqli_query($conn,$sql1);

}




?>
<!DOCTYPE html>
<html>
	<head>
		<title>Library Management</title>
		<?php getIncludes(); ?>
	</head>
	<body>
       	<script type="text/javascript">
			$(document).ready(function(){
				$('select').material_select();
			});
		</script>
        <?php getNavBar("Add New User"); ?>
        
      <div class="col s12">
					<blockquote>
						<h3>Add New User</h3>
					</blockquote>
				</div> 
      
      <div class="row">
    <form class="col s12" method="post">
      <div class="row">
        <div class="input-field col s6">
          <input  name="first_name" type="text" class="validate">
          <label for="first_name">First Name</label>
        </div>
        <div class="input-field col s6 ">
          <input name="last_name" type="text" class="validate">
          <label for="last_name">Last Name</label>
        </div>
      </div>
      <div class="input-field col s12">
          <input name="id" type="text" class="validate">
          <label for="id">Reg ID</label>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input name="username" type="text" class="validate">
          <label for="username">Username</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input name="password" type="password" class="validate">
          <label for="password">Password</label>
        </div>
      </div>
       <div class="input-field col s12">
    <select name="desig">
      <option value="NULL" disabled selected>Choose your option</option>
      <option value="2">Staff Member</option>
      <option value="3">Faculty</option>
      <option value="4">Student</option>
    </select>
    <label>Designation</label>
  </div>
    <centre><button class="btn waves-effect waves-gray" type="submit">Add User<i class="material-icons"></i></button>
     </centre>
      
       
      
      
    </form>
  </div>
    </body>
</html>        


<?php
include("footer.php");