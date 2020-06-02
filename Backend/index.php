<?php
include('session.php');
if(isset($_SESSION['current_uid']))
{
	echo '<script type="text/javascript">';
	echo 'window.location.href = "user.php"';
	echo '</script>';
}
$color = (isset($_GET['Success']))?"green":"red";

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="JS/script.js"></script>
        <title>Contact Manager Deluxe&#8482</title>
        <link rel="stylesheet" type="text/css" href="CSS/normalize.css">
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="CSS/style.css">
        <body>
            <div class="login-background">

                <div class="login-box"> <!-- Our Front -->
                    <img src="CSS/Logo.png" class="logo"/>

					<?php
					if (!isset($_GET['Task']))
					{

						?>

					 <div class="button-select">
                        <div class="button-color"></div>
                        <button id="login-butt" type="button" class="toggle-log">Login</button>
                        <button id="register-butt" type="button" class="toggle-reg">Register</button>
                    </div>
					 <!-- Login -->
                    <form id="login" action="" method="post" class="input-group">
                        <div id="rtnlogin" style="text-align:center;color:<?php echo $color; ?>"><?php echo (isset($_GET['Success']))?$_GET['Success']:""; ?></div>
                        <div class="input-box">
                            <input type="text"  name="Email" placeholder="E-mail Address" required>

                        </div>
                        <div class="input-box">
                            <input type="password" name="Password" placeholder="Password" required>

                        </div>
                        <input type="button" id="signin" name="SignIn" class="submit-btn" value="Sign In">
                        <br/>

                        <a class="forgot" href="#">Forgot Password?</a>
                    </form>

                    <!-- Register -->

                    <form id="register" method="post" class="input-group" >
                        <div id="rtnregister" style="text-align:center;color:red;"></div>
                        <div class="register-box">
                            <input type="text" name="Name" placeholder="Full Name" required>
                            <input type="email" name="Email" placeholder="E-mail Address" required>
                            <input type="password" id="password" name="Password" placeholder="Password" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one uppercase and lowercase letter, and at least 8 or more characters" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Follow Password Requirements' : ''); if(this.checkValidity()) form.confirm.pattern = this.value;" required>
                            <input type="password" id="confirm" name="confirm" placeholder="Confirm Password" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}"title="Confirm Password" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Passwords do not match' : '');" required>

                        </div>
                        <input type="button" id="createuser" class="submit-btn" name="" value="Register">
                        <div id="message">
                            <h6>Password must contain the following:</h6>
                            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                            <h5 id="confirmpassword" style="padding: 8px;">Passwords do not match. Please reconfirm password.</h5>
                        </div>
                    </form>

						<!-- Reset via Email -->
					 <form id="resetform" action="" method="post" class="input-group">
                        <div id="rtnreset" style="text-align:center;color:red;"></div>
						  <br>
                        <div class="input-box">
                            <input type="email"  name="Email" placeholder="E-mail Address" required>

                        </div>
						 <br>
						 <input type="button" id="sendcode" class="submit-btn" value="Reset Password">
                        <br/>
						  <br>
                        <a class="back" href="#">I Have An Account</a>

                    </form>
				<?php }else{ ?>
					    <form id="resetpass" method="post" class="input-group" >
                        <div id="rtnpass" style="text-align:center;color:red;"></div>
                        <div class="register-box">

                            <input type="password" id="password" name="Password" placeholder="New Password" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one uppercase and lowercase letter, and at least 8 or more characters" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Follow Password Requirements' : ''); if(this.checkValidity()) form.confirm.pattern = this.value;" required>
                            <input type="password" id="confirm" name="confirm" placeholder="Confirm New Password" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}"title="Confirm Password" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Passwords do not match' : '');" required>
							<input type="hidden" name="Email" value="<?php echo $_GET['Email']; ?>">
							<input type="hidden" name="Code" value="<?php echo $_GET['Code']; ?>">
							<input type="hidden" name="Task" value="<?php echo $_GET['Task']; ?>">
                        </div>
                        <input type="button" id="resetpassword" class="submit-btn" name="" value="Reset Password">
                        <div id="message">
                            <h6>Password must contain the following:</h6>
                            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                            <h5 id="confirmpassword" style="padding: 8px;">Passwords do not match. Please reconfirm password.</h5>
                        </div>
                    </form>
					<?php } ?>


                </div>
                <script>
                    var passwordInput = document.getElementById("password");
                    var confirmInput = document.getElementById("confirm");
                    var letter = document.getElementById("letter");
                    var capital = document.getElementById("capital");
                    var length = document.getElementById("length");

                    passwordInput.onfocus = function() {
                        document.getElementById("message").style.display = "block";
                    }


                    confirmInput.onfocus = function() {

                        if(passwordInput.value != confirmInput.value){
                            document.getElementById("confirmpassword").style.display = "block";
                        }

                    }

                    confirmInput.onkeyup = function(){

                        if(passwordInput.value == confirmInput.value){
                            document.getElementById("confirmpassword").style.display = "none";
                        }
                        else
                            document.getElementById("confirmpassword").style.display = "block";
                    }

                    passwordInput.onkeyup = function() {

                        var lowerCaseLetters = /[a-z]/g;
                        if(passwordInput.value.match(lowerCaseLetters)) {
                            letter.classList.remove("invalid");
                            letter.classList.add("valid");
                        } else {
                            letter.classList.remove("valid");
                            letter.classList.add("invalid");
                        }

                        var upperCaseLetters = /[A-Z]/g;
                        if(passwordInput.value.match(upperCaseLetters)) {
                            capital.classList.remove("invalid");
                            capital.classList.add("valid");
                        } else {
                            capital.classList.remove("valid");
                            capital.classList.add("invalid");
                        }

                        if(passwordInput.value.length >= 8) {
                            length.classList.remove("invalid");
                            length.classList.add("valid");
                        } else {
                            length.classList.remove("valid");
                            length.classList.add("invalid");
                        }

                        if(passwordInput.value != confirmInput.value){
                            document.getElementById("confirmpassword").style.display = "block";
                        }
                        else
                            document.getElementById("confirmpassword").style.display = "none";
                    }


                </script>
                <script>$(document).ready(function(){

                        $.fn.serializeObject = function()
                        {
                            var o = {};
                            var a = this.serializeArray();
                            $.each(a, function() {
                                if (o[this.name] !== undefined) {
                                    if (!o[this.name].push) {
                                        o[this.name] = [o[this.name]];
                                    }
                                    o[this.name].push(this.value || '');
                                } else {
                                    o[this.name] = this.value || '';
                                }
                            });
                            return o;
                        };

                        $("#signin").on('click', function(){
							 event.preventDefault();
                            // send ajax
                            $.ajax({
                                url: '/ContactDeluxe/Endpoints/login.php',
                                type : "POST",
                                dataType : 'json', // data type
                                data: JSON.stringify($('#login').serializeObject()),
                                contentType: 'application/json;charset=UTF-8',
                                success : function(result) {

                                    console.log(result);
                                    window.location.href = "user.php";
                                },
                                error: function(xhr, resp, text) {
                                    //console.log(xhr, resp, text);

                                    var obj = JSON.parse(xhr.responseText);
                                    console.log(obj.Error);
									$("#rtnlogin").css("color","red");
                                    $("#rtnlogin").text(obj.Error);
                                }
                            })
                        });
					  $("#createuser").on('click', function(){
						if (letter.classList.contains("valid") && capital.classList.contains("valid") && length.classList.contains("valid") && (passwordInput.value == confirmInput.value))
						{

                            $.ajax({
                                url: '/ContactDeluxe/Endpoints/register.php',
                                type : "POST",
                                dataType : 'json', // data type
                                data: JSON.stringify($('#register').serializeObject()),
                                contentType: 'application/json;charset=UTF-8',
                                success : function(result) {


                                    window.location.href = "user.php";

                                },
                                error: function(xhr, resp, text) {
                                    console.log(xhr, resp, text);

                                    var obj = JSON.parse(xhr.responseText);
                                    console.log(obj.Error);
                                    $("#rtnregister").text(obj.Error);

                                }
                            })



						}

					 });
						$("#sendcode").on('click', function(){


                            $.ajax({
                                url: '/ContactDeluxe/Endpoints/forgotPassword.php',
                                type : "POST",
                                dataType : 'json', // data type
                                data: JSON.stringify($('#resetform').serializeObject()),
                                contentType: 'application/json;charset=UTF-8',
                                success : function(result) {

									$("#rtnreset").text("Reset Code Sent");
									$("#rtnreset").css("color","green");
                                   // window.location.href = "user.php";

                                },
                                error: function(xhr, resp, text) {
                                    console.log(xhr, resp, text);

                                    var obj = JSON.parse(xhr.responseText);
                                    console.log(obj.Error);
									$("#rtnreset").css("color","red");
                                    $("#rtnreset").text(obj.Error);


                                }
                            })





					 });
						$("#resetpassword").on('click',function(){
						if (letter.classList.contains("valid") && capital.classList.contains("valid") && length.classList.contains("valid") && (passwordInput.value == confirmInput.value))
						{
							  $.ajax({
                                url: '/ContactDeluxe/Endpoints/resetPassword.php',
                                type : "POST",
                                dataType : 'json', // data type
                                data: JSON.stringify($('#resetpass').serializeObject()),
                                contentType: 'application/json;charset=UTF-8',
                                success : function(result) {


                                   	window.location.href = "index.php?&Success=Password Reset";

                                },
                                error: function(xhr, resp, text) {
                                    console.log(xhr, resp, text);

                                    var obj = JSON.parse(xhr.responseText);
                                    console.log(obj.Error);
									$("#rtnpass").css("color","red");
                                    $("#rtnpass").text(obj.Error);


                                }
                            })

						}

						});

                    });
                </script>
			</div>
                </body>
            </head>
        </html>
