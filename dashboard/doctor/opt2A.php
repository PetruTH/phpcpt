<?php
require('../fpdf185/fpdf.php');

session_start();
include "../dbconnection.php";


if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['diagnostic']) && isset($_POST['tratament'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $diagnostic = validate($_POST['diagnostic']);
    $doctor = $_SESSION['nume'];
    $ora = $_SESSION['ora_opt2'];
    $dataopt2 = $_SESSION['data_opt2'];
    $nume_pac = $_SESSION['nume_pacient_opt2'];
    $tratament = validate($_POST['tratament']);


    class PDF extends FPDF
    {
        function Header(){
            global $title;

            $this->SetFont('Arial','B',15);
            $w = $this->GetStringWidth($title)+6;
            $this->SetX((210-$w)/2);

            $this->SetDrawColor(0,80,180);
            $this->SetFillColor(230,230,0);
            $this->SetTextColor(220,50,50);

            $this->SetLineWidth(1);

            $this->Cell($w,9,$title,1,1,'C',true);

            $this->Ln(10);
    }

        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->SetTextColor(128);
            $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
        }

        function Diag($num, $label){
            $this->SetFont('Arial','',12);
            $this->SetFillColor(200,220,255);
            $this->Cell(0,6,"Diagnostic : $label",0,1,'L',true);
            $this->Ln(4);
        }

        function PrintChapterDiag($num, $title, $x){
            $this->AddPage();
            $this->Diag($num,$title);
            $this->ChapterBody($x);
        }

        function ChapterBody($x){
            $txt = $x;
            $this->SetFont('Times','',12);
            $this->MultiCell(0,5,$txt);
            $this->Ln();
            $this->SetFont('','I');
            $this->Cell(0,5,'');
        }

        function Reteta($num, $label){
            $this->SetFont('Arial','',12);
            $this->SetFillColor(200,220,255);
            $this->Cell(0,6,"Reteta : $label",0,1,'L',true);
            $this->Ln(4);
        }

        function PrintChapterRet($num, $title, $x){
            $this->AddPage();
            $this->Reteta($num,$title);
            $this->ChapterBody($x);
        }
    }


    if(empty($diagnostic)){
        $_SESSION['ans'] = 'Completeaza diagnosticul pacientului examinat!';
        header("Location: homeDOCTOR.php");
        exit();
    }else if (empty($tratament)) {
        $_SESSION['ans'] = 'Completeaza tratamentul pacientului examinat!';
        header("Location: homeDOCTOR.php");
        exit();
    }else{
        $ceva = $diagnostic . " " . $ora . " " . $dataopt2 . " " . $nume_pac; 

        $pdf = new PDF();
        $title = 'Buletin medical pentru pacientul ' . $nume_pac;
        $pdf->SetTitle($title);
        $pdf->SetAuthor('Eliberat de ' . $doctor . 'in urma examinarii pacientul ' . $nume_pac . " examinat la data de " . $dataopt2 . " ora " . $ora);
        $pdf->PrintChapterDiag(1,'', $diagnostic);
        $pdf->PrintChapterRet(2,'', $tratament);
        $pdf->Output();
        
    }
}
