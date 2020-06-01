$(document).ready(function() {

    var modal = document.getElementById("add-contacts");
	$.fn.serializeObject = function() {
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
    $("#search").show();
    $(".seperator").hide();
    $("#add-contacts").hide();
    $("#my-account").hide();
    $("#namebox").hide();
    $("#newpass").hide();
	$("#nocontacts").hide();
    $("#contacts-table").hide();
	$("#contact-button").css("color","#8cc1ff");
	$("#account-button").css("color","black");
	var totalcontacts = 0;
    // Search Button
    $("#search-btn").click(function(){
       	$.ajax({
		url: '/ContactDeluxe/Endpoints/searchContacts.php',
		type : "POST",
		dataType : 'json', // data type
		data: JSON.stringify($('#search').serializeObject()),
		contentType: 'application/json;charset=UTF-8',
		success : function(result) {
			//console.log(result);

			//contact_identity = result.ReturnedID;
		//	addRow(contact_identity,first, last, phone, address, email);

			//resetForm();
			$("table").find('tr:gt(0)').remove();
			var i = 0
			for (i = 0; i < result.length; i++)
			{

				addRow(result[i].ContactID,result[i].FirstName, result[i].LastName, result[i].PhoneNumber, result[i].Address, result[i].Email);
				totalcontacts++;
			}
			if (i > 0)
			{
				$("#nocontacts").hide();
				$("#contacts-table").show();

			}
			else
			{
				$("#nocontacts").show();
				$("#contacts-table").hide();
			}


		},
		error: function(xhr, resp, text) {

		}
	});

    });

    //Show add contact form button
    $(".show-add-btn").click(function(){

        showAdd();
    });

    //Contact Manager
    $("#contact-button").click(function(){
        $("#search").show("fast");
		$("#contact-button").css("color","#8cc1ff");
		$("#account-button").css("color","black");
        $("#add-contacts").hide();
        $("#my-account").hide();
        $("#mailbox").hide();
        $("#newpass").hide();
    });

    // My Account
    $("#account-button").click(function(){
        $("#my-account").show("fast");
        $("#search").hide();
        $(".seperator").hide();
        $("#add-contacts").hide();
		$("#contact-button").css("color","black");
		$("#account-button").css("color","#8cc1ff");
    });


    //Reset email / password

    $(".name").click(function(){
        $("#namebox").show();
        $("#newpass").hide();
    });

    $(".password").click(function(){
        $("#newpass").show();
        $("#mailbox").hide();
    });
	$(".export").click(function(){

		  window.location.href = "/ContactDeluxe/Endpoints/exportContacts.php";
	});

	$.ajax({
		url: '/ContactDeluxe/Endpoints/searchContacts.php',
		type : "POST",
		dataType : 'json', // data type
		data: JSON.stringify($('#search').serializeObject()),
		contentType: 'application/json;charset=UTF-8',
		success : function(result) {
			//console.log(result);

			//contact_identity = result.ReturnedID;
		//	addRow(contact_identity,first, last, phone, address, email);

			//resetForm();
			var i = 0
			for (i = 0; i < result.length; i++)
			{

				addRow(result[i].ContactID,result[i].FirstName, result[i].LastName, result[i].PhoneNumber, result[i].Address, result[i].Email);
			}
			console.log(result.length);
			if (result.length > 0)
			{
				$("#nocontacts").hide();
				$("#contacts-table").show();
			}
			else
			{
				$("#nocontacts").show();

			}


		},
		error: function(xhr, resp, text) {

		}
	});

	$("#change_name_btn").click(function(){
		$.ajax({
			url: '/ContactDeluxe/Endpoints/editUser.php',
			type : "POST",
			dataType : 'json', // data type
			data: JSON.stringify($('#my-account').serializeObject()),
			contentType: 'application/json;charset=UTF-8',
			success : function(result) {
			console.log(result);


			},
			error: function(xhr, resp, text) {
				console.log(xhr ,resp, text);
			}
		});
	});
	$("#change_pass_btn").click(function(){
		$.ajax({
			url: '/ContactDeluxe/Endpoints/editUser.php',
			type : "POST",
			dataType : 'json', // data type
			data: JSON.stringify($('#changepassword').serializeObject()),
			contentType: 'application/json;charset=UTF-8',
			success : function(result) {

				$("#rtnvalid").text("Password Changed Successfully.");
				 window.location.href = "user.php";
			},
			error: function(xhr, resp, text) {
			 var obj = JSON.parse(xhr.responseText);
			console.log(obj.Error);
			$("#rtnvalid").text(obj.Error);
			}
		});
	});

});
	function addRow(contactid,firstname, lastname, phone, address, email)
	{
		var row = '<tr data-contactid="'+contactid+'"><td>' + firstname + '</td><td>' + lastname + '</td><td>'+ phone + '</td><td>' + address + '</td><td>' + email + '</td><td><button type="button" onclick="showEdit(this.parentNode.parentNode)">Edit</button></td></tr>';

		$("table").find('tbody').append(row);
	}


	function resetForm(){
    $('#first').val('');
    $('#last').val('');
    $('#phone').val('');
    $('#address').val('');
    $('#email').val('');
    $("#add-contacts").hide();
}







//Shows the add new contact dialog
function showAdd()
{
    //Initialize modal
    $('#modal-header').text('Add New Contact');
    $("#delete-contact-btn").hide();
    $("#add-contacts").show();


    //Add contact button
    $("#confirm-contact-btn").unbind();
    $("#confirm-contact-btn").click(function(){

        var first = $('#first').val();
        var last = $('#last').val();
        var phone = $('#phone').val();
        var address = $('#address').val();
        var email = $('#email').val();
		var contact_identity = "";
		$.ajax({
			url: '/ContactDeluxe/Endpoints/createContact.php',
			type : "POST",
			dataType : 'json', // data type
			data: JSON.stringify($('#contactmodal').serializeObject()),
			contentType: 'application/json;charset=UTF-8',
			success : function(result) {
				//console.log(result);

				contact_identity = result.ReturnedID;
				addRow(contact_identity,first, last, phone, address, email);

				resetForm();
				 $("#contacts-table").show();
				$("#nocontacts").hide();
				totalcontacts++;
			},
			error: function(xhr, resp, text) {

			}
		});




    });
}

function showEdit(curRow)
{
    //Initialize modal
    $('#modal-header').text('Edit Contact');
    $("#delete-contact-btn").show();
    $("#add-contacts").show();

    //Get previous values
    var firstname = curRow.cells[0].innerHTML;
    var lastname = curRow.cells[1].innerHTML;
    var phone = curRow.cells[2].innerHTML;
    var address = curRow.cells[3].innerHTML;
    var email = curRow.cells[4].innerHTML;
	var contactid = curRow.getAttribute('data-contactid');

    $('#first').val(firstname);
    $('#last').val(lastname);
    $('#phone').val(phone);
    $('#address').val(address);
    $('#email').val(email);
	$('#contactid').val(contactid);
    //Delete button
    $("#delete-contact-btn").unbind();
    $("#delete-contact-btn").click(function(){
		$("#task").val("2"); // 0 = Add, 1 = Edit, 2 = Delete

			$.ajax({
			url: '/ContactDeluxe/Endpoints/editContact.php',
			type : "POST",
			dataType : 'json', // data type
			data: JSON.stringify($('#contactmodal').serializeObject()),
			contentType: 'application/json;charset=UTF-8',
			success : function(result) {
				//console.log(result);


			$( curRow ).remove();
        	resetForm();
				totalcontacts--;
				if (totalcontact == 0)
				{
					$("#contacts-table").hide();
					$("#nocontacts").show();
				}
			},
			error: function(xhr, resp, text) {

			}
		});



    });

    //Confirm edit button
    $("#confirm-contact-btn").unbind();
    $("#confirm-contact-btn").click(function(){

        var first = $('#first').val();
        var last = $('#last').val();
        var phone = $('#phone').val();
        var address = $('#address').val();
        var email = $('#email').val();
		$("#task").val("1"); // 0 = Add, 1 = Edit, 2 = Delete
		$.ajax({
			url: '/ContactDeluxe/Endpoints/editContact.php',
			type : "POST",
			dataType : 'json', // data type
			data: JSON.stringify($('#contactmodal').serializeObject()),
			contentType: 'application/json;charset=UTF-8',
			success : function(result) {
				//console.log(result);


				 	curRow.cells[0].innerHTML = first;
					curRow.cells[1].innerHTML = last;
					curRow.cells[2].innerHTML = phone;
					curRow.cells[3].innerHTML = address;
					curRow.cells[4].innerHTML = email;

					resetForm();

			},
			error: function(xhr, resp, text) {

			}
		});

    });
}
