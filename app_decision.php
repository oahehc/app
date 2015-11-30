<html>
<head>
	<!--load jquery mobile-->
	<!--
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
	<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
	-->
	
	<!--
	<link rel="stylesheet" href="jquery.mobile-1.3.2.min.css">
	<script src="jquery-2.1.4.min.js"></script>
	<script src="jquery.mobile-1.3.2.min.js"></script>
	-->	
	<!--
	-->	
	<link rel="stylesheet" href="ext/jquery.mobile-1.4.5.css">
	<script src="ext/jquery-2.1.4.min.js"></script>
	<script src="ext/jquery.mobile-1.4.5.js"></script>
	
	<script type="text/javascript" src="ext/jquery.cookie.js"></script>
	
	<!--style by CSS-->
	<style>
	textarea{
		height:300px !important;
		font-size:1.5em !important;
	}
	input{
		font-size:1.5em !important;	
	}
	input.small{
		font-size:1em !important;			
	}
	a.unpadding{
		padding:0px 10px !important;	
	}
	a.myfavor{
		font-size:0.8em !important;	
		font-style:italic !important;
	}
	div.selection{
		width:90%;
		margin-right:auto;
		margin-left:auto;
		margin-top:5px;
		padding:5px;
		border:1px white solid;
		border-radius:5px;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
		div.w2{
			width:48%;
			float:left;
			margin-left:1%;
			margin-right:1%;
		}
		div.w3{
			width:31%;
			float:left;
			margin-left:1%;
			margin-right:1%;
		}
		div.w4{
			width:23%;
			float:left;
			margin-left:1%;
			margin-right:1%;
		}
		div.w5{
			width:18%;
			float:left;
			margin-left:1%;
			margin-right:1%;
		}
		div#selected{
			background-color:#FFFF55;
			color:black;
		}
		div#finish{
			background-color:#FF5555;
			color:black;
			font-weight:bold;
			text-shadow: 0 0 0 black;
		}
	
	div.function{
		float:left;
		width:25%;
		height:32px;
		line-height:32px;
		padding:0px;
		margin:0px;
		border:0px;
		font-size:0.8em;	
		font-style:italic;
		color:black !important;
			padding-left:32px;
			text-align:left;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;				
	}
	li.function{
		padding:0px !important;
	}
	a.fill{
		display:inline-block;
		width:100%;
		height:100%;
		text-decoration:none;
		color:black !important;
	}
	
	h1.msg{
		margin:0% 10% !important;
		white-space:normal !important;
	}
	div.hide{
		display:none !important;
	}	

/*custom delete icon*/	
	.ui-icon-customdelete:after{
		background-image:url(pic/custom_delete.jpg);
		background-image:url(pic/custom_delete.png);
		background-size: 34px 38px;/*total 40*44*/
		width: 34px;
		height: 38px;
		top: 0px;
		left: 0px;
		margin: 3px;
		border-radius: 2px;
	}
	a.delete_function{
		display:none !important;
	}
	
/*for resposive design*/
	@media (max-width: 600px){	
		div.function{	
		}			
	}		
	</style>

	<!--relatived setting for website-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="author" content="Oahehc">
	<!--picture for icon-->
	<link rel="shortcut icon" href="pic/decision.jpg">
	<link rel="apple-touch-icon" href="pic/decision.jpg">
	<!--full screen for mobile device-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">	
	<!--website title-->
	<title>Decision</title>	
</head>
<script language="JavaScript">
	$(function(){
		//start draw
		$("input#start_draw").click(function(){
			//set parameter
			var option = $(this).data('num');
			var tag = -1;
			
			//ramdom click time
			var total_click = Math.round(Math.random()*option) + option*5;
			
			//clear all selected
			$("div#selected").removeAttr("id");
			
			//start drawing
			drawing(tag,option,total_click);
		})
			function drawing(tag,option,total_click){
				if(total_click>0)
				{
				//remove old selected option
				var start_class = "div.option_" + (tag % option);
				$(start_class).removeAttr("id");
				//selected new option
				var new_class = "div.option_" + ((tag+1) % option);
				$(new_class).attr("id", "selected");
//alert(start_class + "\n" + new_class + "\n" + tag + "\n" + total_click + "\n");	

				//decrease delay time
				if(total_click == 1)
				{var delay_time = 10;}
				else
				{var delay_time = 1000/total_click;}
				
				tag++;
				total_click--;
				setTimeout(function(){drawing(tag,option,total_click);},delay_time);
				}
				else
				{
				//highlight final option
				var start_class = "div.option_" + (tag % option);
				$(start_class).removeAttr("id");
				$(start_class).attr("id", "finish");
				}
			}

		//close dialog msg
		$("input.close").click(function(){	
			$(".ui-dialog").dialog("close");
		})	
		//close dialog msg and remove parameter
		$("input.cancel").click(function(){	
			document.decision.reset();
			document.decision.title_code.value = "";		
			document.decision.selection_content.value = "";		
			document.decision.action.value = "";		
			$(".ui-dialog").dialog("close");
		})
		
		//
		
	});
	
	function alert_dialog(msg){
		//show dialog
		$("#open_dialog").click();
		
		//show button for confirm
		$("div#confirm_button").addClass('hide');
		$("div#alert_button").removeClass();
		
		//set message to dialog
		$("h1.msg").empty();	
		$("h1.msg").append(msg);
	}
	function confirm_dialog(msg){
		//show dialog
		$("#open_dialog").click();
		
		//show button for confirm
		$("div#alert_button").addClass('hide');
		$("div#confirm_button").removeClass();
	
		//set message to dialog
		$("h1.msg").empty();	
		$("h1.msg").append(msg);
	}	
</script>
<body>
<?php
//close error report
error_reporting(0);

//load constant
include ("ext/constant.php");

//open session
session_start();

//set time zone
date_default_timezone_set("Asia/Taipei");

//link to MYSQL
/*
$link = mysql_connect(mysql_host,mysql_user,mysql_pw);
mysql_query("SET NAMES 'utf8'");
mysql_select_db(mysql_db,$link);
*/
$link = mysql_connect("localhost","root","williams");
mysql_query("SET NAMES 'utf8'");
mysql_select_db("oahehc",$link);
set_time_limit(300); //update limit time for server


//default parameter
$num_last_record = 5;
$max_width_list = 5;


//received cookie and transfer to array
	if(!empty($_COOKIE["cookie_title"]))
	{$array_title = json_decode(base64_decode($_COOKIE["cookie_title"]), true);}
	else
	{$array_title = array();}
	//transfer to string
	foreach($array_title as $index => $content)
	{$string_title .= "'".$index."',";}
	$string_title = "(".$string_title."'')";
	//re-setting cookie to expand lifetime
	$cookie_json = base64_encode(json_encode($array_title));
	setcookie("cookie_title", $cookie_json, time()+3600*24*30);	
?>


<form name="decision" method="post" data-ajax="false" id="decision_form">
	<input type="hidden" name="action">
	<input type="hidden" name="title_code">
	<input type="hidden" name="selection_title">
	<input type="hidden" name="selection_content">
	<input type="hidden" name="reserve">
	<input type="hidden" name="draw_code" value="<?php echo $_POST["draw_code"]; ?>">
	<a href="#dialog_msg" id="open_dialog" style="display:none;"></a><!--hyperlink for open dialog msg-->
<?php
//clear open list to prevent unable to close (at second reload page)
	if(!empty($_SESSION["session_openlist_set"]))
	{
	$_SESSION["session_openlist"] = "";
	$_SESSION["session_openlist_set"] = "";
	}
	if(!empty($_SESSION["session_openlist"]))
	{$_SESSION["session_openlist_set"] = "y";}

//create selection
	if($_POST["action"] == "create")
	{
	//received input
		$title = $_POST["title"];
		$array_selection = array_filter((explode("\n",$_POST["selection"])));
		$create_date = time();
		
	//ceate code for each group
		$select_code = "select code from decision order by code desc limit 1";
		$result_select_code = mysql_query($select_code);
		$data_select_code = mysql_fetch_row($result_select_code);
		$code = $data_select_code[0] + 1;

	//insert to mysql
		foreach($array_selection as $index => $content)
		{
		//remove change line character
		$content = preg_replace('/\v/', '', $content);
		
			if(!empty($content))
			{
			$insert_selection = "insert into decision(`code`,`title`,`selection_content`,`create_date`)
								 Values('$code','$title','$content','$create_date')";
			$result_insert_selection = mysql_query($insert_selection);
			}
		}
	
	//add title to cookie
	$cookie = $array_title + array($code => $title);
	$cookie_json = base64_encode(json_encode($cookie));
	setcookie("cookie_title", $cookie_json, time()+3600*24*30);

	//clear input
	$_POST["title"] = "";
	$_POST["selection"] = "";

	//change to DRAM page
	header("Location:decision.php#DRAW");
	$_SESSION["session_TitleCode"] = $code;
	}
//delect selection
	elseif($_POST["action"] == "delete_selection")
	{
	$title_code = $_POST["title_code"];
	$selection_content = $_POST["selection_content"];

	$delete_selection = "delete from decision where code='$title_code' and selection_content='$selection_content' limit 1";
	mysql_query($delete_selection);
	
	//array to default open edit list
	$_SESSION["session_openlist"] = $title_code;
	
	header("location:decision.php#LIST");
	}
//add_selection
	elseif($_POST["action"] == "add_selection")
	{
	$title_code = $_POST["title_code"];
	$selection_title = $_POST["selection_title"];
	$selection_content = $_POST["selection_content"];
	$reserve = $_POST["reserve"];
	$create_date = time();

	$insert_new_selection = "insert into decision(`code`,`title`,`selection_content`,`create_date`,`reserve`)
							 Values('$title_code','$selection_title','$selection_content','$create_date','$reserve')";
	$result_insert_new_selection = mysql_query($insert_new_selection);
	
	//array to default open edit list
	$_SESSION["session_openlist"] = $title_code;
	header("location:decision.php#LIST");
	}
//add to myfavor
	elseif($_POST["action"] == "add_myfavor")
	{	
	$title_code = $_POST["title_code"];
	
	$update_myfavor = "update decision set reserve='Y' where code='$title_code'";
	mysql_query($update_myfavor);
	
	header("location:decision.php#LIST");
	}
//remove from myfavor
	elseif($_POST["action"] == "remove_myfavor")
	{	
	$title_code = $_POST["title_code"];
	
	$update_myfavor = "update decision set reserve='N' where code='$title_code'";
	mysql_query($update_myfavor);
	
	header("location:decision.php#LIST");
	}
//delete_group
	elseif($_POST["action"] == "delete_group")
	{	
	$title_code = $_POST["title_code"];
	
	$delete_group = "delete from decision where code='$title_code'";
	mysql_query($delete_group);	
	
	header("location:decision.php#LIST");	
	}
//rename title
	elseif($_POST["action"] == "rename_title")
	{
	$title_code = $_POST["title_code"];
	$new_title = $_POST["selection_title"];
	
	$update_title = "update decision set title='$new_title' where code='$title_code'";
	mysql_query($update_title);
	
	header("location:decision.php#LIST");
	}
//purge_data
	elseif($_POST["action"] == "purge_data")
	{
	$delete_all = "delete from decision where code in $string_title";
	mysql_query($delete_all);
	
	//clear cookie
	setcookie("cookie_title", "", 1);
	
	header("location:decision.php#LIST");
	}
//start_draw
	elseif($_POST["action"] == "start_draw")
	{	
	header("location:decision.php#DRAW");
	}
?>


<!--Create-->
<div data-role="page" id="CREATE" data-theme="b">
	<div data-role="header" data-position="fixed">
		<h1>Create Your Selection</h1>
		<div data-role="navbar" data-iconpos="left">
			<ul>
				<li><a href="#CREATE" data-icon="plus" class="ui-btn-active ui-state-persist">CREATE</a></li>
				<li><a href="#LIST" data-icon="bars">LIST</a></li>
				<li><a href="#DRAW" data-icon="grid">DRAW</a></li>
				<li><a href="#SET" data-icon="gear">SET</a></li>
			</ul>
		</div>
	</div>
	<div data-role="content">
<?php
//print_r($array_title);
//echo $string_title;
?>
		<input id="input_title" type="text" name="title" placeholder="Title" maxlength=20 value="<?php echo $_POST["title"]; ?>" autofocus>
		<textarea name="selection" placeholder="Selection 1&#10;Selection 2&#10;Selection 3&#10;..."><?php echo $_POST["selection"]; ?></textarea>
		<div data-role="controlgroup" data-type="horizontal">
			<input type="button" value="Create" onclick="create_selection()">
			<input type="button" value="Reset" onclick="form_reset()">
		</div>
	</div>
	<div data-role="footer" data-position="fixed">
		<h1>Oahehc@2015</h1>
	</div>
</div>


<!--LIST-->
<div data-role="page" id="LIST" data-theme="b">
	<div data-role="header" data-position="fixed">
		<h1>Select a Group to Draw</h1>
		<div data-role="navbar" data-iconpos="left">
			<ul>
				<li><a href="#CREATE" data-icon="plus">CREATE</a></li>
				<li><a href="#LIST" data-icon="bars" class="ui-btn-active ui-state-persist">LIST</a></li>
				<li><a href="#DRAW" data-icon="grid">DRAW</a></li>
				<li><a href="#SET" data-icon="gear">SET</a></li>
			</ul>
		</div>
	</div>
	
	<div data-role="content">
		<?php
//echo $delete_selection;
//print_r($array_edit);	
//echo $_SESSION["session_openlist"];
		//select and show last x records
		echo "<h2>Recent</h2>";
		$select_last_title = "select distinct code,title from decision where reserve!='Y' and code in $string_title group by code order by create_date desc";
		$result_last_title = mysql_query($select_last_title);
		$num_last_title = mysql_num_rows($result_last_title);
		
			for($i=0;$i<$num_last_title;$i++)
			{
			$data_last_title = mysql_fetch_row($result_last_title);
			
			$select_selections = "select selection_content from decision where code='".$data_last_title[0]."' order by selection_content";
			$result_selections = mysql_query($select_selections);
			$num_selections = mysql_num_rows($result_selections);	

			//load default open for editing list
			if($_SESSION["session_openlist"] == $data_last_title[0])
			{$collapsed_setting = "false";}
			else
			{$collapsed_setting = "true";}
			
			echo "<div data-role='collapsible' data-collapsed='$collapsed_setting'>";
			echo "<h4>".$data_last_title[1]."<span class='ui-li-count'>".$num_selections."</span></h4>";
				echo "<ul data-role='listview'>";
				//function line
				echo "<li data-icon='grid' data-theme='a' class='function'>";
					echo "<div class='function ui-btn ui-icon-grid ui-btn-icon-left' onclick=\"start_draw('".$data_last_title[0]."')\">Draw</div>";
					echo "<div class='function ui-btn ui-icon-star ui-btn-icon-left' onclick=\"add_myfavor('".$data_last_title[0]."')\">Favor</div>";
					echo "<div class='function ui-btn ui-icon-edit ui-btn-icon-left'><a href='#dialog_".$data_last_title[0]."' data-rel='dialog' class='fill'>Edit</a></div>";
					echo "<div class='function ui-btn ui-icon-delete ui-btn-icon-left' onclick=\"delete_group('".$data_last_title[0]."','".$data_last_title[1]."')\">Delete</div>";			
				echo "</li>";
				
				for($j=0;$j<$num_selections;$j++)
				{
				$data_selections = mysql_fetch_row($result_selections);
				echo "<li data-icon='delete'>";
					echo "<a href='#'>";
					echo $data_selections[0];
					echo "</a>";
					echo "<a href='#' onclick=\"delete_selection('".$data_last_title[0]."','".$data_selections[0]."')\"></a>";
//echo "<a href='#' class='delete_function delete_".$data_last_title[0]."' onclick=\"delete_selection('".$data_last_title[0]."','".$data_selections[0]."')\"></a>";
//echo "<a href='#' id='delete_".$data_last_title[0]."'></a>";
				echo "</li>";
				}
				
				//list for new selection create
				echo "<li data-icon='plus'>";
					echo "<a class='unpadding' href='#'>";
					echo "<input class='small new_selection_$data_last_title[0]'>";
					echo "</a>";	
					echo "<a href='#' onclick=\"add_selection('".$data_last_title[0]."','".$data_last_title[1]."','N')\">";	
					echo "</a>";						
				echo "</li>";						
				
				echo "</ul>";
			echo "</div>";
			}
			
		//select and show reserve records		
		echo "<h2>★ My Favor</h2>";
		$select_favor_title = "select distinct code,title from decision where reserve='Y' and code in $string_title group by code order by create_date desc";
		$result_favor_title = mysql_query($select_favor_title);
		$num_favor_title = mysql_num_rows($result_favor_title);
		
			for($i=0;$i<$num_favor_title;$i++)
			{
			$data_favor_title = mysql_fetch_row($result_favor_title);
			
			$select_selections = "select selection_content from decision where code='".$data_favor_title[0]."' order by selection_content";
			$result_selections = mysql_query($select_selections);
			$num_selections = mysql_num_rows($result_selections);			
			
			//load default open for editing list
			if($_SESSION["session_openlist"] == $data_favor_title[0])			
			{$collapsed_setting = "false";}
			else
			{$collapsed_setting = "true";}
			
			echo "<div data-role='collapsible' data-collapsed='$collapsed_setting'>";
			echo "<h4>".$data_favor_title[1]."<span class='ui-li-count'>".$num_selections."</span></h4>";
				echo "<ul data-role='listview'>";
				//function line
				echo "<li data-icon='grid' data-theme='a' class='function'>";
					echo "<div class='function ui-btn ui-icon-grid ui-btn-icon-left' onclick=\"start_draw('".$data_favor_title[0]."')\">Draw</div>";
					echo "<div class='function ui-btn ui-icon-star ui-btn-icon-left' onclick=\"remove_myfavor('".$data_favor_title[0]."')\">Favor</div>";
					echo "<div class='function ui-btn ui-icon-edit ui-btn-icon-left'><a href='#dialog_".$data_favor_title[0]."' data-rel='dialog' class='fill'>Edit</a></div>";
					echo "<div class='function ui-btn ui-icon-delete ui-btn-icon-left' onclick=\"delete_group('".$data_favor_title[0]."')\">Delete</div>";			
				echo "</li>";
				
				for($j=0;$j<$num_selections;$j++)
				{
				$data_selections = mysql_fetch_row($result_selections);
				echo "<li data-icon='delete'>";
					echo "<a href='#'>";
					echo $data_selections[0];
					echo "</a>";
					echo "<a href='#' onclick=\"delete_selection('".$data_favor_title[0]."','".$data_selections[0]."')\">";
					echo "</a>";
				echo "</li>";
				}
				
				//list for new selection create
				echo "<li data-icon='plus'>";
					echo "<a class='unpadding' href='#'>";
					echo "<input class='small new_selection_$data_favor_title[0]'>";
					echo "</a>";	
					echo "<a href='#' onclick=\"add_selection('".$data_favor_title[0]."','".$data_favor_title[1]."','Y')\">";	
					echo "</a>";			
				echo "</li>";	
				
				echo "</ul>";
			echo "</div>";
			}
		?>	
	</div>
	
	<div data-role="footer" data-position="fixed">
		<h1>Oahehc@2015</h1>
	</div>
</div>
	<!--dialog for title rename-->
	<?php
	$select_all_title = "select distinct code,title from decision group by code order by create_date desc";
	$result_all_title = mysql_query($select_all_title);
	$num_all_title = mysql_num_rows($result_all_title);	
	
	for($i=0;$i<$num_all_title;$i++)
	{
	$data_all_title = mysql_fetch_row($result_all_title);
	
	echo "<div data-role='dialog' id='dialog_".$data_all_title[0]."' data-theme='b' data-close-btn='right'>";
		echo "<div data-role='header' data-position='fixed'>";
			echo "<h1>Input New Title</h1>";
		echo "</div>";
		echo "<div data-role='content'>";
			echo "<input type='text' class='new_title_".$data_all_title[0]."' value='".$data_all_title[1]."' autofocus>";
			echo "<input type='button' value='Change Name' onclick=\"rename_title('".$data_all_title[0]."')\">";
		echo "</div>";
	echo "</div>";
	}
	?>


<!--Draw-->
<div data-role="page" id="DRAW" data-theme="b">
	<div data-role="header" data-position="fixed">
		<h1>Click to Draw</h1>
		<div data-role="navbar" data-iconpos="left">
			<ul>
				<li><a href="#CREATE" data-icon="plus">CREATE</a></li>
				<li><a href="#LIST" data-icon="bars">LIST</a></li>
				<li><a href="#DRAW" data-icon="grid" class="ui-btn-active ui-state-persist">DRAW</a></li>
				<li><a href="#SET" data-icon="gear">SET</a></li>
			</ul>
		</div>
	</div>
	
	<div data-role="content">
	<?php
	//receive selected group
	if(!empty($_POST["draw_code"]))
	{$draw_code = $_POST["draw_code"];}
	elseif(!empty($_SESSION["session_TitleCode"]))
	{$draw_code = $_SESSION["session_TitleCode"];}
	
	
	//list for selections
	$select_draw_selections = "select title,selection_content from decision where code='$draw_code' order by selection_content";
	$result_draw_selections = mysql_query($select_draw_selections);
	$num_draw_selections = mysql_num_rows($result_draw_selections);
	
		//draw button + option number
		echo "<input type='button' value='Start' id='start_draw' data-num='$num_draw_selections'>";
		
		//adjust width base on option number
		$width = "w".min(ceil($num_draw_selections/10),$max_width_list);		
			
		for($i=0;$i<$num_draw_selections;$i++)
		{		
		$data_draw_selections = mysql_fetch_row($result_draw_selections);
		echo "<div class='selection $width option_$i'>$data_draw_selections[1]</div>";
		}
	?>
	</div>
	
	<div data-role="footer" data-position="fixed">
		<h1>Oahehc@2015</h1>
	</div>
</div>


<!--SET-->
<div data-role="page" id="SET" data-theme="b">
	<div data-role="header" data-position="fixed">
		<h1>Setting</h1>
		<div data-role="navbar" data-iconpos="left">
			<ul>
				<li><a href="#CREATE" data-icon="plus">CREATE</a></li>
				<li><a href="#LIST" data-icon="bars">LIST</a></li>
				<li><a href="#DRAW" data-icon="grid">DRAW</a></li>
				<li><a href="#SET" data-icon="gear" class="ui-btn-active ui-state-persist">SET</a></li>
			</ul>
		</div>
	</div>
	
	<div data-role="content">
		<input type="button" value="Purge Data" onclick="purge_data()">
	</div>

	<div data-role="footer" data-position="fixed">
		<h1>Oahehc@2015</h1>
	</div>
</div>


<!--dialog for alert and confirm msg-->
<div data-role="dialog" id="dialog_msg" data-theme="b" data-close-btn="right">
	<div data-role="header" data-position="fixed">
		<h1 class="msg"></h1>
	</div>
	<div data-role="content">
		<div data-role="navbar" class="hide" id="confirm_button">
			<ul>
				<li><input type="submit" value="Yes" id="confirm"></li>
				<li><input type="button" value="No" class="cancel"></li>
			</ul>
		</div>
		<div data-role="navbar" class="hide" id="alert_button">
			<ul class="hide" id="alert_button">
				<li><input type="button" value="Yes" class="close"></li>
			</ul>
		</div>
	</div>
</div>


</form>
</body>
</html>
<script>
/*create page*/
	function form_reset(){
		location.href=('decision.php');		
	}
	function create_selection(){
		var title = document.decision.title.value;
		var selection = document.decision.selection.value;
		var title_check = string_check(title);
		var selection_check = string_check(selection);
		if(title == "")
		{
		document.decision.title.focus();
		alert_dialog("[ERROR]\nPlease input a title");
		}
		else if(title_check != "")
		{
		document.decision.title.select();
		alert_dialog("[ERROR]\nPlease don\'t use " + title_check + " for title");
		}
		else if(selection == "")
		{
		document.decision.selection.focus();
		alert_dialog("[ERROR]\nPlease input selection");
		}
		else if(selection_check != "")
		{
		document.decision.selection.select();
		alert_dialog("[ERROR]\nPlease don\'t use " + selection_check + " for selection");
		}
		else
		{
		document.decision.action.value = "create";
		document.decision.submit();	
		}
	}
		/*special character check*/
		function string_check(x){
			var array_result = new Array;
			var check = new String;
			var result = new String;
			for(var i=0;i<x.length;i++)
			{
				check = x[i].match('[0-9|A-Za-z|!@$()_|\n-]');
				if(check === null)
				{
					if((jQuery.inArray(x[i], array_result)) == -1)//remove repeated character
					{array_result.push(x[i]);}
				}
			}
			var result = array_result.join(" ");
			return result;
		}	

/*list page*/
	function delete_selection(x,y){
		document.decision.title_code.value = x;		
		document.decision.selection_content.value = y;		
		document.decision.action.value = "delete_selection";
		confirm_dialog("[NOTICE]\nConfirm to remove this selection : " + y);
	}
	function add_selection(x,y,Z){
		var input_class = "input.new_selection_" + x;
		var new_selection = $(input_class).val();
		if(new_selection == "")
		{alert_dialog("[ERROR]\nPlease input new selection");}
		else
		{
		document.decision.title_code.value = x;		
		document.decision.selection_title.value = y;		
		document.decision.reserve.value = Z;		
		document.decision.selection_content.value = new_selection;		
		document.decision.action.value = "add_selection";
		document.decision.submit();
		}				
	}
		
	/*function line at list page*/
	function add_myfavor(x){
		document.decision.title_code.value = x;					
		document.decision.action.value = "add_myfavor";
		document.decision.submit();
	}
	function remove_myfavor(x){
		document.decision.title_code.value = x;					
		document.decision.action.value = "remove_myfavor";
		confirm_dialog("[NOTICE]\nConfirm to remove this group from myfavor");
	}
	function start_draw(x){
		document.decision.draw_code.value = x;	
		document.decision.action.value = "start_draw";	
		document.decision.submit();	
	}
	function delete_group(x,y){
		document.decision.title_code.value = x;		
		document.decision.action.value = "delete_group";
		confirm_dialog("[NOTICE]\nConfirm to delete group : " + y);
	}
	function rename_title(x){
		var title_class = "input.new_title_" + x;
		var new_title = $(title_class).val();
		if(new_title == "")
		{alert_dialog("[ERROR]\nPlease input new title");}
		else
		{
		document.decision.selection_title.value = new_title;
		document.decision.title_code.value = x;
		document.decision.action.value = "rename_title";
		document.decision.submit();
		}	
	}
	
/*Set page*/
	function purge_data(){
		document.decision.action.value = "purge_data";
		confirm_dialog("[NOTICE]\nConfirm to delete all your data\n(including myfavor data)");		
	}

</script>