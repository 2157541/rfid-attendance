<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Login page</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel= "stylesheet" href="css/login.style.css"/>
		<link rel= "stylesheet" href="css/font.css"/>
		<link rel="stylesheet" href="fontawesome/css/all.min.css">
	</head>
	
	<body>
		<div class="modal-dialog text dialog">
			<div class ="col-sm-8 main-section">
				<div class = "modal-content">	
				
					<!-- Form start here -->
					<form class="form-container">
						<h1>Log in</h1>
						<hr>
						
						<!-- Alert Message -->
						<div id="error_message"></div>
						
						<!-- Input Username -->
						<div class="form-group">
							<h6> Username</h6>
							<input type="username" class="form-control" id="username" name="username" placeholder="Username"/>
						</div>
						
						<!-- Input Password -->
						<div class="form-group">
							<h6> Password</h6>
							<input type="password" class="form-control" id="password" name="password" placeholder="Password"/>
						</div> 	
						
						<!-- Submit Button -->
						<button type="button" class="btn btn-primary btn-block" value="Submit" name="login_submit" id="login_submit">Sign in</button>				
					</form>
					
				</div>
			</div>
		</div>
	</body>
	
	  <script src="js/jquery.min.js" type="text/javascript"></script> 
		<script type="text/javascript"> 
		     $(document).ready(function(){
                $("#login_submit").click(function(){
                    var username = $("#username").val().trim();
                    var password = $("#password").val().trim();

                    if( username != "" && password != "" ){
                        $.ajax({
                            url:'login_check.php',
                            type:'post',
                            data:{username:username,password:password},
                            success:function(response){
                                var error = "";
                                if(response == true){
                                    window.location = "Home.php";
                                }else{
                                    error = "<div class='alert alert-danger'>Acess Denied!</div>";
                                }
                                $("#error_message").html(error);
                            }
                        });
                    }
                });
            });
			</script>
	
</html>