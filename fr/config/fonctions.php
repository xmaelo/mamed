 <?php 

	function calcul_IMC($poids, $taille){

		return round(($poids/pow($taille/100, 2)), 1);
	}

	function interpretation_IMC($imc){
		$interpretation = "";
		if($imc < 16.5){

			$interpretation = "Dénutrition";

		}elseif($imc < 18.5 && $imc >=16.5){

			$interpretation = "Maigreur";

		}elseif($imc < 25 && $imc >= 18.5){

			$interpretation = "Corpulence normale";
		
		}elseif($imc < 30 && $imc >=25){

			$interpretation = "Surpoids";

		}elseif($imc < 35 && $imc >= 30){

			$interpretation = "Obésité modérée";

		}elseif($imc < 40 && $imc >= 35){

			$interpretation = "Obésité sévère";

		}elseif ($imc >= 40) {
			
			$interpretation = "Obésité morbide ou massive";
		}

		return $interpretation; 
	}
 ?>