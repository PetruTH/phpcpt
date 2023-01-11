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

    class PDF extends FPDF {

        function Header() {
            $this->SetTextColor(102, 255, 153);
            $this->SetFont('Arial', 'B', 28);
            $this->Cell(134, 12,'Clinica DAW');
            
            $image = "poza.jpg";
            $this->Cell( 30, 30, $this->Image($image, 75, $this->GetY()-6, 30), 0, 0, 'L', false );

            $this->SetFont('Arial', 'B', 35);
            $this->SetTextColor(0);
            $this->setX(165);
            $this->Cell(118, 12,'Rezultat consultatie');
            $this->Ln(18);
            $this->Ln();
        }

        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }

        function detalii_programare() {
            global $doctor;
            global $ora;
            global $dataopt2;
            global $nume_pac;

            $this->Ln();
            $this->Ln();
            
            $this->SetFont('Arial', '', 12);
            $this->SetTextColor(0);
            $this->SetY(30);

            $this->Cell(134, 6,'Doctor: ' . $doctor);
            $this->Ln();
            $this->Ln();

            $this->Cell(134, 6,'Data: ' . $dataopt2);
            $this->Ln();
            $this->Ln();

            $this->Cell(134, 6,'Ora: ' . $ora);
            $this->Ln();

        }

        function detalii_client(){
            global $nume_pac;
            
            $this->Ln();
            $this->Ln();

            $this->SetFont('Arial', 'B', 17);
            $this->SetTextColor(0);

            $this->SetY(30);
            $this->SetX(165);
            $this->Cell(118, 6, "Pacient:");
            $this->Ln();

            $this->SetFont('Arial', '', 12);

            $this->SetX(165);
            $this->Cell(118, 6, 'Nume: ' . $nume_pac);
            $this->Ln();
        }

       
        function FancyTable()
        {
            
            $this->SetY(83);
            $this->SetX(50);
            $header = array("Diagnostic", "tratament");
            $w = array(100,100);

            for($i=0;$i<count($header);$i++)
                $this->Cell($w[$i],7,$header[$i],1,0,'C');
            $this->Ln();
        
            global $diagnostic;
            global $tratament;

            $height = 90;
            
            $datatr = array();
            $datatr = explode("\n", $tratament);
            
            $datadi = array();
            $datadi = explode("\n", $diagnostic);
            
            $length = max(count($datadi), count($datatr));
            $datadi = array_pad($datadi, $length, '');
            $datatr = array_pad($datatr, $length, '');
            
            $this->SetY(90);
            $this->SetX(50);


            for($i=0; $i < count($datatr); $i=$i+1){
                $this->SetY($height);
                $this->SetX(50);
                $this->Multicell($w[0], 5, $datadi[$i], 1);
                
                $this->SetY($height);
                $this->SetX(150);
                $this->Multicell($w[1], 5, $datatr[$i], 1);
                
                
                $height = $height + 5;
            }
        }
    }

    $datatr = array();
    $datatr = explode("\n", $tratament);
        
    $datadi = array();
    $datadi = explode("\n", $diagnostic);
            
    $length = max(count($datadi), count($datatr));
    $datadi = array_pad($datadi, $length, '');
    $datatr = array_pad($datatr, $length, '');

    if(empty($diagnostic)){
        $_SESSION['ans'] = 'Completeaza diagnosticul pacientului examinat!';
        header("Location: homeDOCTOR.php");
        exit();
    }else if (empty($tratament)) {
        $_SESSION['ans'] = 'Completeaza tratamentul pacientului examinat!';
        header("Location: homeDOCTOR.php");
        exit();
    }else if($length > 11){
        $_SESSION['ans'] = 'Ati introdus prea multe date!';
        header("Location: homeDOCTOR.php");
        exit();
    }else{
        $pdf = new PDF('L', 'mm', array(210, 298));
        $pdf->AliasNbPages();
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        $pdf->detalii_programare();
        $pdf->detalii_client();
        $pdf->FancyTable();
        $pdf->Output();
    }
}
