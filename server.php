<?php 
	session_start();

	$username = "";
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";

	$db = mysqli_connect('localhost', 'root', '', 'registration');

	if (isset($_POST['reg_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$lastname = mysqli_real_escape_string($db, $_POST['lastname']);
		$phon = mysqli_real_escape_string($db, $_POST['phon']);
		$address = mysqli_real_escape_string($db, $_POST['address']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);

		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($lastname)) { array_push($errors, "Lastname is required"); }
		if (empty($phon)) { array_push($errors, "Phon is required"); }
		if (empty($address)) { array_push($errors, "Address is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		

		if (count($errors) == 0) {
			$password = md5($password_1);
			$query = "INSERT INTO users (username,lastname,phon,address, email, password) 
					  VALUES('$username','$lastname','$phon','$address', '$email', '$password')";
			mysqli_query($db, $query);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}

	}


	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {

				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

?>