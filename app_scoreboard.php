<?php 
//啟用暫存 for session
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
<style>
	body{
		font-family:Calibri, Arial, 微軟正黑體;
		font-size:1em;
	}
	
	input,select{
		font-family:Calibri, Arial, 微軟正黑體;	
	}
	input.button{
		width:100px;
	}		
	input.short{
		width:60px;
	}		
	input.center{
		text-align:center;
	}	
	
	table{
		border-collapse:collapse;
		white-space:nowrap;  //強制不換行
	}
	td{
		border:1px solid black;
		padding:3px 5px;
	}
	td.unborder{
		border:0px;
	}
	td.unpadding{
		padding:0px;
	}
	td.right{
		text-align:right;
	}
	td.center{
		text-align:center;
	}
	td.bold{
		font-weight:bold;
	}
	td.upperline{
		border:0px;
		border-top:2px solid black;
	}
	tr.lightgray{
		background:lightgray;
	}
	td.short{
		width:60px;
	}
	td.red{
		color:red;
	}
	td.small{
		font-size:0.8em;
	}
	td.middle{
		font-size:0.9em;
	}	
	
</style>

	<meta name="keyword" content="scoreboard">
	<meta name="description" content="scoreboard for your gambling">
	<meta name="author" content="Oahehc">	
	<!--網站標題/我的最愛圖片-->
	<link rel="shortcut icon" href="pic/scoreboard.jpg">
	<!--設為主畫面APP連結時的圖片-->
	<link rel="apple-touch-icon" href="pic/scoreboard.jpg">
	<!--視窗填滿手機畫面-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--加到主畫面時，使網址列與最下面的選單消失，變為全螢幕模式-->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">		
	<title>ScoreBoard</title>
</head>
<body>
<!--隱藏iframe for refresh頁面, 避免SESSION過期-->
<iframe style="display:none;" src="session_unexpired.php"></iframe>

<?php
//關閉error report
//error_reporting(0);
//error_reporting(E_ALL);

//開啟SESSION
session_start();
session_register("session_game_name");
session_register("session_game_password");


//載入常數,函式
include ("ext/constant.php");

//連線至MYSQL

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


//default player number
$default_player = 4;
$max_player = 12;

//form
echo "<form method='GET' name='scoreboard'>";

//receive game name, password and set to session
if(!empty($_GET["game_name"]))
{$_SESSION["session_game_name"] = $_GET["game_name"];}
if(!empty($_GET["game_password"]))
{$_SESSION["session_game_password"] = $_GET["game_password"];}

//player number
if(empty($_GET["player_number"]))
{$_GET["player_number"] = $default_player;}
echo "<input type='hidden' name='max_player_number' value='".$max_player."'>";
echo "<input type='hidden' name='player_number' value='".$_GET["player_number"]."'>";
$player_number = $_GET["player_number"];
	
//received player data and insert to mysql for game create
if($_GET["start_game"] == "y")
{	
	//number for ordering
	$j=0;
	
	for($i=1;$i<=$player_number;$i++)
	{	
		if(!empty($_GET["player_$i"]))
		{
		$j++;
		$player_name = $_GET["player_$i"];
		$insert_player = "insert scoreboard set name='".$_SESSION["session_game_name"]."', password='".$_SESSION["session_game_password"]."', player='$player_name', ordering='$j', round=0, amount=0";
		
			$now = time();
			if(($now - $_SESSION["insert_player_time_$i"])>3)
			{
			$result_add_player = mysql_query($insert_player);
			$_SESSION["insert_player_time_$i"] = time();
			}
		}		
	}
	//insert game start time
	if($result_add_player)
	{
	$now = time();	
	$insert_start = "insert scoreboard set name='".$_SESSION["session_game_name"]."', password='".$_SESSION["session_game_password"]."', player='start', ordering=0, round=0, amount='$now'";
	$insert_update = "insert scoreboard set name='".$_SESSION["session_game_name"]."', password='".$_SESSION["session_game_password"]."', player='update', ordering=100, round=0, amount='$now'";
	
		if(($now - $_SESSION["insert_start_time"])>3)
		{
		$result_start = mysql_query($insert_start);
		$result_update = mysql_query($insert_update);
		$_SESSION["insert_start_time"] = time();
		}	
	}
}

//select player
$select_player = "select distinct player,ordering from scoreboard where name='".$_SESSION["session_game_name"]."' and password='".$_SESSION["session_game_password"]."' and ordering!=100 order by ordering";
$result_player = mysql_query($select_player);
$num_player = @mysql_num_rows($result_player);
	//create player array
	$player_array = array();
	for($j=0; $j<$num_player; $j++)
	{
	$data_player = mysql_fetch_row($result_player);
	$player_array_add = array($data_player[1]=>$data_player[0]);
	$player_array = array_merge($player_array,$player_array_add);
	}

//select total round
$select_total_round = "select round from scoreboard where name='".$_SESSION["session_game_name"]."' and password='".$_SESSION["session_game_password"]."' order by round desc limit 1";
$result_total_round = mysql_query($select_total_round);
$data_total_round = mysql_fetch_row($result_total_round);
$new_round = $data_total_round[0] + 1;
	
//save type
echo "<input type='hidden' name='save_type'>";
	//new record
	if($_GET["save_type"] == "r")
	{
		//calculate total amount
		for($j=1;$j<$num_player;$j++)
		{$total_amount += $_GET["win_amount_$j"] - $_GET["lose_amount_$j"];}
		
		//check sum of amount equal to zero
		if(!empty($_GET["amount_check"]) && $total_amount!=0)
		{echo "<script>alert('Total amount doesn\'t equal to 0')</script>";}
		else
		{
			for($j=1;$j<$num_player;$j++)
			{
			//receive input data
			$new_amount = $_GET["win_amount_$j"] - $_GET["lose_amount_$j"];
			
			//insert to mysql
			$insert_new_amount = "insert scoreboard set name='".$_SESSION["session_game_name"]."', password='".$_SESSION["session_game_password"]."', player='$player_array[$j]', ordering='$j', round='$new_round', amount='$new_amount'";
			
				$now = time();
				if(($now - $_SESSION["insert_new_amount_time_$j"])>3)
				{
				$result_new_amount = mysql_query($insert_new_amount);
				$_SESSION["insert_new_amount_time_$j"] = time();
				}
			}
			//update game time
			if($result_new_amount)
			{
			$now = time();	
			$update_update = "update scoreboard set amount='$now' where name='".$_SESSION["session_game_name"]."' and password='".$_SESSION["session_game_password"]."' and player='update' and ordering=100 and round=0";
			$result_update = mysql_query($update_update);	
			}
		}	
	}	
	//player edit
	elseif($_GET["save_type"] == "u")
	{
		echo "<table>";
		for($j=1; $j<=$num_player; $j++)
		{
		echo "<tr>
				<td class='unborder'>
					<label for='player_$j'>Player $j</label>
				</td>
				<td class='center unborder'>
					<input id='player_$j' name='player_$j' value='$player_array[$j]' maxlength=14>
				</td>			
			  </tr>";
		}
		echo "<tr>
				<td class='unborder'></td>
				<td class='unborder right'>
					<input type='hidden' name='player_edit'>
					<input type='button' value='Save' onclick='player_update()'>
				</td>
			  </tr>";
		echo "</table><hr>";
		
		//save new player
		if($_GET["player_edit"] == "y")
		{
		//update old player data
			for($j=1; $j<$num_player; $j++)
			{
				if(!empty($_GET["player_$j"]))
				{
				//received data
				$player_name = $_GET["player_$j"];
				
				//update to mysql
				$update_player = "update scoreboard set player='$player_name' where ordering='$j' and name='".$_SESSION["session_game_name"]."' and password='".$_SESSION["session_game_password"]."'";
				$result_update_player = mysql_query($update_player);
				}
			}
		//new player
			//received data
			if(!empty($_GET["player_$j"]))
			{
			$player_name = $_GET["player_$j"];			
			
			//insert to mysql
			$insert_new_player = "insert scoreboard set name='".$_SESSION["session_game_name"]."', password='".$_SESSION["session_game_password"]."', player='$player_name', ordering='$j', round=0, amount=0";
			$now = time();
				if(($now - $_SESSION["insert_new_player_time"])>3)
				{
				$result_new_player = mysql_query($insert_new_player);
				$_SESSION["insert_new_player_time"] = time();
				}
			}
		//relocate to scoreboard
		header("Location:scoreboard.php");
		}		
	}	
	//clear data
	elseif($_GET["save_type"] == "c")
	{
	$clear_data = "delete from scoreboard where round>0 and name='".$_SESSION["session_game_name"]."' and password='".$_SESSION["session_game_password"]."'";
	$result_clear_data = mysql_query($clear_data);
	}	
	//new game
	elseif($_GET["save_type"] == "n" || $_GET["save_type"] == "l")
	{
	//clear session
	$_SESSION["session_game_name"] = "";
	$_SESSION["session_game_password"] = "";
	}	
	//delete game data
	elseif($_GET["save_type"] == "d")
	{
	$delete_data = "delete from scoreboard where round>=0 and name='".$_SESSION["session_game_name"]."' and password='".$_SESSION["session_game_password"]."'";
	$result_delete_data = mysql_query($delete_data);
	//clear session
	$_SESSION["session_game_name"] = "";
	$_SESSION["session_game_password"] = "";
	}
	//delete single round (update amount to 0)
	elseif(!empty($_GET["delete_round_number"]))
	{
	$round_number = $_GET["delete_round_number"];
	$update_round_number = "update scoreboard set amount=0 where round='$round_number' and name='".$_SESSION["session_game_name"]."' and password='".$_SESSION["session_game_password"]."'";
	$result_round_number = mysql_query($update_round_number);
	}
	
	
//select player & total round again for add player
$result_player = mysql_query($select_player);
$num_player = @mysql_num_rows($result_player);
$result_total_round = mysql_query($select_total_round);
$data_total_round = mysql_fetch_row($result_total_round);
$new_round = $data_total_round[0] + 1;

//New game or loading to old data
if(empty($_SESSION["session_game_name"]) || empty($_SESSION["session_game_password"]))
{
	//input table
	echo "<table>
		  <tr>
			<td class='unborder'>
				<label for='name'>Game Name</label>
			</td>
			<td class='unborder'>
				<input id='name' name='game_name' maxlength=14 autofocus>
			</td>			
		  </tr>
		  <tr>
			<td class='unborder'>
				<label for='password'>Game Password</label>
			</td>
			<td class='unborder'>
				<input id='password' name='game_password' maxlength=14>
			</td>
		  </tr>
		  <tr>
			<td class='unborder'></td>
			<td class='unborder right'>
				<input type='submit' value='Create/LogIn'>
				<input type='reset' value='Reset'>
			</td>
		  </tr>";		  
	echo "</table>";
}
//setting player
elseif($num_player == 0)
{
	//setting player table
	echo "<table>";
	for($i=1;$i<=$player_number;$i++)
	{
	//received data to reserve input when click add_player
		if(!empty($_GET["player_$i"]))
		{$player_input = $_GET["player_$i"];}
		else
		{$player_input = "";}	
	
	echo "<tr>
			<td class='unborder'>
				<label for='player_$i'>Player $i</label>
			</td>
			<td class='center unborder'>
				<input id='player_$i' name='player_$i' maxlength=14 value=$player_input>
			</td>			
		  </tr>";
	}
	echo "<tr>
			<td class='unborder right' colspan=2>
				<input type='hidden' name='start_game'>
				<input type='button' value='Start' onclick='player_set()'>
				<input type='button' value='Add player' onclick=\"add_player('$i')\">
				<input type='button' value='Cancel' onclick=\"save_function('l')\">
			</td>
		  </tr>";	
	echo "</table>";
}
//scoreboard data
else
{	
	echo "<table>";
	
	//select player and total amount
	$select_game_player = "select player,sum(amount) from scoreboard where name='".$_SESSION["session_game_name"]."' and password='".$_SESSION["session_game_password"]."' and ordering!=0 and ordering!=100 group by player order by ordering";
	$result_game_player = mysql_query($select_game_player);
	$num_game_player = mysql_num_rows($result_game_player);
		
	//game name & password
	echo "<tr>
			<td class='unborder bold'>Name</td>
			<td class='unborder bold' colspan=".$num_game_player.">".$_SESSION["session_game_name"]."</td>	
		  </tr>
		  <tr>
			<td class='unborder bold'>Password</td>
			<td class='unborder bold' colspan=".$num_game_player.">".$_SESSION["session_game_password"]."</td>	
		  </tr>";
	
	//show player and upper line
	echo "<tr>
			<td class='upperline' colspan=2>
				<input type='button' value='Player Edit' onclick=\"save_function('u')\">			
			</td>";
		for($j=1;$j<=$num_game_player;$j++)
		{
		$data_game_player = mysql_fetch_row($result_game_player);
		echo "<td class='upperline center bold'>$data_game_player[0]</td>";
		}
	echo "</tr>";
	
	//show total amount
	echo "<tr class='lightgray'>";
	echo "<td class='unborder center bold'>Total</td><td class='unborder'></td>";
		@mysql_data_seek($result_game_player,0);
		for($j=1;$j<=$num_game_player;$j++)
		{
		$data_game_player = mysql_fetch_row($result_game_player);
			//mark red for negative amount
			if($data_game_player[1]<0)
			{$red = "red";}
			else
			{$red = "";}
		echo "<td class='unborder right bold short $red'>".number_format($data_game_player[1],0,".",",")."</td>";
		}
	echo "</tr>";
	
	//new round
		if(empty($_GET["score_mode"]))
		{	
		echo "<tr>";
		echo "<td rowspan=2 class='unborder center bold'>Round $new_round</td>
			  <td class='unborder'>Win</td>";
			for($j=1;$j<=$num_game_player;$j++)
			{
			echo "<td class='unborder'><input class='short center' type='number' name='win_amount_$j'></td>";		  
			}
		echo "<td rowspan=2 class='unborder'>
				<input type='button' value='Save' onclick=\"save_function('r')\">
			  </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='unborder'>Lose</td>";
			for($j=1;$j<=$num_game_player;$j++)
			{
			echo "<td class='unborder'><input class='short center' type='number' min=0 step=1 name='lose_amount_$j'></td>";	  
			}
		echo "</tr>";
		}
		//score mode only show winning score input
		else
		{	
		echo "<tr>";
		echo "<td class='unborder center bold'>Round $new_round</td>
			  <td class='unborder'></td>";
			for($j=1;$j<=$num_game_player;$j++)
			{
			echo "<td class='unborder'><input class='short center' type='number' name='win_amount_$j'></td>";		  
			}
		echo "<td class='unborder'>
				<input type='button' value='Save' onclick=\"save_function('r')\">
			  </td>";
		echo "</tr>";
		}		
		
		
	//raw data
	for($i=$data_total_round[0];$i>=1;$i--)
	{
	echo "<tr>";	
	echo "<td class='unborder center bold'>Round $i</td><td class='unborder'></td>";
	
		for($j=1;$j<=$num_game_player;$j++)
		{
		//select amount for each round
		$select_amount = "select sum(amount) from scoreboard where name='".$_SESSION["session_game_name"]."' and password='".$_SESSION["session_game_password"]."' and ordering='$j' and round='$i'";
		$result_amount = mysql_query($select_amount);
		$data_amount = mysql_fetch_row($result_amount);		
			//mark red for negative amount
			if($data_amount[0]<0)
			{$red = "red";}
			else
			{$red = "";}		
		echo "<td class='right unborder $red'>
				".number_format($data_amount[0],0,".",",")."
			  </td>";			  
		}
	//clear button
	echo "<td class='unborder'>
			<input type='button' value='X' onclick=\"delete_round('$i')\">
		  </td>";	
	echo "</tr>";
	}
	echo "<input type='hidden' name='delete_round_number'>";
	
	//bottom line
	echo "<tr>
			<td class='upperline'></td>
			<td class='upperline'></td>";
		for($j=1;$j<=$num_game_player;$j++)
		{echo "<td class='upperline'></td>";}
	echo "</tr>";	
	
	//button
	echo "<tr>
			<td class='unborder' colspan='$max_player'>
				<input type='button' value='Clear' onclick=\"save_function('c')\">
				<input type='button' value='New Game' onclick=\"save_function('n')\">
				<input type='button' value='Purge Data' onclick=\"save_function('d')\">
			</td>
		  </tr>";	
	
	//game setting
		if(empty($_GET["amount_check"]) || !empty($_GET["score_mode"]))
		{$amount_checked = "";}
		else
		{$amount_checked = "checked";}
	echo "<tr>
			<td class='unborder middle' colspan='$max_player'>
				<input type='checkbox' name='amount_check' $amount_checked>Amount auto check (Sum must equal to 0 for each round)
			</td>
		  </tr>";
		  
		if(empty($_GET["score_mode"]))
		{$score_mode_checked = "";}
		else
		{$score_mode_checked = "checked";}
	echo "<tr>
			<td class='unborder middle' colspan='$max_player'>
				<input type='checkbox' name='score_mode' onchange='submit()' $score_mode_checked>Score Mode (Winning record only)
			</td>
		  </tr>";	
		  
	//Game update & Create Time
		//select amount for each round
		$select_update = "select amount from scoreboard where name='".$_SESSION["session_game_name"]."' and password='".$_SESSION["session_game_password"]."' and player='update' and ordering=100 and round=0";
		$result_update = mysql_query($select_update);
		$data_update = mysql_fetch_row($result_update);
		//select amount for each round
		$select_start = "select amount from scoreboard where name='".$_SESSION["session_game_name"]."' and password='".$_SESSION["session_game_password"]."' and player='start' and ordering=0 and round=0";
		$result_start = mysql_query($select_start);
		$data_start = mysql_fetch_row($result_start);		
	echo "<tr>
			<td class='unborder bold small' colspan=2>
				<br>Last Update
				<br>Game Create
			</td>
			<td class='unborder small' colspan='$max_player'>
				<br>".date("Y-m-d h:i:s",$data_update[0])."
				<br>".date("Y-m-d h:i:s",$data_start[0])."
			</td>
		  </tr>";
		  
	echo "</table>";
}
echo "</form>";
?>
</body>
</html>

<script language="JavaScript">
	function player_update(){
        document.scoreboard.player_edit.value = "y";
        document.scoreboard.save_type.value = "u";
		document.scoreboard.submit();
	}

	function add_player(x){
	var y = document.scoreboard.max_player_number.value;
	var z = x-y;
		if(z>0)
		{alert('Maximum players : ' + y);}
		else
		{
        document.scoreboard.player_number.value = x;
		document.scoreboard.submit();
		}
	}
	
	function player_set(){
        document.scoreboard.start_game.value = "y";
		document.scoreboard.submit();
	}
	
	function save_function(x){
		if(x == "c")
		{
			if(confirm("Confirm to clear all data\n(Player\'s name will be reserved)"))
			{
			document.scoreboard.save_type.value = x;
			document.scoreboard.submit();
			}
		}
		else if(x == "n")
		{
			if(confirm("Confirm to start a new game and set new players\n(Old data will be reserved)"))
			{
			document.scoreboard.save_type.value = x;
			document.scoreboard.submit();
			}
		}
		else if(x == "d")
		{
			if(confirm("Confirm to delete all data from database"))
			{
			document.scoreboard.save_type.value = x;
			document.scoreboard.submit();
			}
		}				
		else
		{
        document.scoreboard.save_type.value = x;
		document.scoreboard.submit();
		}
	}
	
	function delete_round(x){
		if(confirm("Confirm to delete round "+ x +" record"))
		{	
        document.scoreboard.delete_round_number.value = x;
		document.scoreboard.submit();
		}
	}	
	
	
	
</script>
