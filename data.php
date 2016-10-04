<?php 
	
	
	require("functions.php");
	
	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location: login.php");
		
	}
	
	//kui on ?logout aadressireal siis login välja
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		
	}
	
	$autonumber="";
	$msg = "";
	if(isset($_SESSION["message"])) {
		
		$msg = $_SESSION["message"];
		
		//kustutan ära, et pärast ei näitaks
		unset($_SESSION["message"]);
	}
	
	if (isset($_POST["autonumber"]) &&
		(isset($_POST["autonumber"]) &&
		!empty($_POST["autovarv"]) &&
		!empty($_POST["autovarv"])
		)) {
			
			saveCar($_POST["autonumber"], $_POST["autovarv"]);
		}
		
		
		
		//saan kõik autode andmed
		$carData=getAllCars();
		
		echo"<pre>";
		var_dump($carData);
		echo"</pre>";
		
		
?>


<html>
<head>
<title>Auto sisestamine</title>
</head>
<body bgcolor="#ffcccc">


<h1>Data</h1>



<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>
</p>

<h2> Salvesta auto </h2>


	<form method=POST>
   


		<input name="autonumber" placeholder="auto number" type="text" value="<?=$autonumber;?>"> 

	<br><br>


		<input name="autovarv" placeholder="auto värv" type="color"> 

	<br>

		<input type="submit" value="Salvesta">
	<br><br>
	
	</form>
	
	
	<h2>Autod</h2>
	
	<?php
	
	$html = "<table>";
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>plate</th>";
		$html .= "<th>color</th>";
	$html .= "</tr>";
	
	
	//iga liikme kohta massiivis
	foreach($carData as $c) {
		//iga auto on $c
		//echo $c->plate."<br>";
	
		
		$html .= "<tr>";
			$html .= "<td>".$c->id."</td>";
			$html .= "<td>".$c->plate."</td>";
			$html .= "<td style='background-color:".$c->color."'>".$c->color."</td>";
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	
	echo $html;
	
	$listHtml="<br><br>";
	
	
	foreach($carData as $c) {
		
		$listHtml .= "<h1 style='color:".$c->color."'>".$c->plate."</h1>";
		$listHtml .="<p>color = ".$c->color."</p>";
	}
	
	echo $listHtml;
	?>
	
	
	
	
	
	
	
	
	





</body>
</html>



