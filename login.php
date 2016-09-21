<?php
	
	
	//võtab ja kopeerib faili sisu
	require ("../../config.php");



	
	//var_dump($_GET);
	//echo "<br>";
    var_dump($_POST);
	
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupBdayError = "";
    $signupGenderError = "";
	$signupCarPrefError ="";
	$signupEmail = "";
	$signupBday = "1995-02-25";
	$signupGender = "male";
	$signupCarPref_items = [];


	// kas epost oli olemas
	if (isset ($_POST ["signupEmail"])){
		
		if (empty ($_POST ["signupEmail"])){
			
			//oli email, kuigi see oli tühi
			$signupEmailError = "See väli on kohustuslik!";
			
		} else {
			
			//email on õige, salvestan väärtuse muutujasse
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	}


    if (isset ($_POST ["signupBday"])){

        if (empty ($_POST ["signupBday"])){

            // if bday wasnt set
            $signupBdayError = "See väli on kohustuslik!";

        }else{
			$signupBday = $_POST["signupBday"];
		}

    }
	
	
	
	if (isset ($_POST ["signupBday"])){

        if (empty ($_POST ["signupBday"])){

            // if bday wasnt set
            $signupBdayError = "See väli on kohustuslik!";

        }else{
			$signupBday = $_POST["signupBday"];
		}

    }





	if (isset ($_POST ["signupPassword"])){
		
		if (empty ($_POST ["signupPassword"])){
			
			//oli password, kuigi see oli tühi
			$signupPasswordError = "See väli on kohustuslik!";
			
		}else{
			// tean et oli parool ja see ei olnud tühi
			// vähemalt 8 sümbolit
			
			if (strlen($_POST["signupPassword"])< 8){
			$signupPasswordError = "Parool peab olema vähemalt	8 tähemärki pikk!";
			}
			
			
		}
		
	}
	
	if (isset ($_POST['signupGender'])){
		if (empty ($_POST['signupGender'])){
			$signupGenderError = 'See väli on kohustuslik!';
		} else {
			$signupGender = $_POST["signupGender"];
		}
	}


	if (isset($_POST['signupCarPref_items'])){
		if (!in_array("eucars", $_POST['signupCarPref_items']) && !in_array("uscars",$_POST['signupCarPref_items']) &&
				!in_array("japcars",$_POST['signupCarPref_items']) && !in_array("ruscars",$_POST['signupCarPref_items']) && !in_array("korcars",$_POST['signupCarPref_items'])){
			$signupCarPrefError = 'Vähemalt üks valik on kohustuslik!';
		} else {

			$signupCarPref_items = $_POST["signupCarPref_items"];
		}


	}






// tean et ühtegi viga ei olnud ja saan andmed salvestatud
	if (empty ($signupEmailError)&& empty($signupPasswordError) && isset ($_POST['signupPassword']) && isset ($_POST['signupEmail'])){
			echo "Salvestan...<br>";
			echo "E-mail: ".$signupEmail."<br>";	
			$password = hash("sha512", $_POST["signupPassword"]);
			echo "Password: ".$_POST["signupPassword"]."<br>";	
			echo "Hash: ".$password."<br>";
			
			
			// andmebaasiga ühendus
			
			$database = "if16_vladsuto_1";
			
			$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
			
			//käsk 
			$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
			
			echo $mysqli->error;
			
			// asendad küsimärgid väärtustega
			//iga muutuja kohta 1 täht, mis tüüpi muutuja on
			//s - string
			//i - integer
			//d - double/float
			$stmt->bind_param("ss", $signupEmail, $password);
			
			if($stmt->execute()){
				echo "Salvestamine õnnestus!";
			}else{
				echo "ERROR!".$stmt->error;
			}
	}


?>



<html>
<head>
		<title>Login page</title>

    <style>

        .redtext {

            color: red;
            font-weight: bold;

        }

        .table1  {border-collapse:collapse;border-spacing:0;}
        .table1 td{font-family:Arial, sans-serif;font-size:14px;padding:5px;border-style:none;overflow:hidden;word-break:normal;}
        .table1 .table1-style1{font-weight:bold;color:#f00b0b;vertical-align:top}
        .table1 .table1-style2{font-weight:bold}
        .table1 .table1-style3{font-weight:bold;color:#f00b0b}
        .table1 .table1-style4{text-align:right;vertical-align:top}
        .table1 .table1-style5{vertical-align:top}
        .table1 .table1-style6{font-weight:bold;vertical-align:top}

    </style>
</head>

<body>


        <!------ Эта форма для домашнего задания не нужна

		<h1>Logi sisse:</h1>
		
		<form method ="post">

			<label>E-post:</label><br>
			<input name = "loginEmail" type ="email" placeholder = "E-post">
			<br><br>
			
			<label>Parool:</label><br>
			<input name = "loginPassword" type ="password" placeholder = "Parool">
			<br><br>
			
			<input type ="submit" value = "Logi sisse">
		
		</form>------->
		
		
		<h1>Loo kasutaja:</h1>
		
		<form method ="post">
            <table class="table1">
                <tr>
                    <td class="table1-style2">E-post:<span class = 'redtext'>*</span></td>
                    <td class="table1-style5"><input name = "signupEmail" type ="email" value = "<?=$signupEmail;?>" placeholder = "E-post"></td>
                    <td class="table1-style3"><span class = 'redtext'><?=$signupEmailError;?></span></td>
                </tr>
                <tr>
                    <td class="table1-style2">Parool:<span class = 'redtext'>*</span></td>
                    <td class="table1-style5"><input name = "signupPassword" type ="password" placeholder = "Parool"></td>
                    <td class="table1-style3"><span class = 'redtext'><?=$signupPasswordError;?></span></td>
                </tr>
                <tr>
                    <td class="table1-style6">Sünnipäev:<span class = 'redtext'>*</span></td>
                    <td class="table1-style5"><input  name="signupBday" type ="date" min="1900-01-01" max = "<?=date('Y-m-d'); ?>" value = "<?=$signupBday;?>"></td>
                    <td class="table1-style1"><span class = 'redtext'><?=$signupBdayError;?></span></td>
                </tr>
                <tr>
                    <td class="table1-style6">Sugu:<span class = 'redtext'>*</span></td>
                    <td class="table1-style5">
					
						<?php if($signupGender == "male") { ?>
							<input type="radio" name="signupGender" value="male" checked> Mees<br>
						<?php } else { ?>
							<input type="radio" name="signupGender" value="male"> Mees<br>
						<?php } ?>
						
						<?php if($signupGender ==  "female") { ?>
							<input type="radio" name="signupGender" value="female" checked> Naine<br>
						<?php } else { ?>
							<input type="radio" name="signupGender" value="female"> Naine<br>
						<?php } ?>
						
						<?php if($signupGender ==  "unspecified") { ?>
							<input type="radio" name="signupGender" value="unspecified" checked> Ei soovi avaldada<br>
						<?php } else {?>
							<input type="radio" name="signupGender" value="unspecified"> Ei soovi avaldada<br>
						<?php } ?>
						

                    <td class="table1-style1"></td>
                </tr>
                <tr>
                    <td class="table1-style6">Autohuvid:<span class = 'redtext'>*</span></td>
                    <td class="table1-style5">

						<input type="hidden" name="signupCarPref_items[]"  value="">

						<?php if(in_array("eucars", $_POST['signupCarPref_items'])){?>
							<input type="checkbox" name="signupCarPref_items[]" value="eucars" checked> Euroopa autod<br>
						<?php } else { ?>
							<input type="checkbox" name="signupCarPref_items[]" value="eucars"> Euroopa autod<br>
						<?php } ?>

						<?php if(in_array("uscars", $_POST['signupCarPref_items'])){?>
							<input type="checkbox" name="signupCarPref_items[]" value="uscars" checked> Ameerika autod<br>
						<?php } else { ?>
							<input type="checkbox" name="signupCarPref_items[]" value="uscars"> Ameerika autod<br>
						<?php } ?>

						<?php if(in_array("japcars", $_POST['signupCarPref_items'])){?>
							<input type="checkbox" name="signupCarPref_items[]" value="japcars" checked> Jaapani autod<br>
						<?php } else { ?>
							<input type="checkbox" name="signupCarPref_items[]" value="japcars"> Jaapani autod<br>
						<?php } ?>

						<?php if(in_array("ruscars", $_POST['signupCarPref_items'])){?>
							<input type="checkbox" name="signupCarPref_items[]" value="ruscars" checked> Vene autod<br>
						<?php } else { ?>
							<input type="checkbox" name="signupCarPref_items[]" value="ruscars"> Vene autod<br>
						<?php } ?>

						<?php if(in_array("korcars", $_POST['signupCarPref_items'])){?>
							<input type="checkbox" name="signupCarPref_items[]" value="korcars" checked> Korea autod<br>
						<?php } else { ?>
							<input type="checkbox" name="signupCarPref_items[]" value="korcars"> Korea autod<br>
						<?php } ?>





                    <td class="table1-style1"><span class = 'redtext'><?=$signupCarPrefError;?></span></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="table1-style4"><input type ="submit" value = "Submit"></td>
                    <td></td>
                </tr>
            </table>
		</form>

</body>
</html>