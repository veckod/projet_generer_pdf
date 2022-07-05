<?php
include_once 'fpdf/fpdf.php';

$pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',26);
    $pdf->Image('img/head.png',0,8,220);
    $pdf->Image('img/footer.png',0,270,220);
    $pdf->SetLeftMargin(17);
    $pdf->SetRightMargin(17);
    $pdf->Image('img/thanx.png',20,225,50);
    $pdf->SetFont('Arial','B',23);
    $pdf->Cell(80,100,'Invoice to: ');
    $pdf->Ln(1);
    $pdf->SetFont('Arial','B',20);
    

   
        $con = new PDO('mysql:host=localhost;dbname=bddfpdf;charset=utf8','root', '');
        //$con = new PDO('mysql:host=veckod.com;dbname=veckuwya_bddfpdf;charset=utf8','veckuwya_vick', 'AzErTyY20v');
        if(isset($_GET['uid'])){
            $uid = $_GET['uid'];
            $query = "SELECT * FROM utilisateur WHERE id='$uid'";
            $query2 = "SELECT * FROM facture WHERE id_utilisateur='$uid'";
            $query3 = "SELECT prix FROM article,facture WHERE facture.id_utilisateur='$uid' AND facture.id_article=article.id_article";
            $query4 = "SELECT titre FROM article,facture WHERE facture.id_utilisateur='$uid' AND facture.id_article=article.id_article";
            $query5 = "SELECT nb_articles FROM article,facture WHERE facture.id_utilisateur='$uid' AND facture.id_article=article.id_article";
            $query6 = "SELECT total FROM article,facture WHERE facture.id_utilisateur='$uid' AND facture.id_article=article.id_article";
            $result = $con->prepare($query);
            $result2 = $con->prepare($query2);
            $result3 = $con->prepare($query3);
            $result4 = $con->prepare($query4);
            $result5 = $con->prepare($query5);
            $result6 = $con->prepare($query6);
            $result->execute();
            $result2->execute();
            $result3->execute();
            $result4->execute();
            $result5->execute();
            $result6->execute();
            if($result->rowCount()!=0 || $result2->rowCount()!=0 || $result3->rowCount()!=0|| $result4->rowCount()!=0|| $result5->rowCount()!=0|| $result6->rowCount()!=0){
                $facture = $result2->fetch();
        
                while($utilisateur = $result->fetch()){
                    $pdf->SetTextColor(1,1,1);
                    $pdf->Cell(80,115,$utilisateur['nom'],0,0,'L');
                    $pdf->SetFont('Arial','B',14);
                    $pdf->Cell(0,115,"Invoice#",0,0,'C');
                    $pdf->SetFont('Arial','B',12);
                    $pdf->Ln(1);
                    $pdf->Cell(70,126,$utilisateur['adresse_rue'],0,0,'L');
                    //$pdf->Ln(1);
                    $pdf->SetFont('Arial','B',14);
                    $pdf->Cell(0,126,"Date",0,0,'C');
                    $pdf->SetFont('Arial','B',12);
                    $pdf->Ln(1);
                    $pdf->Cell(0,133,$utilisateur['cp_ville']);
                     
                    $pdf->SetFont('Arial','B',14);
                    $pdf->Cell(0,115,$facture['num_facture'],0,0,'R');
                    $pdf->Cell(0,126,$facture['date_achat'],0,0,'R');
                    $pdf->Ln(90);
                    $pdf->SetFont('Arial','B',12);
                    $pdf->Cell(180,10,"SL.      Item Description                                                 Price                 Qty.                 Total",1,0,'L');
                    $pdf->Ln(1);

                }
                
                $i=1;
                $totalAvantTax=0;
                $countLigne=6;
                $pdf->Ln(20);
                $pdf->SetRightMargin(10);
                $pdf->SetLeftMargin(17);

                while($titreArt = $result4->fetch()){ 
                    //apres 5 lignes d'article: ajoute une nouvelle page
                /*    if($i==$countLigne){
                        $pdf->AddPage();
                        $countLigne=$countLigne+6;    
                    } */         
                   $pdf->Cell(14,0,$i,0,0,'L');
                   $pdf->Cell(0,0,$titreArt['titre'],0,0,'L');
                   $pdf->Write(3,"____________________________________________________________________________");
                   $pdf->Ln(15);
                   $i++;
                } 

                $pdf->SetLeftMargin(122);
                $pdf->Sety(124);
                while($prixArt = $result3->fetch()){
                    $pdf->Cell(0,0,$prixArt['prix'],0,0,'L');
                    $pdf->Ln(18);
                   
                 }  
                 $pdf->SetLeftMargin(154);
                 $pdf->Sety(124);
                 while($nbArt = $result5->fetch()){
                    $pdf->Cell(0,0,$nbArt['nb_articles'],0,0,'L');
                    $pdf->Ln(18);
                 }  
                 $pdf->SetLeftMargin(180);
                 $pdf->Sety(124);
                 while($total = $result6->fetch()){
                    $pdf->Cell(0,0,$total['total'],0,0,'L');
                    $pdf->Ln(18);
                    $totalAvantTax=$totalAvantTax+$total['total'];
                 }     
                    $pdf->Sety(224);
                    $pdf->SetFont('Arial','B',14);
                    $pdf->SetRightMargin(40);
                    $pdf->SetLeftMargin(130);
                    $pdf->Write(3,'Sub Total:');
                    $pdf->SetRightMargin(0);
                    $pdf->SetLeftMargin(170);
                    $pdf->Write(3,$totalAvantTax);
                    $pdf->SetRightMargin(40);
                    $pdf->SetLeftMargin(130);
                    $pdf->Ln(6);
                    $pdf->Write(3,'Tax:');
                    $pdf->SetRightMargin(0);
                    $pdf->SetLeftMargin(170);
                    $pdf->Write(3,'21%');
                    $pdf->Sety(236);
                    $pdf->SetRightMargin(0);
                    $pdf->SetLeftMargin(130);
                    $pdf->Write(3,'___________________');
                    $pdf->Ln(6);
                    $pdf->Write(3,'Total:');
                    $pdf->SetRightMargin(0);
                    $pdf->SetLeftMargin(170);
                    $taxe=($totalAvantTax/100)*21;
                    $totalApresTax = $totalAvantTax+$taxe;
                    $pdf->Write(3,$totalApresTax);
                 
            }
            else{
                echo "error";
            }
           
        }
    

    $pdf->Output();
?>