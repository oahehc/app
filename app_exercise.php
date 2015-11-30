<?php 
//啟用暫存 for session
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--Load jquery-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script>
	if(typeof jQuery === 'undefined')
	{
	var s = document.createElement('script');
	s.setAttribute('type', 'text/javascript');
	s.setAttribute('src', 'http://ajax.microsoft.com/ajax/jquery/jquery-1.4.min.js');
		if (eval("typeof " + look_for) == 'undefined') 
		{
		var head = document.getElementsByTagName('head')[0];
		if (head) head.appendChild(s);
		else document.body.appendChild(s);
		}	
	}
	</script>			
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<!--
	<script type="text/javascript" src="ext/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="ext/jquery-ui.min.js"></script>
-->

	<!--Open Graph for FB-->
	<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">	
	<meta property="og:title" content=""/>
	<meta property="og:type" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="fb:admins" content=""/>
	<meta property="fb:app_id" content=""/>
	<meta property="og:description" content=""/>
 
	<meta name="keyword" content="exercise,workout, training, clock, timer">
	<meta name="description" content="timer for exercise">
	<meta name="author" content="Oahehc">	
	<!--網站標題/我的最愛圖片-->
	<link rel="shortcut icon" href="pic/exercise.jpg">
	<!--設為主畫面APP連結時的圖片-->
	<link rel="apple-touch-icon" href="pic/exercise.jpg">
	<!--視窗填滿手機畫面-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--加到主畫面時，使網址列與最下面的選單消失，變為全螢幕模式-->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">		
	<!--CSS-->
	<link href="exercise.css" media="screen" rel="stylesheet" type="text/css">
	<title>Exercise</title>
</head>
	<script language="JavaScript">
	var array_digit_up  = new Array('G','A','B','B','D','C','C','G','F','F');
	var array_digit_down  = new Array('D','A','C','B','E','B','F','A','F','E');	
			
		/*count down from three to zero*/
		function count_three(){
			$("div#three").css("display","block");
			$("div#three").css("color","black");
			$("div#three").animate({color: "transparent"}, 1000);
		}
		function count_two(){
			$("div#two").css("display","block");
			$("div#two").css("color","black");
			$("div#two").animate({color: "transparent"}, 1000);
		}
		function count_one(){
			$("div#one").css("display","block");
			$("div#one").css("color","black");
			$("div#one").animate({color: "transparent"}, 1000);
		}
		function count_start(){
			$("div#start").css("display","block");
			$("div#start").css("color","black");
			$("div#start").animate({color: "transparent"}, 1000);
		}
		function count_hidden(){
			$("div.count_down").css("display","none");
		}
		function count_down_start(){
			count_three();
			setTimeout("count_two()", 1000);
			setTimeout("count_one()", 2000);
			setTimeout("count_start()", 3000);
			setTimeout("count_hidden()", 4000);
		}	
		
		/*clock start*/
		function clock_start(){
			var time = $("input.time").val();
			if(time<0)
			{
			$("div.up").removeAttr("id");
			$("div.up").attr("id", "G");
			$("div.down").removeAttr("id");
			$("div.down").attr("id", "D");
			}
			else
			{
			var min = Math.floor(time/60);
			var sec = time%60;
			var min_ten = Math.floor(min/10);
			var min_one = min%10;
			var sec_ten = Math.floor(sec/10);
			var sec_one = sec%10;
			
			$("div.min_ten_up").removeAttr("id");
			$("div.min_ten_up").attr("id", array_digit_up[min_ten]);
			$("div.min_ten_down").removeAttr("id");
			$("div.min_ten_down").attr("id", array_digit_down[min_ten]);	

			$("div.min_one_up").removeAttr("id");
			$("div.min_one_up").attr("id", array_digit_up[min_one]);
			$("div.min_one_down").removeAttr("id");
			$("div.min_one_down").attr("id", array_digit_down[min_one]);		
			
			$("div.sec_ten_up").removeAttr("id");
			$("div.sec_ten_up").attr("id", array_digit_up[sec_ten]);
			$("div.sec_ten_down").removeAttr("id");
			$("div.sec_ten_down").attr("id", array_digit_down[sec_ten]);	

			$("div.sec_one_up").removeAttr("id");
			$("div.sec_one_up").attr("id", array_digit_up[sec_one]);
			$("div.sec_one_down").removeAttr("id");
			$("div.sec_one_down").attr("id", array_digit_down[sec_one]);	
			
			time++
			$("input.time").val(time);
			setTimeout("clock_start()", 1000);
			}
		}	

		/*create list*/
		function create_list(){
			var workout_period = $("input#workout").val();
			var rest_period = $("input#rest").val();
			var round = $("input#round").val();
			var start_time,end_time,start_min,start_sec,end_min,end_sec,content;
			end_time = 0;
			
			$("div.list").empty();
			for(var i=1;i<=round;i++)
			{
			$("div.list").append("<div class='round round_" + i + "'>Round " + i + "</div><div style='clear:both'></div>");	
				start_time = end_time;
				end_time = start_time + workout_period*1;
				start_min = Math.floor(start_time/60);
				start_sec = start_time%60;
				end_min = Math.floor(end_time/60);
				end_sec = end_time%60;					
					content = "<div class='list_content round_" + i + " workout_" + i + "'>" 
								+ "<div>" + format_adjust(start_min) + ":" + format_adjust(start_sec) + " ~ " + format_adjust(end_min) + ":" + format_adjust(end_sec) + "</div>" 
								+ "<div>Workout</div>"
								+ "</div><div style='clear:both'></div>";	
								
				start_time = end_time;
				end_time = start_time + rest_period*1;
				start_min = Math.floor(start_time/60);
				start_sec = start_time%60;
				end_min = Math.floor(end_time/60);
				end_sec = end_time%60;								
					content = content 
								+ "<div class='list_content round_" + i + " rest_" + i + "'>"  
								+ "<div>" + format_adjust(start_min) + ":" + format_adjust(start_sec) + " ~ " + format_adjust(end_min) + ":" + format_adjust(end_sec) + "</div>" 
								+ "<div>Rest</div>" 
								+ "</div><div style='clear:both'></div>";							
							
				$("div.list").append(content);		
			}
		}
			function format_adjust(x){
				if(x<10)
				{
				x = "0" + x;	
				return x;
				}
				else
				{return x;}				
			}
		
		/*list status update*/
		function list_status_update(){
			var time = $("input.time").val() - 1;
			var workout_period = $("input#workout").val();
			var rest_period = $("input#rest").val();
			var round = $("input#round").val();

			var remind = time%(parseInt(workout_period)+parseInt(rest_period));
			var div = Math.floor(time/(parseInt(workout_period)+parseInt(rest_period))) + 1;
			
			/*div > round => close*/
			if(div > round)
			{
			var rest_class = "div.rest_" + (div-1);
			$(rest_class).removeAttr("id");
			$(rest_class).attr("id", "close");	
			/*change button*/
			$("input.pause").css("display","none");
			$("input.finish").css("display","inline");
			/*close timer*/
			$("input.time").val(-1);	
			/*show finish div*/			
			var content = "<div class='round' id='ongoing'>Finish</div>";
			$("div.list").append(content);	
			}
			/*mod < workout => close onging(div-1); ongoing workout(div)*/
			else if(remind<workout_period)
			{
			var workout_class = "div.workout_" + div;
			var rest_class = "div.rest_" + (div-1);
			$(workout_class).attr("id", "ongoing");
			$(rest_class).removeAttr("id");
			$(rest_class).attr("id", "close");
				/*hide last round*/
				var round_class = "div.round_" + (div-1);
				$(round_class).css("display","none");				
			}	
			/*mod >= workout => close workout(div); ongoing rest(div)*/
			else
			{
			var workout_class = "div.workout_" + div;
			var rest_class = "div.rest_" + div;
			$(workout_class).removeAttr("id");
			$(workout_class).attr("id", "close");
			$(rest_class).attr("id", "ongoing");
			}
		setTimeout("list_status_update()", 1000);			
		}

		
		/*start button*/
		function exercise_start(){
			$("input.time").val(0);
			$("div.setting").css("display","none");
			$("div.clock").css("display","block");
			$("div.list").css("display","block");
			$("input.pause").css("display","inline");
			$("input.finish").css("display","none");
			create_list();
			count_down_start();
			setTimeout("clock_start()", 4000);
			setTimeout("list_status_update()", 4000);
		}
		/*clock pause and stop*/		
		function clock_pause(){
			alert('[PAUSE] Yes to continue');
		}			
		function clock_stop(){
			if(confirm('[STOP]\n Yes : stop clock\n No : keep play'))
			{
			$("input.time").val(-1);
			$("div.setting").css("display","block");
			$("div.clock").css("display","none");
			$("div.list").css("display","none");	
			}
		}	
		/*re-setting button*/
		function re_setting(){
			$("div.setting").css("display","block");
			$("div.clock").css("display","none");
			$("div.list").css("display","none");			
		}
		
	</script>
<body>
<?php
//設定時區
date_default_timezone_set("Asia/Taipei");

//關閉error report
//error_reporting(E_ALL);
error_reporting(0);

//開啟session
session_start();

//載入函式庫
include ("ext/constant.php");

//連線至MYSQL
/*
$link = mysql_connect(mysql_host,mysql_user,mysql_pw);
mysql_query("SET NAMES 'utf8'");
mysql_select_db(mysql_db,$link);
*/
$link = mysql_connect("localhost","root","williams");
mysql_query("SET NAMES 'utf8'");
mysql_select_db("oahehc",$link);
set_time_limit(600);


//insert visit record
if(empty($_SESSION["visit_exercise"]))
{
//已寫入瀏覽紀錄, 避免寫入重複資料
$_SESSION["visit_exercise"] = "y";

//取得user真實ip
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
	{$user_ip = $_SERVER['HTTP_CLIENT_IP'];}
	else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
	else
	{$user_ip = $_SERVER['REMOTE_ADDR'];}

//取得進入網頁時間
$onload_time  = date('Y-m-d H:i:s');

//取得目前瀏覽檔名
$url = $_SERVER['PHP_SELF'];

//取得前一網頁
$last_page = $_SERVER['HTTP_REFERER'];	

//取得瀏覽器資料
$agent = $_SERVER['HTTP_USER_AGENT'];

//寫入瀏覽紀錄
$insert_visit = "insert into visit(user_id,user_ip,onload_time,url,last_page,agent) 
				 Values('$id','$user_ip','$onload_time','$url','$last_page','$agent')";
$insert = mysql_query($insert_visit);
}
?>
<form method="GET" name="exercise" target="_self">
<!--count down div before start-->
<div class="count_down" id="three">3</div>
<div class="count_down" id="two">2</div>
<div class="count_down" id="one">1</div>
<div class="count_down" id="start">START</div>


<!--setting input-->
<div class="setting">
	<input class="data" id="workout" type="number" max="180" min="0" step="1" name="workout" value=60>
		<label for="workout">Workout(sec)</label><br>
	<input class="data" id="rest" type="number" max="180" min="0" step="1" name="rest" value=60>
		<label for="rest">Rest(sec)</label><br>
	<input class="data" id="round" type="number" max="10" min="1" step="1" name="round" value=5>
		<label for="round">Round</label><br>
	<input type="button" value="START" onclick="exercise_start()">
	<input type="reset" value="RESET">
	<input type="hidden" class="time" value=0>
</div>


<!--clock for timing-->
<div class="clock">
	<div class="float">
		<div class="square up min_ten_up" id="G"><div class="in"></div></div>
		<div class="square down min_ten_down" id="D"><div class="in"></div></div>
	</div>
	<div class="float">
		<div class="square up min_one_up" id="G"><div class="in"></div></div>
		<div class="square down min_one_down" id="D"><div class="in"></div></div>
	</div>

	<div class="float">
		<div class="dotted_up">●</div>
		<div class="dotted_down">●</div>
	</div>
	
	<div class="float">
		<div class="square up sec_ten_up" id="G"><div class="in"></div></div>
		<div class="square down sec_ten_down" id="D"><div class="in"></div></div>
	</div>
	<div class="float">
		<div class="square up sec_one_up" id="G"><div class="in"></div></div>
		<div class="square down sec_one_down" id="D"><div class="in"></div></div>
	</div>
	
	<div style="clear:both"></div>
	<input class="pause" type="button" value="PAUSE" onclick="clock_pause()">
	<input class="pause" type="button" value="STOP" onclick="clock_stop()">
	<input class="finish" type="button" value="Re-START" onclick="exercise_start()">
	<input class="finish" type="button" value="SETTING" onclick="re_setting()">
</div>


<!--workout list-->
<div class="list"></div>


</form>
</body>
</html>
