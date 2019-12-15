<?php

if(!isset($_SESSION)){session_start();}
//session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'mydb');

// REGISTER Patient Button
if (isset($_POST['register_btn'])) {
  patient_registeration();
}

// REGISTER Doctor Button
if (isset($_POST['create_temp_doc_ac'])) {
  create_temp_ac();
}

// Login Button
if (isset($_POST['login_user'])) {
  login();
}

// Create Temporary Doctor Account
function create_temp_ac(){

  global $conn, $errors;

  $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array

  if (empty($firstname)) { array_push($errors, "First Name is required"); }
  if (empty($lastname)) { array_push($errors, "Last Name is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	  array_push($errors, "Passwords do not match");
  }

  // first check the database to make sure a user does not already exist with the same email
  $user_check_query = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if email exists
    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {

    //encrypt the password before saving in the database
  	$password = md5($password_1);
    
    //Insert data into user table
    $query = "INSERT INTO users (FirstName, LastName, Email, user_type, Password) 
  			  VALUES('$firstname', '$lastname', '$email', 'doctor', '$password')";
  	mysqli_query($conn, $query);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $res = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($res);
    $id = $user['id'];

    $query = "INSERT INTO doctorsdetails
    (DoctorId, FirstName, LastName, Phone, Street, City, Country, Gender, DOB, Nationality, Speciality, Department, Qualifications, Availability)
    VALUES('$id', '$firstname', '$lastname', '', '','', '', '', '', '', '', '', '', '') ";
    mysqli_query($conn, $query);
    $_SESSION['success'] = "Blank Data Inserted" ;
    header('location: create-doctor.php');
  }
}

//Update Doctor Details
if (isset($_POST['update'])) {

  $id = $_SESSION['user']['id'];
  
	$FirstName    			=  $_POST['FirstName'];
  $LastName    			=  $_POST['LastName'];
  $Phone  			=  $_POST['Phone'];
  $Street   		    =  $_POST['Street'];
  $City   			=  $_POST['City'];
  $Country 			=  $_POST['Country'];
  $Gender 	=  $_POST['Gender'];
  $DOB		=  $_POST['DOB'];
  $Nationality	 	=  $_POST['Nationality'];
  $Speciality    		=  $_POST['Speciality'];
  $Department			=	$_POST['Department'];
  $Qualifications		=	$_POST['Qualifications'];
  $Availability		=	$_POST['Availability'];

  //Inserting data into users table
  mysqli_query($conn, "UPDATE users SET FirstName='$FirstName', Lastname = '$LastName' ");

  //Inserting data into doctorsdetails table
	mysqli_query($conn, "UPDATE doctorsdetails SET FirstName='$FirstName', Lastname = '$LastName', Phone= '$Phone', Street='$Street', City = '$City', Country= '$Country', Gender = '$Gender', DOB = '$DOB', Nationality = '$Nationality', Speciality = '$Speciality', Department = '$Department', Qualifications = '$Qualifications', Availability= '$Availability'
   WHERE DoctorId=$id");
	$_SESSION['message'] = "Personal Details Updated!"; 
	header('location: doctor-details.php');
}

//Update patient Details
if (isset($_POST['update-patient-details'])) {

  $id = $_SESSION['user']['id'];
  
	$First_Name               =$_POST['First_Name'];
    $Last_Name                =$_POST['Last_Name'];
	$Phone_number             =$_POST['Phone_number'];
    $BirthDate                =$_POST['BirthDate'];
    $Address                  =$_POST['Address'];
    //$Username                 =$_POST['Username'];
    $DoctorId                 =$_POST['DoctorId'];
    $EmailID                  =$_POST['EmailID'];
    $Social_Security	      =$_POST['Social_Security'];
    $Gender                   =$_POST['Gender'];
    $Height                   =$_POST['Height'];
    $Weight                   =$_POST['Weight'];
    $Marital_Status           =$_POST['Marital_Status'];
    $Occupation               =$_POST['Occupation'];
    $Cholesterol              =$_POST['Cholesterol'];
    $BloodPressure            =$_POST['BloodPressure'];
    $HeartDisease             =$_POST['HeartDisease'];
    $HepatitisB               =$_POST['HepatitisB'];
    $ChickenPox               =$_POST['ChickenPox'];
    $Measles                  =$_POST['Measles'];
    $Medical_History          =$_POST['Medical_History'];
    $Vaccination_History      =$_POST['Vaccination_History'];
    $OtherHealthIssues        =$_POST['OtherHealthIssues'];
    $Emerg_FirstName          =$_POST['Emerg_FirstName'];
    $Emerg_LastName           =$_POST['Emerg_LastName'];
    $Emerg_Relaton            =$_POST['Emerg_Relaton'];
    $Emerg_PhoneNumber1       =$_POST['Emerg_PhoneNumber1'];
    $Emerg_PhoneNumber2       =$_POST['Emerg_PhoneNumber2'];
    $Emerg2_FirstName         =$_POST['Emerg2_FirstName'];
    $Emerg2_LastName          =$_POST['Emerg2_LastName'];
    $Emerg2_Relation          =$_POST['Emerg2_Relation'];
    $Emerg2_PhoneNumber1      =$_POST['Emerg2_PhoneNumber1'];
    $Emerg2_PhoneNumber2      =$_POST['Emerg2_PhoneNumber2'];
  //Inserting data into users table
  mysqli_query($conn, "UPDATE users SET FirstName='$First_Name', Lastname = '$Last_Name' ");

  //Inserting data into patient table
	mysqli_query($conn, "UPDATE patient SET First_Name='$First_Name', Last_Name = '$Last_Name', Phone_number= '$Phone_number', BirthDate='$BirthDate', Address = '$Address', DoctorId= '$DoctorId', EmailID = '$EmailID', Social_Security = '$Social_Security', Gender = '$Gender', Height = '$Height', Weight = '$Weight', Marital_Status = '$Marital_Status', Occupation= '$Occupation',Cholesterol='$Cholesterol',BloodPressure='$BloodPressure',HeartDisease='$HeartDisease',HepatitisB='$HepatitisB',ChickenPox='$ChickenPox',Measles='$Measles',Medical_History='$Medical_History',Vaccination_History='$Vaccination_History',OtherHealthIssues='$OtherHealthIssues',Emerg_FirstName='$Emerg_FirstName',Emerg_LastName='$Emerg_LastName',Emerg_Relaton='$Emerg_Relaton',Emerg_PhoneNumber1='$Emerg_PhoneNumber1',Emerg_PhoneNumber2='$Emerg_PhoneNumber2',Emerg2_FirstName='$Emerg2_FirstName',Emerg2_LastName='$Emerg2_LastName',Emerg2_Relation='$Emerg2_Relation',Emerg2_PhoneNumber1='$Emerg2_PhoneNumber1',Emerg2_PhoneNumber2='$Emerg2_PhoneNumber2'
    WHERE idPatient=$id");
	$_SESSION['message'] = "Patient Details Updated!"; 
	header('location: patient-details.php');
}

//Patient Registration
function patient_registeration() {

  global $conn, $errors;

  // receive all input values from the form

  $First_Name						=  $_POST['First_Name'];
  $Last_Name   		    		=  $_POST['Last_Name'];
  $Phone_number					=  $_POST['Phone_number'];
  $Cholesterol 					=  $_POST['Cholesterol'];
  $Emerg_FirstName 				=  $_POST['Emerg_FirstName'];
  $Emerg_LastName 				=  $_POST['Emerg_LastName'];
  $Emerg_Relaton 					=  $_POST['Emerg_Relaton'];
  $Emerg_PhoneNumber1 			=  $_POST['Emerg_PhoneNumber1'];
  $Emerg2_PhoneNumber2 			=  $_POST['Emerg2_PhoneNumber2'];
  $Emerg_PhoneNumber2 			=  $_POST['Emerg_PhoneNumber2'];
  $HepatitisB	 					=  $_POST['HepatitisB'];
  $ChickenPox 					=  $_POST['ChickenPox'];
  $Measles 						=  $_POST['Measles'];
  $Medical_History 				=  $_POST['Medical_History'];
  $Height 						=  $_POST['Height'];
  $Weight 						=  $_POST['Weight'];
  $Username 						=  $_POST['Username'];
  $Password 						=  $_POST['Password'];
  $Gender 						=  $_POST['Gender'];
  $Occupation 					=  $_POST['Occupation'];
  $Marital_Status 				=  $_POST['Marital_Status'];
  $EmailID						=  $_POST['EmailID'];
  $Social_Security 				=  $_POST['Social_Security'];
  $Emerg2_Relation 				=  $_POST['Emerg2_Relation'];
  $Emerg2_FirstName 				=  $_POST['Emerg2_FirstName'];
  $Emerg2_LastName                =  $_POST['Emerg2_LastName'];
  $Emerg2_PhoneNumber1 			=  $_POST['Emerg2_PhoneNumber1'];
  $BloodPressure	 				=  $_POST['BloodPressure'];
  $HeartDisease 					=  $_POST['HeartDisease'];
  $Vaccination_History 			=  $_POST['Vaccination_History'];
  $OtherHealthIssues 				=  $_POST['OtherHealthIssues'];
  $AreaPhonepersonal				=  $_POST['AreaPhonepersonal'];
  $BirthDay						=  $_POST['BirthDay'];
  $BirthMonth						=  $_POST['BirthMonth'];
  $BirthYear						=  $_POST['BirthYear'];
  $Street_Address					=  $_POST['Street_Address'];
  $Street_Address2				=  $_POST['Street_Address2'];
  $City							=  $_POST['City'];
  $State							=  $_POST['State'];
  $PostalCode						=  $_POST['PostalCode'];
  $Country						=  $_POST['Country'];
  $Area1Cont1						=  $_POST['Area1Cont1'];
  $Area2Cont1						=  $_POST['Area2Cont1'];
  $Area1Cont2						=  $_POST['Area1Cont2'];
  $Area2Cont2						=  $_POST['Area2Cont2'];


 

 // first check the database to make sure a user does not already exist with the same username and/or email
 $user_check_query = "SELECT * FROM users WHERE Email='$email' ";
 $result = mysqli_query($conn, $user_check_query);
 $user = mysqli_fetch_assoc($result);
 
 if ($user) { // if user exists
   if ($user['email'] === $EmailID) {
     array_push($errors, "Email already exists");
   }
 }

 // Finally, register user if there are no errors in the form
 if (count($errors) == 0) {

   //encrypt the password before saving in the database
   $Password = md5($Password);


   // Inserting data into users table
   $query = "INSERT INTO users (FirstName, LastName, Email, user_type, Password) VALUES('$FirstName', '$LastName', '$EmailID', 'patient', '$Password')";
   mysqli_query($conn, $query);

   $query = "SELECT * FROM users WHERE Email='$EmailID'";
    $res = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($res);
    $id = $user['id'];


   // Inserting data into patients table
  $query = "INSERT INTO patient(idPatient, First_Name,Last_Name,Phone_number,BirthDate,Address,Cholesterol,Emerg_FirstName,Emerg_LastName,Emerg_Relaton,Emerg_PhoneNumber1,Emerg2_PhoneNumber2,Emerg_PhoneNumber2,	HepatitisB,
  ChickenPox,Measles,Medical_History,Height,Weight,Username,	Password, Gender, Occupation, Marital_Status, EmailID, Social_Security,	
  Emerg2_Relation, Emerg2_FirstName,Emerg2_LastName, Emerg2_PhoneNumber1, BloodPressure, HeartDisease, Vaccination_History, 
  OtherHealthIssues)values('$id','$First_Name','$Last_Name',CONCAT('$AreaPhonepersonal','$Phone_number'),CONCAT('$BirthDay','$BirthMonth','$BirthYear'),	
  CONCAT('$Street_Address','$Street_Address2','$City','$State','$PostalCode','$Country'),'$Cholesterol','$Emerg_FirstName','$Emerg_LastName',
  '$Emerg_Relaton',CONCAT('$Area1Cont1','$Emerg_PhoneNumber1'),CONCAT('$Area2Cont2','$Emerg2_PhoneNumber2'),CONCAT('$Area2Cont1','$Emerg_PhoneNumber2'),'$HepatitisB',	'$ChickenPox','$Measles',
  '$Medical_History','$Height','$Weight','$Username','$Password','$Gender','$Occupation',	'$Marital_Status','$EmailID',
  '$Social_Security','$Emerg2_Relation','$Emerg2_FirstName','$Emerg2_LastName',CONCAT('$Area1Cont2','$Emerg2_PhoneNumber1'),'$BloodPressure',
  '$HeartDisease','$Vaccination_History',	'$OtherHealthIssues')";
   mysqli_query($conn,$query);
  /**/
    $_SESSION['user'] = $user;
    $_SESSION['success'] = "You are now logged in";
    header('location: dashboard.php');
    
 }
}

//Login
function login() {
  global $conn, $username, $errors;

  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (empty($email)) {
  	array_push($errors, "Email is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {

    $password = md5($password);
    
  	$query = "SELECT * FROM users WHERE Email='$email' AND Password='$password'";
    $results = mysqli_query($conn, $query);
  
    if (mysqli_num_rows($results) == 1) { // user found
      
      // check user type
      $logged_in_user = mysqli_fetch_assoc($results);
      $usertype = $logged_in_user['user_type'];
      $userid = $logged_in_user['id'];

			if ($usertype == 'admin') {
        $_SESSION['user'] = $logged_in_user;
        $_SESSION['success']  = "You are now logged in";
        header('location: admin-dashboard.php');		  
			}else if ($usertype == 'patient') {
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: dashboard.php');
			} else if ($usertype == 'doctor'){
        $_SESSION['user'] = $logged_in_user;
        $_SESSION['success']  = "You are now logged in";

        $query = "SELECT * FROM doctorsdetails WHERE DoctorId='$userid' ";
        $res = mysqli_query($conn, $query);
        $logged_in_user = mysqli_fetch_assoc($res);
        $phone = $logged_in_user['Phone'];
        if($phone = "") { 
          header('location: doctor-details.php');
        } else {
          header('location: doctor-dashboard.php');
        }
      }
		}else {
			array_push($errors, "Wrong username/password combination");
    }
    
    /*
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: dashboard.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
    }
    */

  }
}

//Logout
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['user']);
  header("location: login.php");
}

// Checks if user is the Admin
function isAdmin() {
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}

function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
  }
  

// return user array from their id
function getUserById($id){
  global $conn;
  $query = "SELECT * FROM users WHERE id=" . $id;
  $result = mysqli_query($conn, $query);

  $user = mysqli_fetch_assoc($result);
  return $user;
}

//Returns User Type - Doctor/Patient
function userType() {
  if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'doctor' ) {
		return 2;
	}else if(isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'patient' ) {
    return 3;
  }
}


?>
