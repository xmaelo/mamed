<?php
include('is_logged.php');
include('is_medecin.php');

require_once ('compo/vendor/autoload.php');
use \Statickidz\GoogleTranslate;
$active_patients="navbarElogeXmaelactive";
$title="MaMED | Patients";
$medecinid = $_SESSION['medecinid'];

try{
    // Connexion a la base de donnees via le PDO
    $db = new PDO('mysql:host=localhost;dbname=mamed_db', 'mamed_db', 'admin#2018');

    // Les noms des champs seront en caractères minuscule
    $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

    // Les erreurs lanceront les exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $ex){
    echo 'Une erreur est survenue lors de la connexion à la base de données!!!';
    die();
}

if(isset($_SESSION['lang'])){
              $lage='langues/'.$_SESSION['lang'].'.php';
              
              require_once ($lage);
              }
              else{
                $_SESSION['lang']='Fr';
                 $lage='langues/'.$_SESSION['lang'].'.php';
              
              require_once ($lage);
              }
?>

<?php
require_once ('libraries/fpdf/fpdf.php');
require_once ("config/db.php");
require ("config/connexion.php");
require_once ("functions.php");

 $queryt = "SELECT * from clinique where 1";

                          $getData = mysqli_query($con, $queryt);

                          $result = mysqli_fetch_array($getData);

                          $logo = $result['logo'];


                          $nom_clinique = $result['nom_clinique'];
                          //$email = $result['email'];
                          $telephone = $result['telephone'];
                          $site_web = $result['site_web'];
                          $info_suplementaire = $result['info_suprementaire'];

                          if ($logo) {
                              $logo = $logo;
                          }

                          else {
                            $logo = 'img/1vgB.jpeg';
                          }




$userid = $_SESSION['idusers'];
//$email = $_SESSION['email'];
$idpersonne = $_SESSION['idpersonne'];

$queryt = $db->prepare("SELECT count(*) as medecin FROM
                                    `personne` personne
                                    INNER JOIN `medecin` medecin ON medecin.personne_idpersonne = personne.idpersonne
                                    INNER JOIN `patient_has_medecin` patient_has_medecin ON patient_has_medecin.medecin_idmedecin = $medecinid
                                WHERE
                                    personne.`idpersonne` = '$idpersonne' AND personne.lisible = true AND patient_has_medecin.approbation = 1
                                ");
$queryt->execute();
$medecint = $queryt->fetch(PDO::FETCH_OBJ);

if($medecint->medecin == 0) {

    header('Location: mespatients.php?clara=elle');

}


$query = $db->prepare("SELECT
                                    medecin.`idmedecin` AS medecin_id,
                                    personne.`nom` AS nom,
                                    personne.`prenom` AS prenom,
                                    personne.`sexe` AS sexe,
                                    personne.`idpersonne` AS personne_id,
                                    personne.`adresse` AS adresse,
                                    personne.`telephone1` AS telephone1,
                                    personne.`telephone2` AS telephone2
                                FROM
                                    `personne` personne
                                    INNER JOIN `medecin` medecin ON medecin.personne_idpersonne = personne.idpersonne
                                    INNER JOIN `patient_has_medecin` patient_has_medecin ON patient_has_medecin.medecin_idmedecin = $medecinid
                                WHERE
                                    personne.`idpersonne` = '$idpersonne' AND personne.lisible = true AND patient_has_medecin.approbation = 1
                                ");
$query->execute();
$medecin = $query->fetch(PDO::FETCH_OBJ);


// $requete = "SELECT * from patient_has_medecin where approbation = 1 AND medecin_idmedecin = $medecinid";

// $execut = $db->prepare($requete);
// $execut->execute();
// while ($result = $execut->fetch(PDO::FETCH_OBJ)) {
  
// var_dump($result->patient_idpatient);
// }
// die();

$select = $db->prepare("    SELECT DISTINCT 
                                    patient.`idpatient` AS patient_id,
                                    patient.`poids` AS poids,
                                    patient.`taille` AS taille,
                                    patient.`imc` AS imc,
                                    patient.`interpretation` AS interpretation,
                                    patient.`nom_contact_urgence` AS nom_contact_urgence,
                                    patient.`telephone_contact_urgence` AS telephone_contact_urgence,
                                    patient.`etat` AS etat,
                                    patient.`diabete_iddiabete` AS diabete_iddiabete,
                                    patient.`personne_idpersonne` AS personne_idpersonne,
                                    diabete.`iddiabete` AS diabete_id,
                                    diabete.`type` AS type_diabete,
                                    diabete.`description` AS description_diabete,
                                    personne.`idpersonne` AS personne_id,
                                    personne.`nom` AS nom,
                                    personne.`prenom` AS prenom,
                                    personne.`sexe` AS sexe,
                                    personne.`datenaiss` AS date_naissance,
                                    personne.`email` AS email
                                FROM
                                    `patient` patient
                                    INNER JOIN `diabete` diabete ON diabete.`iddiabete` = patient.`diabete_iddiabete`
                                    INNER JOIN `personne` personne ON personne.idpersonne = patient.personne_idpersonne
                                    INNER JOIN `patient_has_medecin` patient_has_medecin 
                                ON patient_has_medecin.patient_idpatient = patient.`idpatient`
                                AND patient_has_medecin.approbation = 1                                
                                AND patient.lisible = true
                                AND diabete.lisible = true
                                AND personne.lisible = true
                                AND patient_has_medecin.medecin_idmedecin = $medecin->medecin_id

                           /* SELECT patient.`idpatient` AS patient_id,
                                patient.`poids` AS poids,
                                patient.`taille` AS taille,
                                patient.`imc` AS imc,
                                patient.`interpretation` AS interpretation,
                                patient.`nom_contact_urgence` AS nom_contact_urgence,
                                patient.`telephone_contact_urgence` AS telephone_contact_urgence,
                                patient.`etat` AS etat,
                                patient.`diabete_iddiabete` AS diabete_iddiabete,
                                patient.`personne_idpersonne` AS personne_idpersonne,
                                diabete.`iddiabete` AS diabete_id,
                                diabete.`type` AS type_diabete,
                                diabete.`description` AS description_diabete,
                                personne.`idpersonne` AS personne_id,
                                personne.`nom` AS nom,
                                personne.`prenom` AS prenom,
                                personne.`sexe` AS sexe,
                                personne.`datenaiss` AS date_naissance,
                                personne.`email` AS email
                            FROM patient, personne, patient_has_medecin,diabete
                            where patient_has_medecin.approbation=1 
                            AND patient_has_medecin.medecin_idmedecin = $medecinid
                            AND patient.lisible = true
                            AND diabete.lisible = true
                            AND personne.lisible = true
                            AND diabete.iddiabete = patient.diabete_iddiabete
                            AND personne.idpersonne = patient.personne_idpersonne
                            AND patient_has_medecin.patient_idpatient = patient.personne_idpersonne
                                                    */
                        ");
$select->execute();

class PDF extends FPDF {
    // En-tête
    function Header() {
        global $logo;
        //Logo
        $this->Image($logo,80,5,50);
        //Arial bold 15
        $this->SetFont('Arial','B',15);

        $this->Cell(50);
        //saut de ligne
        $this->Ln(20);
        $this->Ln(5);
        $this->cell(0, 0, '', 1, 0, 'C');
    }

    function ChapterBody(){
        $this->SetFont('Times','',8);
        $this->Ln();
    }

    // Pied de page
    function Footer() {
        $this->setY(250);
        $this->setX(10);
        $this->ChapterBody('pied.txt');
        $this->Ln(3);
        $this->SetFont('Times','',8);
        //position à 1,5cm du bas
        $this->SetY(-10);
        //Arial italic 8
        $this->SetFont('Times','I',8);
        //Numéro de page
        $this->Cell(0,10,"MAMED CARE - By KTC CENTER     \n Page ".$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Instanciation de la classe dérivée
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
function entete_table($position_entete){
    global $lang;
    global $pdf;
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetDrawColor(183); // Couleur du fond
    $pdf->SetFillColor(221); // Couleur des filets
    $pdf->SetTextColor(0); // Couleur du texte
    $pdf->SetY($position_entete);
    $pdf->SetX(10);
    $pdf->Cell(7,8, utf8_decode('N°'), 1, 0, 'C', 1);
    $pdf->Cell(50,8, utf8_decode($lang['nom'].' & '. $lang['prenom']),1,0,'C',1);
    // $pdf->SetX(166); // 8 + 96
    $pdf->Cell(15,8,utf8_decode($lang['sexe']),1,0,'C',1);
    // $pdf->SetX(176); // 104 + 10
    $pdf->Cell(40,8,utf8_decode($lang['typeDeDiabete']),1,0,'C',1);
    $pdf->Cell(30,8,utf8_decode('IMC(Kg/m2)'),1,0,'C',1);
    $pdf->Cell(50,8,utf8_decode($lang['interpretation']),1,0,'C',1);
    $pdf->Ln(); // Retour à la ligne
}

$position_detail = 78;
$n = 1;

while ($data = $select->fetch(PDO::FETCH_OBJ)) {
    $pdf->SetFont('Arial','B',14);
    $pdf->Text(10,65, utf8_decode($lang['listeDePatientsSuivis']));
    //entete du tableau
    $position_entete = 70;
    entete_table($position_entete);

    $pdf->setFont('Times', '', 12);

    $pdf->SetY($position_detail);
    $pdf->SetX(10);
    $pdf->MultiCell(7,8,utf8_decode($n),1,'C');

    $pdf->SetY($position_detail);
    $pdf->SetX(17);
    $pdf->MultiCell(50,8, utf8_decode($data->nom.' '.$data->prenom),1,'L');

    $pdf->SetY($position_detail);
    $pdf->SetX(67);
    $pdf->MultiCell(15,8,utf8_decode($data->sexe),1,'R');

    $pdf->SetY($position_detail);
    $pdf->SetX(82);
    $pdf->MultiCell(40,8,utf8_decode($data->type_diabete),1,'R');

    $pdf->SetY($position_detail);
    $pdf->SetX(122);
    $pdf->MultiCell(30,8,utf8_decode($data->imc),1,'R');

    $pdf->SetY($position_detail);
    $pdf->SetX(152);
    $pdf->MultiCell(50,8,utf8_decode($data->interpretation),1,'R');

    $position_detail += 8;
    $n++;
}

$pdf->SetFont('Times','',12);
$pdf->Output();
?>