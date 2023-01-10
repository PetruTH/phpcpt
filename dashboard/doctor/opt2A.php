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

        function CreateTable(){
            global $diagnostic;
            global $tratament;

            $this->SetY(92);
            $this->Cell(260, 70, "", 1, 0);

            $this->SetFont('Arial', 'B', 15);
            $this->SetTextColor(0);

            $this->SetY(92);
            $this->Cell(130, 25, "Diagnostic rezultat", 1, 0, 'C');
            $this->Cell(130, 25, "Tratament recomandat", 1, 0, 'C');

            $this->SetFont('Arial', 'B', 15);
            $this->SetTextColor(0);


            $this->SetY(117);
            $this->cell(130, 45, $diagnostic, 1);
            $this->SetY(117);
            $this->SetX(145);
            $this->cell(130, 45, $tratament, 1);
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
        $pdf = new PDF('L', 'mm', array(210, 298));
        $pdf->AliasNbPages();
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        $pdf->detalii_programare();
        $pdf->detalii_client();
        $pdf->CreateTable();
        $pdf->Output();
    }
}
