<?php
if($_POST['amount']){
	$amount = $_POST['amount'];
}
else{
	$amount = 5;
}

?>
<form action="" method="post">
	Team 1 Score: <input type="number" name="team1outcome" value="<?php echo $_POST['team1outcome'];?>"><br>
	Team 2 Score: <input type="number" name="team2outcome" value="<?php echo $_POST['team2outcome'];?>">
	<br>
	<br>
	Rows: <input type="number" name="amount" value="<?php echo $amount;?>">
	<br>
	<br>
	Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Team 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Team 2
	<br>
	
	<?php
	for ($i = 1; $i <= $amount; $i++) {
		echo '<input type="text" name="name'.$i.'" value="'.$_POST['name'.$i].'"><input type="number" name="1team'.$i.'" value="'.$_POST['1team'.$i].'"><input type="number" name="2team'.$i.'" value="'.$_POST['2team'.$i].'"><br>';
	}
	?>
	<br>
	<input type="submit" value="Submit">
</form>

<?php
if($_POST){
	for ($i = 1; $i <= $amount; $i++) {
		if($_POST['name'.$i] && $_POST['1team'.$i] && $_POST['2team'.$i]){$team1[$_POST['name'.$i]] = $_POST['1team'.$i];$team2[$_POST['name'.$i]] = $_POST['2team'.$i];}
	}
	
	$team1Outcome = $_POST['team1outcome'];
	$team2Outcome = $_POST['team2outcome'];
}
?>

<?php
$r1 = 1;
for ($i = 1; $i <= count($team1)+10; $i++) {
	$desired = getClosest($team1Outcome, $team1);
	
	foreach ($team1 as $name => $value) {
		if($value == $desired){
			$team1Ranked[$name] = $r1;
			unset($team1[$name]);
		}
	}
	$r1++;
}

$r2 = 1;
for ($i = 1; $i <= count($team2)+10; $i++) {
	$desired = getClosest($team2Outcome, $team2);
	
	foreach ($team2 as $name => $value) {
		if($value == $desired){
			$team2Ranked[$name] = $r2;
			unset($team2[$name]);
		}
	}
	$r2++;
}

foreach ($team1Ranked as $name => $value1) {
	$value2 = $team2Ranked[$name];
	$totalRanked[$name] = $value2 + $value1;
}

foreach ($totalRanked as $key => $value) {
    if(isset($new_array[$value]))
    	$new_array[$value] += 1;
    else
    	$new_array[$value] = 1;
}

foreach ($totalRanked as $name => $value) {
	if($new_array[$value] > 1){
		$FinalRankings[$value] = $FinalRankings[$value].$name."-";
	}
	else{
		$FinalRankings[$value] = $name;
	}
}

foreach ($FinalRankings as $value => $names) {
	if(substr($names, -1) == "-"){
		$FinalRankings[$value] = substr($names, 0, -1);
	}
}

$i = 1;
foreach (array_flip($FinalRankings) as $names => $other) {
	$split = explode("-", $names);
	foreach ($split as &$name) {
		echo $i.". ".$name."<br>";
	}
	$i++;
}
?>


<?php
function getClosest($search, $arr) {
   $closest = null;
   foreach($arr as $item) {
      if($closest == null || abs($search - $closest) > abs($item - $search)) {
         $closest = $item;
      }
   }
   return $closest;
}
?>
