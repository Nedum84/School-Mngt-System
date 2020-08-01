<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<style type="text/css">
		*{
			box-sizing: border-box;
			margin: 0;
			padding: 0;
			font-family: georgia;
		}
		body{
			background-color: #E1D6CB;
		}

		div.login{
			width: 100%;
			height: 100%;
			padding-top: 5%;
		}

		.login .login_content{
			width: 50%;
			height: 500px;
			margin: 0 auto;
			border: 1px solid rgba(0,0,0,0.2);
			border-bottom-right-radius: 12px;
			border-bottom-left-radius: 12px;
		}

		.login_content .logo{
			width: 100%;
			height: 100px;
			background-color: #510000;
			text-align: center;
			padding-top: 5%;
		}

		.logo h3{
			color: #fff;
			font-size: 26px;
			font-variant: small-caps;
			font-style: normal;
			line-height: normal;
			font-weight: normal;
		}

		.login_content .login_proper{
			width: 100%;
			height: 100%;
			text-align: center;
			padding-top: 8%;
		}

		.login_proper h3{
			color: #000;
			font-style: italic;
			font-size: 26px;
			font-variant: small-caps;
			font-style: normal;
			line-height: normal;
			font-weight: normal;
		}

		.login_proper form input{
			width: 80%;
			height: 38px;
			padding: 4px 4px 4px 12px;
			display: block;
			border:1px solid rgba(0,0,0,0.3);
			outline: none;
			font-size: 1em;
			border-radius: 4px;
			margin: 14px auto;
		}

		.login_proper form input:focus{border:1px solid #510000;}

		.login_proper form input[type='submit']{
			width: 50%;
			background-color: rgba(81,0,0,1);
			color: #bbb;
			font-weight: bold;
			cursor: pointer;
			transition: .1s;
		}
		.login_proper form input[type='submit']:hover{
			background-color: rgba(81,0,0,.8);			
		}
		.login_proper form input[type='checkbox']{
			display: inline-block;
			vertical-align: top;
			width: 5%;
			margin: 0;
		}	

		.login_proper form label{
			display: block;
			margin: 0;
			width: 100%;
		}
		.login_proper form label span{
			display: inline-block;
			vertical-align: top;
			padding-top: 8px;
		}
		.login_proper form span.feed_back_error{
			color: rgb(250,62,62);
		}

		@media(max-width: 700px){
			.login .login_content{
				width: 60%;
				height: 450px;
			}
		}

		@media(max-width: 500px){.login .login_content{width: 80%;}  .login_proper h3{font-size: 22px;} }
		@media(max-width: 390px){.login .login_content{width: 94%;height: 400px;} .login_proper h3{font-size: 20px;}
		 .login_proper form input{width: 90%;height: 30px;} .login_proper form label span{padding-top: 20px;} }

	</style>
</head>
<body>
	<div class="login">
		<div class="login_content">
			<div class="logo"><h3>Sample Secondary School</h3></div>
			<div class="login_proper">
				<h3>Login Form</h3>
				<!-- <form action="" method="post"> -->
				<form action="portal/process/signIn" method="post">
					<input type="text" placeholder="Identity Number" name="identity" required>
					<input type="password" placeholder="Password" name="password" required>
					<span class="feed_back_error">
						<?php                
                        if (isset($_POST['submit'])) {
                        	echo("Incorret login details");
                        }
                                ?>
                    </span>
					<center>
						<label><input type="checkbox" name="remember"> <span>Remember me</span></label>
					</center>
					<input type="submit" name="submit" value="Login">
				</form>
			</div>
		</div>
	</div>

</body>
</html>