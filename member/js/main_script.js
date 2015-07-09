$(document).ready(function(){

	NProgress.start();

	
	$("#btn_regis").click(function(){
		$("#dv_msg").html("test");
	});
	
	$("#btn_submit").click(function(e){
		e.preventDefault();
		NProgress.start();
		var s_data = { "user": $("#t_user").val(), "pass": $("#t_pass").val(), "rememberMe": $("#rememberMe").prop('checked') };
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "ajax/do_login.php",
			data: s_data,
			cache: false,
			success: function(data){
				$("#dv_msg").html(data[1]);
				NProgress.done();
				if (data[0] == 1) setTimeout(function(){ window.location = "main.php"; }, 2000);
				$("#t_user").val("");
				$("#t_pass").val("")
			}
		});
		
	});
	
	
	NProgress.done();
});