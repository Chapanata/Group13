  $(document).ready(function() {
    $("#search-box").hide();  
    $(".seperator").hide();
    $("#add-contacts").hide();    
    $("#my-account").hide();
    $("#mailbox").hide();
    $("#newpass").hide();

    // Search Button
    $(".lookup").click(function(){
        $(".seperator").show();
        $("#add-contacts").hide();
        $("#my-account").hide();
        $("#mailbox").hide();
        $("#newpass").hide();
    });  
    
    $("#search-button").click(function(){
        $("#search-box").show("fast");
        $("#add-contacts").hide();
        $("#my-account").hide();
        $("#mailbox").hide();
        $("#newpass").hide();
    });
      
    // Add Contacts
      $("#add-button").click(function(){
          $("#add-contacts").show("fast");
          $("#search-box").hide();  
          $(".seperator").hide();
          $("#my-account").hide();
          $("#mailbox").hide();
        $("#newpass").hide();
      });
      
    // My Account
      $("#account-button").click(function(){
          $("#my-account").show("fast");
          $("#search-box").hide();  
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