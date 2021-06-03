<!DOCTYPE html>
	<head>
		<title>Online Quiz System</title>

		<!-- include header -->
		<?php include('header.php') ?>
        <?php 
            session_start();
            if(isset($_SESSION['login_id'])){
                header('Location:home.php');
            }
        ?>
		<!--import css-->
		<link rel = "stylesheet" href="./styles_login.css">

		<!-- Tweaks for older IEs-->
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">	
		<script src="https://kit.fontawesome.com/792cbaa3d1.js" crossorigin="anonymous"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
	</head>

	<body>
		<div class="container" id="container">
			<div class="form-container sign-up-container">
				<!-- sign up form -->
				<form method="post" action="login.php">
					<h2>Create Account</h2>
					</br>
					<input type="text" name = "name" required placeholder="Full name" />
					<input type="text" name = "username" required placeholder="Username" />
					<input type="password" name = "password" required placeholder="Password" />
					<input type="college" name = "college" placeholder="University or College name"/>
					</br>
					<button name = "submit_sgUp">Sign Up</button>
				</form>
			</div>
				<!-- sign in form-->
			<div class="form-container sign-in-container">
				<form action="#" id= "login-frm">
					<h2>Sign in</h2>
					</br>
					<input type="username" name = "username" placeholder="Username" />
					<input type="password" name = "password" placeholder="Password" />
					</br>
					<button name ="submit">Sign In</button>
				</form>
			</div>

			<!-- overlay -->
			<div class="overlay-container">
				<div class="overlay">
					<div class="overlay-panel overlay-left">
						<h2>Welcome Back!</h2>
						<p>To keep connected with your class,</br> please login</p>
						<button class="ghost" id="signIn">Sign In</button>
					</div>
					<div class="overlay-panel overlay-right">
						<h2>Hello, students!</h2>
						<p>You're not in class? </br> Create your account here!</p>
						<button class="ghost" id="signUp">Sign Up</button>
					</div>
				</div>
			</div>
		</div>

		<!-- addEventListener -->
		<script src ="./setup_account.js"></script>
		
		<!-- login code -->
		<script>
			$(document).ready(function(){
				$('#login-frm').submit(function(e){
					e.preventDefault()
					$('#login-frm button').attr('disable',true)
					$('#login-frm button').html('Please wait...')

					$.ajax({
						url:'./login_auth.php',
						method:'POST',
						data:$(this).serialize(),
						error:err=>{
							console.log(err)
							alert('An error occured');
							$('#login-frm button').removeAttr('disable')
							$('#login-frm button').html('Login')
						},
						success:function(resp){
							if(resp == 1){
								location.replace('home.php')
							}else{
								alert("Incorrect username or password.")
								$('#login-frm button').removeAttr('disable')
								$('#login-frm button').html('Login')
							}
						}
					})
				})
			})
    	</script>
		
		<!--sign up code-->
		<script>
			<?php
				include("db_connect.php");
				session_start();
				
				if(isset($_POST['submit_sgUp'])){	
					$name = $_POST['name'];
					$name = stripslashes($name);
					$name = addslashes($name);

					$username = $_POST['username'];
					$username = stripslashes($username);
					$username = addslashes($username);

					
					$password = $_POST['password'];
					$password = stripslashes($password);
					$password = addslashes($password);

					$college = $_POST['college'];
					$college = stripslashes($college);
					$college = addslashes($college);

					$str="SELECT username from user WHERE username='$username'";
					$result=mysqli_query($con,$str);

					/* check if username already registered */
					if((mysqli_num_rows($result)) != 0){
						echo "<center><h3><script>alert('Sorry.. This username is already registered!!');</script></h3></center>";
						header("refresh:0;url=login.php");
					}
					else{
						$str="insert into user set name='$name',usernme='$username',password='$password',college='$college', user_type = 3";
						if((mysqli_query($con,$str)))	
						echo "<center><h3><script>alert('Congrats.. You have successfully registered !!');</script></h3></center>";
                        header('location: welcome.php?q=1');
					}
				}
			?>
		</script>
	</body> 
</html>