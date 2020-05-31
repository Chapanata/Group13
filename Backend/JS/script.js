  $(document).ready(function() {
    $("#register").hide();  
      
    $("#register-butt").click(function(){
        $(".button-color").animate({left: 200}, 50); 
        $("#register").show();
        $("#login").hide();
		$("#rtnlogin").text("");
    });
      
    $("#login-butt").click(function(){
        $(".button-color").animate({left: 0}, 50); 
        $("#register").hide();
        $("#login").show();
		$("#rtnregister").text("");
    });  
      
});
