<!doctype html>
<html lang='en'>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ro Mob db</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Optional theme >
<link rel="stylesheet" href="css/bootstrap-theme.min.css"-->

<link rel="stylesheet" type="text/css" href="css/nprogress.css">
<link rel="stylesheet" type="text/css" href="style.css">
<script src="js/jquery-latest.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/nprogress.js"></script>
<script src="js/common_script.js" type="text/javascript"></script>
<script src="js/monster_script.js" type="text/javascript"></script>
</head>
<body>
	<div class="container">
    	<div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<?php
 if( @$_GET['mob_id'] ) {
?>
<?php
 }else{ ?>
		
            

			<div class="panel panel-default">
			  <div class="panel-heading">
			  	<div class="nav-menu">
			  		<a class="btn btn-default" href="#" role="button"><span class="glyphicon glyphicon-home"></span></a>
			  		<a class="btn btn-default" href="#" role="button">Link1</a>
			  		<a class="btn btn-default" href="#" role="button">Link2</a>
			  		<a class="btn btn-default" href="#" role="button">Link3</a>
			  		<a class="btn btn-default" href="#" role="button">Link4</a>
			  		<a class="btn btn-default" href="#" role="button">Link5</a>

			  		<div class="pull-right">

						<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    10
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                          	<li><a href="#">10</a></li>
						    <li><a href="#">20</a></li>
						    <li><a href="#">40</a></li>
						    <li><a href="#">70</a></li>
                            <li><a href="#">100</a></li>
						  </ul>
						</div>

			  		</div>
			  		
			  	</div>
			  </div>
			  <div class="panel-body" style="padding:0px;">
			    
	  			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-8" style="padding:10px;">
					<h2>Monster Database</h2>
					<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    10
						    <span class="caret"></span>
						  </button> record per page
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						  </ul>
                          <div class="pull-right" id="box_search"><input type="text" id="t_search" class="form-control" placeholder="Search"></div>
					</div>
                    
                    <div class="panel panel-default" id="dv_main" style="margin-bottom:10px;"></div>
<nav>
					
                      <ul class="pagination pull-right" id="page_nav" style="margin-top:0px;">
                      <li><a href="#">&lt;&lt;</a></li>
                      <li><a href="#">&lt;</a></li>
                      <li><a href="#">1</a></li>
                      <li><a href="#">&gt;</a></li>
                      <li><a href="#">&gt;&gt;</a></li>
                      </ul><h6 id="data_info" style="padding-top:15px;">Show Reccord</h6>
                      
</nav>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

					<div class="panel panel-default"><table class="table table-bordered table-hover"><thead><tr>
		<th class="text-center">Pic</th><th class="text-center">Name (Level)</th></tr></thead>
		<tbody><tr><td colspan="2" class="text-center">Not Found</td></tr></tbody></table></div>

				</div>

			  </div>

			</div>

		</div>
            

<?php } ?>
		</div>
 	</div>
</body>
</html>