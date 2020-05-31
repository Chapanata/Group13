$(document).ready(function() {

    var modal = document.getElementById("add-contacts");

    $("#search").show();
    $(".seperator").hide();
    $("#add-contacts").hide();
    $("#my-account").hide();
    $("#mailbox").hide();
    $("#newpass").hide();
    $("#contacts-table").hide();

    // Search Button
    $("#search-btn").click(function(){
        $("#contacts-table").show();
    });

    //Show add contact form button
    $(".show-add-btn").click(function(){
        $("#contacts-table").show();
        showAdd();
    });

    //Contact Manager
    $("#contact-button").click(function(){
        $("#search").show("fast");
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
    });


    //Reset email / password


    $(".email").click(function(){
        $("#mailbox").show();
        $("#newpass").hide();
    });

    $(".password").click(function(){
        $("#newpass").show();
        $("#mailbox").hide();
    });
});

function resetForm(){
    $('#first').val('');
    $('#last').val('');
    $('#phone').val('');
    $('#address').val('');
    $('#email').val('');
    $("#add-contacts").hide();
}

function addRow(firstname, lastname, phone, address, email)
{
    var row = '<tr><td>' + firstname + '</td><td>' + lastname + '</td><td>'+ phone + '</td><td>' + address + '</td><td>' + email + '</td><td><button type="button" onclick="showEdit(this.parentNode.parentNode)">Edit</button></td></tr>';

    $("table").find('tbody').append(row);
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

        addRow(first, last, phone, address, email);
        resetForm();
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

    $('#first').val(firstname);
    $('#last').val(lastname);
    $('#phone').val(phone);
    $('#address').val(address);
    $('#email').val(email);

    //Delete button
    $("#delete-contact-btn").unbind();
    $("#delete-contact-btn").click(function(){
        $( curRow ).remove();
        resetForm();
    });

    //Confirm edit button
    $("#confirm-contact-btn").unbind();
    $("#confirm-contact-btn").click(function(){

        var first = $('#first').val();
        var last = $('#last').val();
        var phone = $('#phone').val();
        var address = $('#address').val();
        var email = $('#email').val();

        curRow.cells[0].innerHTML = first;
        curRow.cells[1].innerHTML = last;
        curRow.cells[2].innerHTML = phone;
        curRow.cells[3].innerHTML = address;
        curRow.cells[4].innerHTML = email;

        resetForm();
    });
}
