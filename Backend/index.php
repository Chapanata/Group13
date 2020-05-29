<?php

include('session.php');
if(isset($_SESSION['current_uid'])){
echo '<script type="text/javascript">';
echo 'window.location.href = "user.php"';
echo '</script>';
}else{

}

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

            <div class="button-select">
                <div class="button-color"></div>
                <button id="login-butt" type="button" class="toggle-log">Login</button>
                <button id="register-butt" type="button" class="toggle-reg">Register</button>
            </div>
                <div class="login-box"> <!-- Our Front -->
                    <img src="CSS/Logo.png" class="logo">

                    <!-- Login -->

                    <form id="login" action="" method="post" class="input-group">
                        <div class="input-box">
                            <input type="text"  name="Email" placeholder="E-Mail Address" required>

                        </div>
                        <div class="input-box">
                            <input type="password" name="Password" placeholder="Password" required>

                        </div>
                        <input type="button" id="signin" name="SignIn" value="Sign In">
                        <br/>
                        <a class="forgot" href="#">Forgot Password?</a>
                    </form>

                    <!-- Register -->

                    <form id="register" class="input-group">
                        <div class="register-box">
                            <input type="email" name="username" placeholder="E-mail Address" required>
                            <input type="password" id="password" name="password" placeholder="Password" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one uppercase and lowercase letter, and at least 8 or more characters" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Follow Password Requirements' : ''); if(this.checkValidity()) form.confirm.pattern = this.value;" required>
                            <input type="password" id="confirm" name="confirm" placeholder="Confirm Password" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}"title="Confirm Password" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Passwords do not match' : '');" required>

                        </div>
                            <input type="submit" name="" value="Register">
                        <div id="message">
                          <h6>Password must contain the following:</h6>
                            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                        </div>
                        <div id="confirmpassword">
                            <h5>Passwords do not match. Please reconfirm password.</h5>
                        </div>

                    </form>


                </div>
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
        // click on button submit
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
            // send ajax
            $.ajax({
                url: '/ContactDeluxe/Endpoints/login.php', // url where to submit the request
                type : "POST", // type of action POST || GET
                dataType : 'json', // data type
				 data: JSON.stringify($('#login').serializeObject()),
				contentType: 'application/json;charset=UTF-8',

                success : function(result) {
                    // you can see the result from the console
                    // tab of the developer tools
                    console.log(result);
					window.location.href = "user.php";
                },
                error: function(xhr, resp, text) {
                    console.log(xhr, resp, text);
					alert("error");
                }
            })
        });
    });
						</script>
    </body>
    </head>
</html>
