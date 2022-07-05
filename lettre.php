<?php
include_once 'fpdf/fpdf.php';

//functions


$pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',26);
    $pdf->Image('img/ligne.png',5,0,10);
    $pdf->Image('img/footerKinepolis.png',0,260,213);
    $pdf->Image('img/signature.png',20,220,60);
    $pdf->Ln(1);
   
    
    
   
    $con = new PDO('mysql:host=localhost;dbname=bddfpdf;charset=utf8','root', '');
  //$con = new PDO('mysql:host=veckod.com;dbname=veckuwya_bddfpdf;charset=utf8','veckuwya_vick', 'AzErTyY20v');
    if(isset($_POST['nomUser']) && isset($_POST['textUser'])){
        $nomUser = $_POST['nomUser'];
        $text = $_POST['textUser'];
        $anneeCourante = (new \DateTime())->format('Y'); 
        $moisCourante = (new \DateTime())->format('m');
        $jourCourant = (new \DateTime())->format('d');
        $month0 = ltrim($moisCourante);
        //$month = array(01 => "janvier",02 => "fevrier",03 => "mars",04 => "avril",05 =>"mai",06 =>"juin",07 =>"juillet",08 =>"aout",09 =>"septembre",10 =>"octobre",11 =>"novembre",12 =>"decembre");
        $monthStr;
        
        if($moisCourante ==01){
            $monthStr = "janvier";
        }
        if($moisCourante ==02){
            $monthStr = "fevrier";
        }
        if($moisCourante ==03){
            $monthStr = "mars";
        }
        if($moisCourante ==04){
            $monthStr = "avril";
        }
        if($moisCourante ==05){
            $monthStr = "mai";
        }
        if($moisCourante ==06){
            $monthStr = "juin";
        }
        if(strval($moisCourante) =="07"){
            $monthStr = "juillet";
        }
        if(strval($moisCourante) =='08'){
            $monthStr = "aout";
        }
        if(strval($moisCourante) =='09'){
            $monthStr = "septembre";
        }
        if($moisCourante ==10){
            $monthStr = "octobre";
        }
        if($moisCourante ==11){
            $monthStr = "novembre";
        }
        if($moisCourante ==12){
            $monthStr = "decembre";
        }


        $query = "SELECT * FROM utilisateur WHERE nom='$nomUser'";
        $result = $con->prepare($query);
        $result->execute();
        if($result->rowCount()!=0){
            while($utilisateur = $result->fetch()){
                $pdf->Ln(20);
                $pdf->SetLeftMargin(120);
                $pdf->SetRightMargin(10);
                $pdf->SetTextColor(1,1,1);
                    $pdf->Cell(0,0,$utilisateur['nom'],0,0,'L');
                    $pdf->SetFont('Arial','B',14);
                    $pdf->SetFont('Arial','B',12);
                    $pdf->Ln(7);
                    $pdf->Cell(0,0,$utilisateur['adresse_rue'],0,0,'L');
                    //$pdf->Ln(1);
                    $pdf->SetFont('Arial','B',14);
                    $pdf->SetFont('Arial','B',12);
                    $pdf->Ln(6);
                    $pdf->Cell(0,0,$utilisateur['cp_ville']);
                    $pdf->Ln(25);
                    $pdf->SetLeftMargin(140);
                    $pdf->SetRightMargin(10);
                    $pdf->Cell(0,0,$jourCourant." ".$monthStr." ".$anneeCourante);
                    $pdf->Ln(10);
                    $pdf->SetLeftMargin(25);
                    $pdf->SetRightMargin(25);
                    $pdf->Write(8,$text);
                    

            }
        }
    
        else{
            echo "error";
        }
    }
    
    $pdf->Output();
?>

