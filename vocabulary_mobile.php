<?php 
//啟用暫存 for session
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery/jquery-1.4.min.js"></script>
<!--
<script type="text/javascript" src="ext/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="ext/jquery-ui.min.js"></script>
-->
	
<!--
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
-->
	<link rel="stylesheet" href="ext/jquery_mobile/jquery.mobile-1.4.5.css">
	<script src="ext/jquery-2.1.4.min.js"></script>
	<script src="ext/jquery_mobile/jquery.mobile-1.4.5.js"></script>
	
	<script type="text/javascript" src="ext/jquery.cookie.js"></script>
	
<style>
	.ui-checkbox label{
		margin-top:2px !important;
	}
	.ui-controlgroup-controls{
		margin-top:10px !important;	
	}
	
	span.hidden{
		display:none;
	}
	span.small{
		font-size:0.6em;
		font-style:italic;
	}
	
	a.same_line{
		margin:2px !important;
		float:left;
	}
	
	div.out{
		border:1px solid gray;
		border-radius:5px;
		height:32px;
		margin-bottom:1px;
	}
		div.left{
			float:left;
			width:25%;
			text-align:center;
			height:32px;
			line-height:32px;
		}
		div.right{
			float:left;
			width:75%;
			font-size:0.8em;
		}
			div.finish{
				background-color:white;
				border-radius:5px;
				color:black;
				text-shadow: 0 0 0 black;
			}
			div.add{
				background-color:#00CCFF;
				border-radius:5px;
				color:black;
				text-shadow: 0 0 0 black;
			}
			div.white{
				color:white;
			}
			div.center{
				text-align:center;
				font-size:0.8em;
			}
			div.topspace{
				margin-top:5px;
			}

	input.selected{
		background-color:blue !important;
	}

/*purge button style*/
	input.purge{
		background-color:red;
	}
</style>
	<meta name="keyword" content="">
	<meta name="description" content="">
	<meta name="author" content="Oahehc">	
	<!--網站標題/我的最愛圖片-->
	<link rel="shortcut icon" href="pic/vocabulary_mobile.jpg">
	<!--設為主畫面APP連結時的圖片-->
	<link rel="apple-touch-icon" href="pic/vocabulary_mobile.jpg">
	<!--視窗填滿手機畫面-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--加到主畫面時，使網址列與最下面的選單消失，變為全螢幕模式-->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">		
	<title>Vocabulary</title>
</head>
<script language="JavaScript">
		$(function(){
		//translate : show hidden span
			$("input#item_translate").click(function(){
				$("span.hidden").css("display","inline");	
			})			
	
		//checkbox for test_type setting write in cookie
		/* (checkbox refresh fail at online server / cookie might no work on mobile device)
			$("div.ui-checkbox").click(function(){
			$('input[type=checkbox]').checkboxradio('refresh');
alert("Vocabulary" + $('input#vocabulary_check').prop('checked'));
alert("Chinese" + $('input#chinese_check').prop('checked'));
alert("English" + $('input#english_check').prop('checked'));
				if($('input#vocabulary_check').prop('checked') == true)
				{$.cookie("vocabulary", "true");}
				else
				{$.cookie("vocabulary", "");}
				if($('input#chinese_check').prop('checked') == true)
				{$.cookie("chinese", "true");}
				else
				{$.cookie("chinese", "");}
				if($('input#english_check').prop('checked') == true)
				{$.cookie("english", "true");}
				else
				{$.cookie("english", "");}
			})
		//received test type and change span class			
			if($.cookie("vocabulary"))
			{
			$('input#vocabulary_check').prop('checked',true).checkboxradio('refresh');
			$("span#vocabulary").removeAttr("class");				
			}						
			if($.cookie("chinese"))
			{
			$('input#chinese_check').prop('checked',true).checkboxradio('refresh');
			$("span#chinese").removeAttr("class");				
			}						
			if($.cookie("english"))
			{
			$('input#english_check').prop('checked',true).checkboxradio('refresh');
			$("span#english").removeAttr("class");				
			}
		*/
		})
</script> 
<body>

<?php
//載入函式庫
include ("ext/constant.php");

//關閉error report
//error_reporting(E_ALL);
error_reporting(0);

//開啟session
session_start();

//連線至MYSQL
$table_name = "vocabulary_mobile";

$link = mysql_connect(mysql_host,mysql_user,mysql_pw);
mysql_query("SET NAMES 'utf8'");
mysql_select_db(mysql_db,$link);
/*
$link = mysql_connect("localhost","root","williams");
mysql_query("SET NAMES 'utf8'");
mysql_select_db("oahehc",$link);
*/

//設定時區
date_default_timezone_set("Asia/Taipei");

//Parameter
$achieve_range = 9;
$current_url = "vocabulary_mobile.php";
$default_min_item = 5; //minimum item number for achievemant width calculate
?>
<form name="vocabulary" method="POST">
<input type="hidden" name="action">

<!--Test-->
<div data-role="page" id="test" data-theme="b">
	<div data-role="header" data-position="fixed">
	<h1>Test</h1>
		<div data-role="navbar" data-iconpos="left">
			<ul>
			<li><a href="#test" data-icon="check" class="ui-btn-active ui-state-persist">Test</a></li>
			<li><a href="#new" data-icon="plus">New</a></li>
			<li><a href="#list" data-icon="bars">List</a></li>
			<li><a href="#achieve" data-icon="user">Achieve</a></li>
			</ul>
		</div>
	</div>
	
	<div data-role="content">
	<?php
	//finish item
	if(!empty($_POST["finish_item"]))
	{
	//received data
	$finish_item = $_POST["finish_item"];
	$now = time();
	
	//update finish_date
	$update_finish = "update $table_name set finish_date='$now' where item='$finish_item'";
	$result_update_finish = mysql_query($update_finish);	
	}
	
	//update category setting for test
		//default_setting
		if(empty($_SESSION["session_vocabulary"]) && empty($_SESSION["session_chinese"]) && empty($_SESSION["session_english"]))
		{
		$_SESSION["session_vocabulary"] = "checked";
		$_SESSION["session_vocabulary_result"] = "show";
		$_SESSION["session_chinese"] = "";
		$_SESSION["session_chinese_result"] = "hidden";
		$_SESSION["session_english"] = "";
		$_SESSION["session_english_result"] = "hidden";	
		}
	
	if($_POST["action"] == "test_category_change")
	{	
	$array_test = array(0=>"");
	$array_test = @array_merge($array_test,$_POST["test_type"]);
	
		if(@array_search("vocabulary", $array_test))
		{
		$_SESSION["session_vocabulary"] = "checked";
		$_SESSION["session_vocabulary_result"] = "show";
		}
		else
		{
		$_SESSION["session_vocabulary"] = "";
		$_SESSION["session_vocabulary_result"] = "hidden";
		}
		
		if(@array_search("chinese", $array_test))
		{
		$_SESSION["session_chinese"] = "checked";
		$_SESSION["session_chinese_result"] = "show";
		}
		else
		{
		$_SESSION["session_chinese"] = "";
		$_SESSION["session_chinese_result"] = "hidden";
		}
		
		if(@array_search("english", $array_test))
		{
		$_SESSION["session_english"] = "checked";
		$_SESSION["session_english_result"] = "show";
		}
		else
		{
		$_SESSION["session_english"] = "";
		$_SESSION["session_english_result"] = "hidden";
		}
	//print_r($array_test);
	}
	
	//set select range
	if($_POST["range"] == "all")
	{
	$_SESSION["session_check_all"] = "checked";
	$_SESSION["session_check_unfinish"] = "";
	$_SESSION["session_where"] = "";
	}
	elseif($_POST["range"] == "unfinish")
	{
	$_SESSION["session_check_all"] = "";
	$_SESSION["session_check_unfinish"] = "checked";
	$_SESSION["session_where"] = "where (finish_date is NULL or finish_date=0)";		
	}
		//default setting
		if(empty($_SESSION["session_check_all"]) && empty($_SESSION["session_check_unfinish"]))
		{
		$_SESSION["session_check_all"] = "";
		$_SESSION["session_check_unfinish"] = "checked";
		$_SESSION["session_where"] = "where (finish_date is NULL or finish_date=0)";			
		}


	//check unfinish item number
	$select_unfinish = "select vocabulary,chinese,english,item,finish_date from $table_name ".$_SESSION["session_where"];
	$result_select_unfinish = mysql_query($select_unfinish);
	$num_unfinish = mysql_num_rows($result_select_unfinish);
	
	//random select one item
	$random = rand(0,$num_unfinish-1);
	
	//show item
	@mysql_data_seek($result_select_unfinish,$random);
	$result_unfinish = mysql_fetch_row($result_select_unfinish);
	$search_url = "https://tw.dictionary.yahoo.com/dictionary?p=".$result_unfinish[0];

	//disable finish button for finish item
	if(($result_unfinish[4] == "") || (empty($result_unfinish[4])))
	{$disabled = "";}
	else
	{$disabled = "disabled";}
	
	//show result
	echo "<label for='vocabulary_check'>";
		echo "Vocabulary : ";
		echo "<span class='".$_SESSION["session_vocabulary_result"]."' id='vocabulary'>$result_unfinish[0]</span>";
	echo "</label>";
	echo "<input type='checkbox' id='vocabulary_check' name='test_type[]' value='vocabulary' onchange='test_category_change()' ".$_SESSION["session_vocabulary"].">";
		
	echo "<label for='chinese_check'>";
		echo "Chinese : ";
		echo "<span class='".$_SESSION["session_chinese_result"]."' id='chinese'>$result_unfinish[1]</span>";
	echo "</label>";	
	echo "<input type='checkbox' id='chinese_check' name='test_type[]' value='chinese' onchange='test_category_change()' ".$_SESSION["session_chinese"].">";

	echo "<label for='english_check'>";
		echo "English : ";
		echo "<span class='".$_SESSION["session_english_result"]."' id='english'>$result_unfinish[2]</span>";
	echo "</label>";		
	echo "<input type='checkbox' id='english_check' name='test_type[]' value='english' onchange='test_category_change()' ".$_SESSION["session_english"].">";
	

	echo "<div data-role='navbar'>";
	echo "<ul>";
		echo "<li>";
			echo "<input class='click' type='button' value='NEXT' onclick=\"window.open('$current_url','_self')\">";	
		echo "</li>";
		echo "<li>";
			echo "<input class='click' type='button' value='TRANS' id='item_translate'>";
		echo "</li>";
		echo "<li>";
			echo "<input class='click' type='button' value='FINISH' onclick=\"item_finish('$result_unfinish[3]')\" $disabled>";
			echo "<input type='hidden' name='finish_item'>";
		echo "</li>";
		echo "<li>";
			echo "<input class='click' type='button' value='YAHOO' onclick=\"window.open('$search_url','_blank')\">";
		echo "</li>";	  
	echo "</ul>";	
	echo "</div>";
	
	
	//radio to select all,unfinish
		//select item number
		$select_number = "select 
							count(case when create_date is not NULL then 1 else null end) as total,	
							count(case when (finish_date is NULL or finish_date=0) then 1 else null end) as unfinish 
							from $table_name";
		$result_number = mysql_query($select_number);
		$data_number = mysql_fetch_row($result_number);
		
	
		//radio button
		echo "<div data-role='fieldcontain'>";
			echo "<fielset data-role='controlgroup' data-mini='true' data-type='horizontal' data-theme='a'>";
				echo "<input type='radio' name='range' id='unfinish' value='unfinish' onchange='submit()' ".$_SESSION["session_check_unfinish"].">";
				echo "<label for='unfinish'>Unfinish ($data_number[1])</label>";
				echo "<input type='radio' name='range' id='all' value='all' onchange='submit()' ".$_SESSION["session_check_all"].">";
				echo "<label for='all'>All Item ($data_number[0])</label>";		
			echo "</fielset>";
		echo "</div>";
	?>	
	</div>
	
	<a target="_blank" href="http://oahehc.comoj.com/">
	<div data-role="footer" data-position="fixed">
		<h1>Oahehc@2015</h1>
	</div>
	</a>
</div>


<!--New-->
<div data-role="page" id="new" data-theme="b">
	<div data-role="header" data-position="fixed">
	<h1>New</h1>
		<div data-role="navbar" data-iconpos="left">
			<ul>
			<li><a href="#test" data-icon="check">Test</a></li>
			<li><a href="#new" data-icon="plus" class="ui-btn-active ui-state-persist">New</a></li>
			<li><a href="#list" data-icon="bars">List</a></li>
			<li><a href="#achieve" data-icon="user">Achieve</a></li>
			</ul>
		</div>
	</div>
	
	<div data-role="content">
	<?php
	//new data create
	if($_POST["action"] == "add" && !empty($_POST["new_vocabulary"]) && (!empty($_POST["new_chinese"]) || !empty($_POST["new_english"])))
	{
	//received data
	$vocabulary = $_POST["new_vocabulary"];
	$chinese = $_POST["new_chinese"];
	$english = $_POST["new_english"];
	$now = time();
	
	//insert to mysql
	$insert_new = "insert into $table_name(vocabulary,chinese,english,create_date)
				   Values('$vocabulary','$chinese','$english','$now')";
	$result_insert_new = mysql_query($insert_new);		
	
		if($result_insert_new)
		{
		$_POST["new_vocabulary"] = "";
		$_POST["new_chinese"] = "";
		$_POST["new_english"] = "";
		}
	}
	
	//input column
	echo "<input class='text' name='new_vocabulary' maxlength=100 placeholder='Vocabulary' value='".$_POST["new_vocabulary"]."' autofocus>";
	echo "<input class='text' name='new_chinese' maxlength=100 placeholder='Chinese' value='".$_POST["new_chinese"]."'>";
	echo "<input class='text' name='new_english' maxlength=200 placeholder='English' value='".$_POST["new_english"]."'>";

	echo "<div data-role='navbar'>";
	echo "<ul>";
		echo "<li>";
		echo "<input class='click' type='button' value='ADD' onclick='add_new()'>";	
		echo "</li>";
		echo "<li>";
		echo "<input class='click' type='button' value='EXPLAIN' onclick='show_explain()'>";
		echo "</li>";  
	echo "</ul>";	
	echo "</div>";
	?>
	</div>
	
	<a target="_blank" href="http://oahehc.comoj.com/">
	<div data-role="footer" data-position="fixed">
		<h1>Oahehc@2015</h1>
	</div>
	</a>
</div>


<!--list-->
<div data-role="page" id="list" data-theme="b">
	<div data-role="header" data-position="fixed">
	<h1>List</h1>
		<div data-role="navbar" data-iconpos="left">
			<ul>
			<li><a href="#test" data-icon="check">Test</a></li>
			<li><a href="#new" data-icon="plus">New</a></li>
			<li><a href="#list" data-icon="bars" class="ui-btn-active ui-state-persist">List</a></li>
			<li><a href="#achieve" data-icon="user">Achieve</a></li>
			</ul>
		</div>
	</div>

	<div data-role="content">
	<?php
	//delete item
		if(!empty($_POST["delete_item"]))
		{
		$delete_item = "delete from $table_name where item='".$_POST["delete_item"]."'";
		$result_delete_item = mysql_query($delete_item);
		}
	//undo item
		if(!empty($_POST["undo_item"]))
		{
		$undo_item = "update $table_name set finish_date='0' where item='".$_POST["undo_item"]."'";
		$result_undo_item = mysql_query($undo_item);
		}
	//purge
		if($_POST["action"]=="purge")
		{
		$purge_item = "delete from $table_name";
		$result_purge_item = mysql_query($purge_item);			
		}
	
	//select all,finish,unfinish total number
	$select_number = "select 
						count(case when create_date is not NULL then 1 else null end) as total,	
						count(case when (finish_date is NULL or finish_date=0) then 1 else null end) as unfinish,	
						count(case when finish_date is not NULL and finish_date!=0 then 1 else null end) as finish 
						from $table_name";
	$result_number = mysql_query($select_number);
	$data_number = mysql_fetch_row($result_number);


	//received list type
		if(!empty($_POST["show_list_type"]))
		{
		$_SESSION["session_list_type"] = $_POST["show_list_type"];
		$_SESSION["session_keyword"] = "";
		}
		elseif(!empty($_POST["keyword"]))
		{
		$_SESSION["session_list_type"] = "";
		$_SESSION["session_keyword"] = $_POST["keyword"];			
		}
	
	//add selected color for input
		if($_SESSION["session_list_type"] == "all")
		{
		$all_selected = "selected";
		$unfinish_selected = "";
		$finish_selected = "";
		}
		elseif($_SESSION["session_list_type"] == "unfinish")
		{
		$all_selected = "";
		$unfinish_selected = "selected";
		$finish_selected = "";
		}
		elseif($_SESSION["session_list_type"] == "finish")
		{
		$all_selected = "";
		$unfinish_selected = "";
		$finish_selected = "selected";
		}
		else
		{
		$all_selected = "";
		$unfinish_selected = "";
		$finish_selected = "";
		}
	
	//selection for list
	echo "<div data-role='navbar'>";
	echo "<ul>";
		echo "<li class='button'>";
		echo "<input type='button' class='date $all_selected' value='All ($data_number[0])' onclick=\"show_list('all')\">";
		echo "</li>";
		echo "<li class='button'>";
		echo "<input type='button' class='date $unfinish_selected' value='Unfinsih ($data_number[1])' onclick=\"show_list('unfinish')\">";
		echo "</li>";  
		echo "<li class='button'>";
		echo "<input type='button' class='date $finish_selected' value='Finish ($data_number[2])' onclick=\"show_list('finish')\">";
		echo "<input type='hidden' name='show_list_type'>";
		echo "</li>";  
		echo "<li class='purge'>";
		echo "<input type='button' class='purge' value='Purge' onclick=\"purge_all()\" data-icon='forbidden'>";
		echo "</li>";  		
	echo "</ul>";	
	echo "</div>";			
	echo "<input data-theme='a' type='search' name='keyword' onchange='submit()' value='".$_POST["keyword"]."' autofocus>";

	//show list	
		//check list range	
		if(!empty($_SESSION["session_list_type"]) || !empty($_SESSION["session_keyword"]))
		{
		//received list type
		$list_type = $_SESSION["session_list_type"];
			if("unfinish" == $list_type)
			{$where = "where (finish_date is NULL or finish_date=0)";}
			elseif("finish" == $list_type)
			{$where = "where finish_date is NOT NULL and finish_date!=0";}
			else
			{$where = "";}
		
			if(empty($_SESSION["session_keyword"]))
			{$keyword = "";}
			else
			{$keyword = "where (vocabulary like '%".$_SESSION["session_keyword"]."%' or chinese like '%".$_SESSION["session_keyword"]."%' or english like '%".$_SESSION["session_keyword"]."%')";}

		//select vocabulary data
		$select_vocabulary = "select vocabulary,chinese,english,create_date,finish_date,item from $table_name $where $keyword order by vocabulary asc";
		$result_select_vocabulary = mysql_query($select_vocabulary);
		$num_vocabulary = mysql_num_rows($result_select_vocabulary);

		//show data
			for($i=0;$i<$num_vocabulary;$i++)
			{
			$data_vocabulary = @mysql_fetch_row($result_select_vocabulary);
			
				//create undo button or finish button
				if(empty($data_vocabulary[4]))
				{echo "<a class='same_line' href='#' data-role='button' data-icon='check' data-iconpos='notext' onclick=\"item_finish('$data_vocabulary[5]')\"></a>";}
				else
				{echo "<a class='same_line' href='#' data-role='button' data-icon='refresh' data-iconpos='notext' onclick=\"item_undo('$data_vocabulary[5]')\"></a>";}
					
				//delete button
				echo "<a class='same_line' href='#' data-role='button' data-icon='delete' data-iconpos='notext' onclick=\"item_delete('$data_vocabulary[5]')\"></a>";					  
				echo "<div style='clear:both'></div>";

				
				//content
				echo $data_vocabulary[0];
				echo " / ";
				echo $data_vocabulary[1];
				echo " / ";
				echo $data_vocabulary[2];
				echo " / ";
				echo "<span class='small'>".date("Y-m-d",$data_vocabulary[3])."</span>";
				echo "<hr>";
			}
		}
		echo "<input type='hidden' name='delete_item'>";
		echo "<input type='hidden' name='undo_item'>";
	?>
	</div>
	
	<a target="_blank" href="http://oahehc.comoj.com/">
	<div data-role="footer" data-position="fixed">
		<h1>Oahehc@2015</h1>
	</div>
	</a>
</div>


<!--achieve-->
<div data-role="page" id="achieve" data-theme="b">
	<div data-role="header" data-position="fixed">
	<h1>Achieve</h1>
		<div data-role="navbar" data-iconpos="left">
			<ul>
			<li><a href="#test" data-icon="check">Test</a></li>
			<li><a href="#new" data-icon="plus">New</a></li>
			<li><a href="#list" data-icon="bars">List</a></li>
			<li><a href="#achieve" data-icon="user" class="ui-btn-active ui-state-persist">Achieve</a></li>
			</ul>
		</div>
	</div>

	<div data-role="content">
	<?php
	//received range
	if(!empty($_POST["achieve_unit"]))
	{$_SESSION["session_achieve_unit"] = $_POST["achieve_unit"];}
		//set date_array
		if("month" == $_SESSION["session_achieve_unit"])
		{
		$date_start = strtotime(date("Y-m",strtotime("+1 month",time()))."-01");
		$date_shift = "-1 month";
		$date_name = "";
		$date_unit = "F";
		$month_selected = "selected";
		$week_selected = "";
		$day_selected = "";
		}
		elseif("week" == $_SESSION["session_achieve_unit"])
		{
		$date_start = strtotime(date("Y-m-d",time())) + (7-date("w",time()))*60*60*24;
		$date_shift = "-1 week";
		$date_name = "WK";
		$date_unit = "W";	
		$month_selected = "";
		$week_selected = "selected";
		$day_selected = "";	
		}
		elseif("day" == $_SESSION["session_achieve_unit"])
		{
		$date_start = strtotime(date("Y-m-d",time()))+60*60*24;
		$date_shift = "-1 day";
		$date_name = "";
		$date_unit = "m/d";	
		$month_selected = "";
		$week_selected = "";
		$day_selected = "selected";		
		}
		
		$date_array[0] = $date_start;
		for($i=1;$i<=$achieve_range;$i++)
		{$date_array[$i] = strtotime($date_shift,$date_array[$i-1]);}
	

	//selection for date unit
	echo "<div data-role='navbar'>";
	echo "<ul>";
		echo "<li>";
		echo "<input type='button' class='date $month_selected' value='Month' onclick=\"set_achieve_unit('month')\">";
		echo "</li>";
		echo "<li>";
		echo "<input type='button' class='date $week_selected' value='Week' onclick=\"set_achieve_unit('week')\">";
		echo "</li>";  
		echo "<li>";
		echo "<input type='button' class='date $day_selected' value='Day' onclick=\"set_achieve_unit('day')\">";
		echo "<input type='hidden' name='achieve_unit'>";
		echo "</li>";  
	echo "</ul>";	
	echo "</div>";		
	echo "<br>";
	
		if(!empty($_SESSION["session_achieve_unit"]))
		{
		//select data
			for($j=0;$j<$achieve_range;$j++)
			{
			//select finish,unfinish number by range
			$select_achieve = "select 
								count(case when finish_date<".$date_array[$j]." and finish_date>=".$date_array[$j+1]." then 1 else null end) as finish,
								count(case when create_date<".$date_array[$j]." and create_date>=".$date_array[$j+1]." then 1 else null end) as created 
								from $table_name";
			$result_select_achieve = mysql_query($select_achieve);
			$data_achieve = @mysql_fetch_row($result_select_achieve);
			
			$array_finish[$j] = $data_achieve[0];
			$array_add[$j] = $data_achieve[1];
			
			//calculate max item number
			$max_item = max($default_min_item,$max_item,$array_finish[$j],$array_add[$j]);			
			}
		//show data
			for($j=0;$j<$achieve_range;$j++)
			{
			//width calculate
			$finish_width = ($array_finish[$j]/$max_item*100)."%";
			$add_width = ($array_add[$j]/$max_item*100)."%";			
			
			//adjust color for zero
				if($array_finish[$j] == 0)
				{$finish_color = "white";}
				else
				{$finish_color = "";}
				if($array_add[$j] == 0)
				{$add_color = "white";}
				else
				{$add_color = "";}
			
			echo "<div class='out'>";
				echo "<div class='left'>";
				echo $date_name.date($date_unit,$date_array[$j]-1);
				echo "</div>";
				echo "<div class='right'>";
					echo "<div class='finish $finish_color' style='width:$finish_width'>";
					echo "&nbsp;&nbsp;".number_format($array_finish[$j],0,".",",");
					echo "</div>";
					echo "<div class='add $add_color' style='width:$add_width'>";
					echo "&nbsp;&nbsp;".number_format($array_add[$j],0,".",",");	
					echo "</div>";
				echo "</div>";
			echo "</div>";			  
			}
			echo "<div class='finish center topspace' style='width:20%'>";
			echo "Finish";
			echo "</div>";
			echo "<div class='add center' style='width:20%'>";
			echo "Add";
			echo "</div>";
		}
	?>
	</div>
	
	<a target="_blank" href="http://oahehc.comoj.com/">
	<div data-role="footer" data-position="fixed">
		<h1>Oahehc@2015</h1>
	</div>
	</a>
</div>
	
	
</form>
</body>
</html>

<script language="JavaScript">
//page: TEST
	function item_finish(x){
		document.vocabulary.finish_item.value = x;
		document.vocabulary.submit();	
	}
	function test_category_change(){
		document.vocabulary.action.value = "test_category_change";
		document.vocabulary.submit();			
	}

//page: ADD
	function show_explain(){
		var vocabulary = document.vocabulary.new_vocabulary.value;
		if(vocabulary != "")
		{
		window.open("https://tw.dictionary.yahoo.com/dictionary?p=" + vocabulary, "yahoo");
		//window.open("http://cdict.info/equery/"+vocabulary, "cdict");
		window.open("http://www.merriam-webster.com/dictionary/" + vocabulary, "merriam");		
		}	
	}
	function add_new(){
		document.vocabulary.action.value = "add";
		document.vocabulary.submit();
	}

//page: List
	function show_list(x){
		document.vocabulary.show_list_type.value = x;
		document.vocabulary.keyword.value = "";
		document.vocabulary.submit();
	}
	function item_delete(x){
		if(confirm('[NOTICE]\nConfirm to delete'))
		{	
		document.vocabulary.delete_item.value = x;
		document.vocabulary.submit();	
		}
	}
	function item_undo(x){
		document.vocabulary.undo_item.value = x;
		document.vocabulary.submit();	
	}	
	function purge_all(){
		if(confirm('[NOTICE]\nConfirm to purge all data\n(delete data can not been restored)'))
		{	
		document.vocabulary.action.value = "purge";		
		document.vocabulary.submit();	
		}		
	}
	
//page: Achieve
	function set_achieve_unit(x){
		document.vocabulary.achieve_unit.value = x;
		document.vocabulary.submit();
	}

	
</script>
