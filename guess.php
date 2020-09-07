<html lang="en">
<head>
  <title>  maryanne mare 9722c0e8</title>
  <meta charset="UTF-8"content="hello there, this si a laptop ad">
</head>
<body>
<h1> welcome to my guessing game </h1>
<?php
$correctnumber= 14;
if(isset($_GET['guess']))
{
	if(is_numeric($_GET['guess'])===FALSE)
echo "your guess is not a number";
}
  else if ($_GET['guess']<$correctnumber) {
	echo "your guess is too low";
	# code...
}
elseif ($_GET['guess']>$correctnumber) {
	# code...
	echo "your guess is too high";
}
elseif ($_GET['guess']==$correctnumber) {
	# code...
	echo "congratulations - you are right";
}
else{
	echo "missing guess parameter <br> your guess is too short";
}
?>
</body>
</html>