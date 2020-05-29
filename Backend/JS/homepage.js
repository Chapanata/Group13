$(document).ready(function() {

     var modal = document.getElementById("add-contacts");

    $("#search").show();
    $(".seperator").hide();
    $("#add-contacts").hide();    
    $("#my-account").hide();
    $("#mailbox").hide();
    $("#newpass").hide();

    // Search Button
    $(".lookup").click(function(){

    });  
    
    //Show add contact form button
    $(".show-add-btn").click(function(){
        modal.style.display = "block";
        editRow();
    });

    $(".close").click(function(){

        $('#first').val('');
        $('#last').val('');
        $('#phone').val('');
        $('#address').val('');
        $('#email').val('');

         modal.style.display = "none";
    })

    $("#search-button").click(function(){
        $("#search").show("fast");
        $("#add-contacts").hide();
        $("#my-account").hide();
        $("#mailbox").hide();
        $("#newpass").hide();
    });

    // Add Contacts
    $("#add-button").click(function(){
        $("#add-contacts").show("fast");
        $("#search").hide();
        $(".seperator").hide();
        $("#my-account").hide();
        $("#mailbox").hide();
        $("#newpass").hide();
    });


    //Add contact button
    $("#add-contact-btn").click(function(){

        var first = $('#first').val();
        var last = $('#last').val();
        var phone = $('#phone').val();
        var address = $('#address').val();
        var email = $('#email').val();


        addRow(first, last, phone, address, email);

        $("#search").show("fast");
        $("#add-contacts").hide();
        $(".seperator").hide();
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
    });

    $(".email").click(function(){
        $("#mailbox").show();
        $("#newpass").hide();
    });

    $(".password").click(function(){
        $("#newpass").show();
        $("#mailbox").hide();
    });
});

function addRow(firstname, lastname, phone, address, email)
{
        var row = '<tr><td>' + firstname + '</td><td>' + lastname + '</td><td>'+ phone + '</td><td>' + address + '</td><td>' + email + '</td><td><button type="button" onclick="editRow()">Edit</button></td></tr>';

        $("table").find('tbody').append(row);
}

function editRow()
{
        var row = '<tr ><td>' + "firstname" + '</td><td>' + "lastname" + '</td><td>'+ "phone" + '</td><td>' + "address" + '</td><td>' + "email" + '</td><td><button onclick="editRow()">Edit</button></td></tr>';

        $("table").find('tbody').append(row);
}
