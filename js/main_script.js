$(document).ready(function(){

	function get_page_html(page){
		var tmp = '<li'+(page==10?' class="active"':'')+'><a href="javascript:void(0)">10</a></li>';
		tmp += '<li'+(page==20?' class="active"':'')+'><a href="javascript:void(0)">20</a></li>';
		tmp += '<li'+(page==40?' class="active"':'')+'><a href="javascript:void(0)">40</a></li>';
		tmp += '<li'+(page==70?' class="active"':'')+'><a href="javascript:void(0)">70</a></li>';
		tmp += '<li'+(page==100?' class="active"':'')+'><a href="javascript:void(0)">100</a></li>';
		return tmp;
	}
	
	function get_nav_html(page, max_page){
		var tmp = "";
		tmp += '<li'+(page==1?' class="disabled"':'')+'><a href="#">&lt;&lt;</a></li>';
		tmp += '<li'+(page==1?' class="disabled"':'')+'><a href="#">&lt;</a></li>';
		if( page > 0 )
		{
			if( page < 4)
			{
				for( i = 1; i <= (max_page>4?"5":max_page); i++)
					tmp += '<li'+(page== i ?' class="active"':'')+'><a href="#">' + i + '</a></li>';
			}else if( page > max_page-3)
			{
				for( i = max_page-4; i <= max_page; i++)
					tmp += '<li'+(page==i?' class="active"':'')+'><a href="#">'+ i + '</a></li>';
			}else{
				for( i = page-2; i < (page*1) +3; i++)
					tmp += '<li'+(page== i ?' class="active"':'')+'><a href="#">' + i + '</a></li>';
			}
		}
		tmp += '<li'+(page==max_page || max_page == 0?' class="disabled"':'')+'><a href="#">&gt;</a></li>';
		tmp += '<li'+(page==max_page || max_page == 0?' class="disabled"':'')+'><a href="#">&gt;&gt;</a></li>';
		return tmp;
	}
	
	function load_data(e1, e2, e3)
	{
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "ajax/mob_data.php",
			data: 'limit='+e1+'&page='+ e2 +'&str='+e3,
			cache: false,
			success: function(data){
				max_page = data["max_page"];
				$("#page_nav").html(get_nav_html(c_page,max_page));
				$("#data_info").html(data["info"]);
				$(".bootstrap-tabler").html(data["msg"]);
				NProgress.done();
			}
		});
	}
		
	var limit_page = 10;
	var c_page = 1;
	var max_page = 0;
	var s_str = "";
	
	NProgress.start();
	
	$(".page-size").html(limit_page+" ");
	load_data(limit_page, c_page, s_str);
	
	
	$("#page_nav").on("click", "li", function(e){
		e.preventDefault();
		var n_page =  $(this).find("a").html();
		if( $(this).attr("class") == "disabled" || c_page == n_page) return;
		
		if( n_page == "&lt;&lt;" ) c_page = 1;
		else if( n_page == "&lt;" ) c_page = (c_page*1) - 1;
		else if( n_page == "&gt;&gt;" ) c_page = max_page;
		else if( n_page == "&gt;" ) c_page = (c_page*1) + 1;
		else c_page = n_page;
		
		NProgress.start();
		load_data(limit_page, c_page,s_str);

		$("#page_nav").html(get_nav_html(c_page, max_page));
	});
	
	$("#t_search").keyup(function(e){
		s_str = $(this).val();
		NProgress.start();
		load_data(limit_page, c_page, s_str);
	});
	
	$(".btn").click(function(){
		$(".dropdown-menu").html(get_page_html(limit_page));
		$(".dropdown-menu li").click(function(){
			limit_page = $(this).find("a").html();
			$(".page-size").html(limit_page+" ");
			$(".dropdown-menu").html(get_page_html(limit_page));
			
			NProgress.start();
			load_data(limit_page, c_page,s_str);
		});
	});
	
	NProgress.done();
});