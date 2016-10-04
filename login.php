<?php

require("../../config.php");
require("functions.php");

//kui on juba sisse loginud siis suuna data lehele
if(isset($_SESSION["userID"])){
	//suunan sissselogimise lehele
	header("Location: data.php");
	
}

#veebirakendus peaks aitama arvet pidada, milliseid toataimi on vaja millal kasta/väetada


    //CREATE TABLE user_sample (
    //id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    //email VARCHAR(255) NOT NULL,
    //password VARCHAR(128),
    //created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    //UNIQUE(email)
    //);

	//mysql> INSERT INTO user_sample (email,password)VALUES(....,....)



//echo hash("whirlpool", "Mariam"); //r2si


	//var_dump(5);#näitab pikkus, väärtust, tüüpi
	
	//MUUTUJAD
	$signupEmailError = "";
	$signupPasswordError = "";
	$registerEmailError = "";
	$registerPasswordError ="";
	$personalError="";
	
	$regiterEmail = "";	
	$signupGender = "";
	
if( isset($_POST["signupGender"] )){

	

		if( !empty($_POST["signupGender"])) {

			$signupGender = $_POST["signupGender"];
			
		



			}
	}

	if( isset($_POST["signupEmail"] )){

	

		if( empty($_POST["signupEmail"])) {

			$signupEmailError = "see väli on kohustuslik";
			
		}else{
			
			//email olemas
			$signupEmail=$_POST["signupEmail"];



			}
	}



	if( isset($_POST["signupPassword"])) {

		if( empty($_POST["signupPassword"])) {

			$signupPasswordError = "see väli on kohustuslik";
		}else{
		//Siia jõuan siis, kui parool oli olemas ja parool ei olnud tühi. !ELSE!
			if(strlen($_POST["signupPassword"])<8) {

				$signupPasswordError = "Parool peab olema vähemalt 8 märki pikk";
			}




	}
	}

	if( isset($_POST["registerEmail"] )){

		

		if( empty($_POST["registerEmail"])) {

			$registerEmailError = "e-mail on kohustuslik";



		} else {
			
			//email olemas
			$registerEmail = $_POST["registerEmail"];
		}
	}



if( isset($_POST["registerPassword"] )){

		

		if( empty($_POST["registerPassword"])) {

			$registerPasswordError = "parool on kohustuslik";
			
			
		} else {

             if(strlen($_POST["registerPassword"])<8) {

				$registerPasswordError = "Parool peab olema vähemalt 8 märki pikk";
			}

		}
	}

	if(isset($POST["personal"])){
		
		if(empty($POST["personal"])) {
		
		$personalError = "Kirjuta midagi enda kohta";
		
	}}
	
	
	
	// peab olema email ja parool
	//ühtegi errorit
	
	if($registerEmailError == "" && empty ($registerPasswordError) && isset($_POST["registerEmail"])
			&& isset($_POST["registerPassword"]))  {
			
	
		
		//salvestame andmebaasi
		
		echo "Salvestan...<br>";
		
		echo "email : ".$_POST["registerEmail"]."<br>";
		echo "password: ".$_POST["registerPassword"]."<br>";
		
		$password = hash("whirlpool", $_POST["registerPassword"]);
		
		echo "password hashed: ".$password."<br>";  
		
		//KASUTAN FUNKTSIOONI
		signUp($registerEmail, $password);
		
		
		//salvestame andmebaasi
			
			//YHENDUS	
			
			$database = "if16_mreintop";
		$mysqli = new mysqli ($serverHost, $serverUsername, $serverPassword, $database);
		
		
		//MYSQL rida
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample(email, password) VALUES (?,?)");
		
		//stringina 1 t2ht iga muutuja kohta , mis tyyp
		// string - s   (date, varchar)
		// integer - i   (t2isarv)
		// float (double) - d  (komakohaga arv)
		//kysim2rgid asendada muutujaga
		
		$stmt->bind_param("ss", $_POST["registerEmail"], $password);
		//t2ida k2sku
		//$stmt->execute();
		
		echo $mysqli->error;

		if($stmt->execute())  {
			
			echo "salvestamine 6nnestus";
			
		
		} else {
			echo "ERROR".$stmt->error;
			
		}
	
	}
	
	//panen yhenduse kinni

	
	//echo $serverUsername;
	var_dump($_POST);
	$error ="";
	if( isset($_POST["signupEmail"]) && isset($_POST["signupPassword"])&&
			!empty($_POST["signupEmail"]) && !empty($_POST["signupPassword"])
			){
				
				$error = login($_POST["signupEmail"], $_POST["signupPassword"]);
			}
	
	
?>


<!DOCTYPE html>
<html>
<head>
<title>´Logi sisse või loo kasutaja</title>
</head>
<body bgcolor="#ffcccc">

<h1>Logi sisse</h1>



	<form method=POST>
<?php echo $error;  ?>


		<input name="signupEmail" placeholder="e-mail" type="text" value="<?=$signupEmail;?>"> <?php echo $signupEmailError;  ?>

	<br><br>


		<input name="signupPassword" placeholder="parool" type="password"> <?php echo $signupPasswordError; ?>

	<br>

		<input type="submit" value="Logi sisse">
	<br><br>




	</form>

	
	<h2>Loo kasutaja</h2>

	<?php echo $registerEmailError;?>
	<?php echo $registerPasswordError;?>
	<?php echo $personalError;?>
	

	<form method=post>

	<input type=text  name=registerEmail  placeholder="Sisesta meiliaadress" > <br><br>
	
	

	<input type=password name=registerPassword  placeholder="Vali parool" > <br><br>
	
	
	
	
	
	<?php if($signupGender == "male") {
		?><input type=radio name=signupGender value=male checked>Mees
	<?php }else{ ?>
	<input type=radio name=signupGender value=male >Mees
	<?php } ?>
	
	<?php if($signupGender == "naine") {
		?><input type=radio name=signupGender value=naine checked>Naine
	<?php }else{ ?>
	<input type=radio name=signupGender value=naine >Naine
	<?php }?>
	
	<?php if($signupGender == "other") {
		?><input type=radio name=signupGender value=other checked>Other
	<?php }else{ ?>
	<input type=radio name=signupGender value=other >Other
	<?php }?>

	
	
	<br><br>
	 Kirjuta enda kohta midagi huvitavat<br>
	<input type=text name=personal placeholder="Kirjuta midagi enda kohta" size=50> <br><br>
	
    
	
	
	<input type="submit" value="Kinnitan">



	</form>
	

	


	



</body>
</html>


