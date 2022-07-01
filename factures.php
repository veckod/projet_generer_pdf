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
        if(isset($_GET['uid'])){
            $uid = $_GET['uid'];
            $query = "SELECT * FROM utilisateur WHERE id='$uid'";
            $query2 = "SELECT * FROM facture WHERE id_utilisateur='$uid'";
            $query3 = "SELECT * FROM article,facture WHERE facture.id_utilisateur='$uid' AND facture.id_article=article.id_article";
            $result = $con->prepare($query);
            $result2 = $con->prepare($query2);
            $result3 = $con->prepare($query3);
            $result->execute();
            $result2->execute();
            $result3->execute();
            if($result->rowCount()!=0 || $result2->rowCount()!=0 || $result3->rowCount()!=0){
                $facture = $result2->fetch();
                $titre = $result3->fetch();
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
                    //$taille = strlen($titre);
                    $i=1;
                    $pdf->Cell(14,40,$i,0,0,'L');
                    $pdf->Cell(91,40,$titre['titre'],0,0,'L');
                    $pdf->Cell(33,40,$titre['prix'],0,0,'L');
                    $pdf->Cell(26,40,$titre['nb_articles'],0,0,'L');
                    $pdf->Cell(00,40,$titre['total'],0,0,'L');
                    //Line(float x1, float y1, float x2, float y2)
                    $pdf->Ln(5);
                    $pdf->Cell(180,40,"___________________________________________________________________________",0,0,'L');

                    $pdf->Ln(100);
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(160,40,"Sub Total:",0,0,'R');
                    $pdf->Cell(0,40,$titre['total'],0,0,'R');
                    $pdf->Ln(5);
                    
                    $pdf->Cell(150,40,"Tax:",0,0,'R');
                    $pdf->Cell(32,40,"0.00%",0,0,'R');
                    $pdf->Ln(5);
                    $pdf->Cell(183,40,"_____________________",0,0,'R');
                    $pdf->Ln(7);
                    $pdf->Cell(152,40,"Total:",0,0,'R');
                    $pdf->Cell(24,40,$titre['total'],0,0,'R');
                }   

            }
            else{
                echo "error";
            }
           // if($result2->rowCount()!=0){
              //  while($facture = $result2->fetch()){
                /*
                    $pdf->SetFont('Arial','B',14);
                    $pdf->Cell(0,115,$facture['num_facture'],0,0,'R');
                    $pdf->Cell(0,126,$facture['date_achat'],0,0,'R');
                    $pdf->Ln(80);
                    $pdf->SetFont('Arial','B',12);
                    $pdf->Cell(180,10,"SL.      Item Description                                                 Price                 Qty.                 Total",1,0,'L');
                    $pdf->Ln(1);
                    $i=0;
                    */
                   // while(){
                     //   $pdf->Cell(0,115,$facture['id_facture'],0,0,'R');
                    //}
             //   }
/*
            }
            else{
                echo "error";
            }
            */
        }
    

    $pdf->Output();
?>