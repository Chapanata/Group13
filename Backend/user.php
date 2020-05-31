<?php
include 'session.php';

// Ensure that user is logged in
if (!isset($uid))
{
	echo '<script type="text/javascript">';
	echo 'window.location.href = "index.php"';
	echo '</script>';
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="JS/homepage.js"></script>
        <title>Contact Manager Deluxe&#8482 Main Page</title>
        <link rel="stylesheet" type="text/css" href="CSS/normalize.css">
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="CSS/main-style.css">
    </head>

    <body class="background">

        <div class="main-form">
            <p style="padding:10px;background:rgb(119, 119, 119);color:white;display:inline;">Welcome Back <?php echo $name; ?></p>
            <div class="menu-bar">
                    <button id="contact-button" type="button">Contact Manger</button>
                    <button id="account-button" type="button">My Account</button>
            </div>

            <div class="box">
                <!-- Search Form -->
                <form id="search">
                    <h1 class="header">Search for Contacts</h1>
                    <input type="text" placeholder="Search Contact..">
                    <button id="search-btn" type="button">Search User</button>
                    <button class="show-add-btn" type="button">Add Contact</button>

                    <br><br>
                    <div id="contacts-table">
                        <table>
                            <thead>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>E-Mail Address</th>
                                <th>Edit</th>
                            </thead>
                            <tbody class="scrollable"/>
							</tbody>
                        </table>
                    </div>
                </form>

                <!-- Add Contacts -->
                <div id="add-contacts" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="resetForm()">&times;</span>
                        <h1 id="modal-header">Add New Contact</h1>
                        <div class="contact-fields">
							<form id="contactmodal">
								<input id="first" type="text" name="FirstName" placeholder="First Name" required>
								<br>
								<input id="last" type="text" name="LastName" placeholder="Last Name" required>
								<br>
								<input id="phone" type="tel" name="PhoneNumber" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
									   placeholder="Phone Number" required>
								<br>
								<input id="address" type="text" name="Address" placeholder="Address" required>
								<br>
								<input id="email" type="email" name="Email" placeholder="E-Mail Address" required>
								<br>
								<input id="task" name="Task" type="hidden">
								<input id="contactid" name="ContactID" type="hidden">
								<button id="delete-contact-btn" type="button" >Delete</button>
								<button id="confirm-contact-btn" type="button" >Submit</button>
							</form>
                        </div>
                    </div>
                </div>

                <!-- My Account -->
                <form id="my-account">
                    <h1 class="header">My Account</h1>
                    <div class="change-fields">
                        <button type="button" class="email">Change E-Mail</button>
                        <button type="button" class="password">Change Password</button>
                        <button type="button" class="logout"><a href="logout.php">Log Out</a></button>
                    </div>

                    <div id="mailbox">
                        <h2>Change E-Mail Address</h2>
                        <input type="email" name="email" placeholder="Enter New E-Mail Address" required>
                        <br>
                        <input type="email" name="email" placeholder="Confirm E-Mail Address" required>
                        <br>
                        <button type="button" >Submit</button>
                    </div>

                    <div id="newpass">
                        <h2>Change Password</h2>
                        <input type="password" name="password" placeholder="Enter New Password" required>
                        <br>
                        <input type="password" name="password" placeholder="Confirm Password" required>
                        <br>
                        <button type="button" >Submit</button>
                    </div>
                </form>
                <!-- Log Out-->

            </div>

        </div>


    </body>
</html>
