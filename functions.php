<?php

require("../../config.php");
	// functions.php
	//var_dump($GLOBALS);
	
	// see fail, peab olema kıigil lehtedel kus 
	// tahan kasutada SESSION muutujat
	session_start();
	
	//***************
	//**** SIGNUP ***
	//***************
	
	function signUp ($email, $password) {
		
		$database = "if16_mreintop";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);
		
		if($stmt->execute()) {
			echo "salvestamine ınnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
	function login ($email, $password) {
		
		$error = "";
		echo $email;
		
		$database = "if16_mreintop";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("
		SELECT id, email, password, created 
		FROM user_sample
		WHERE email = ?");
	
		echo $mysqli->error;
		
		//asendan k¸sim‰rgi
		$stmt->bind_param("s", $email);
		
		//m‰‰ran v‰‰rtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//andmed tulid andmebaasist vıi mitte
		// on tıene kui on v‰hemalt ¸ks vaste
		if($stmt->fetch()){
			
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("whirlpool", $password);
			if ($hash == $passwordFromDb) {
				
				echo "Kasutaja logis sisse ".$id;
				
				//m‰‰ran sessiooni muutujad, millele saan ligi
				// teistelt lehtedelt
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				
				header("Location: data.php");
				
			}else {
				$error = "vale parool";
			}
			
			
		} else {
			
			// ei leidnud kasutajat selle meiliga
			$error = "ei ole sellist emaili";
		}
		
		return $error;
		
	}
	
	
	function saveCar ($autonumber, $autovarv) {
		
		
		
		$database = "if16_mreintop";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare(
		"INSERT INTO autod (autonumber, autovarv) VALUES (?,?)");
		
		echo $mysqli->error;
		
		
		
		//asendan k¸sim‰rgi
		$stmt->bind_param("ss", $autonumber,$autovarv);
		
		if ( $stmt->execute() )  {
			
			echo "salvestamine ınnestus";
			
		}  else  {
			
			echo "ERROR".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	
	function getAllCars () {
		
		
		//see on igal funktsioonil
		$database = "if16_mreintop";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		
		$stmt = $mysqli->prepare("
		
		  SELECT id, autonumber,autovarv FROM autod
		 
		");
		echo $mysqli->error;
		
		
		$stmt -> bind_result ($id, $autonumber,$autovarv) ;
		$stmt ->execute();
		
		//tekitan massiivi
		
		$result=array();
		
		//Tee seda seni, kuni on rida andmeid. ($stmt->fech)
		//Mis vastab select lausele.
		//iga uue rea andme kohta see lause seal sees
		
		while($stmt->fetch()){
			
			//tekitan objekti
			
			$car = new StdClass();
			
		    $car->id=$id;
			$car->plate=$autonumber;
			$car->color=$autovarv;
			
			//echo $autonumber."<br>";
			
			array_push($result, $car);
		}
		$stmt->close();
		$mysqli->close();
		return $result;
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	/*function sum($x, $y) {
		
		return $x + $y;
		
	}
	
	
	function hello($firsname, $lastname) {
		
		return "Tere tulemast ".$firsname." ".$lastname."!";
		
	}
	
	
	*/
?>