<?php

session_start();

include "../db_conn.php";
include "func-admin.php";
include "func-user.php";

if (isset($_SESSION['user_id'])){
    
    $adminid = $_SESSION['user_id'];
    $admin = get_admin($conn, $adminid); 
    $name = $admin['name'];
    $email = $admin['email'];

} else if (isset($_SESSION['user2_id'])) {
        
    $userid = $_SESSION['user2_id'];
    $user = get_user($conn, $userid); 
    $name = $user['name'];
    $email = $user['email'];

}
    
if (!empty($name) && !empty($email)){

    $roomname = $_POST['roomname'];
    $roomcategory = $_POST['roomcategory'];
    $checkin = $_POST['checkin'];   
    $checkout = $_POST['checkout'];
    $roomprice = $_POST['roomprice'];

    require('../fpdf185/fpdf.php');

    class PDF extends FPDF {

        function Header() {
            $this->SetFont('Arial', 'B', 28);
            $this->SetTextColor(0);
            $this->Cell(134, 12,'Hotel Royal');

            $this->SetFont('Arial', 'B', 28);
            $this->SetTextColor(0);
            $this->setX(165);
            $this->Cell(118, 12,'Factura');
            $this->Ln(18);
            $this->Ln();
        }

        function Footer() {
            $this->SetY(-35);
            $this->SetFont('Arial','I', 8);
            $this->Cell(0,10,'Factura emisa la data ' . date('Y-m-d'),0,0,'C');

            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }

        function detalii_hotel() {
            $this->Ln();
            $this->Ln();
            
            $this->SetFont('Arial', '', 12);
            $this->SetTextColor(0);
            $this->SetY(30);

            $this->Cell(134, 6,'SC Hotel Royal SRL');
            $this->Ln();

            $this->Cell(134, 6,'CIF: RO19567329');
            $this->Ln();

            $this->Cell(134, 6,'Adresa: Hotel Avenue, St. Lt. Gheorghe Iacob 2, Buzau 100020');
            $this->Ln();

            $this->Cell(134, 6,'Telefon: +40 769 850 655');
            $this->Ln();

            $this->Cell(134, 6,'Email: eduardpetredaw@gmail.com');
            $this->Ln();

            $this->Cell(134, 6,'IBAN: RO39BTRLRONCRT0490811001, Banca Transilvania');
            $this->Ln();
        }

        function detalii_client(){
            global $name;
            global $email;

            $this->Ln();
            $this->Ln();

            $this->SetFont('Arial', 'B', 17);
            $this->SetTextColor(0);

            $this->SetY(30);

            $this->SetX(165);
            $this->Cell(118, 6, "Client:");
            $this->Ln();
            $this->LN();

            $this->SetFont('Arial', '', 12);
            
            $this->SetX(165);
            $this->Cell(118, 6, 'Nume: ' . $name);
            $this->Ln();
            $this->SetX(165);
            $this->Cell(118, 6, 'Email: ' . $email);
            $this->Ln();
        }

    
        function FancyTable(){
            
            $this->SetY(80);
            $this->SetFont('Arial', 'B', 15);
            $header = array("Camera", "Capacitate", "Perioada", "Pret");
            $w = array(80,60,80,45);

            for($i=0;$i<count($header);$i++)
                $this->Cell($w[$i],15,$header[$i],1,0,'C');
            $this->Ln();
        
            $this->SetFont('Arial', '', 12);

            global $roomname;
            global $roomcategory;
            global $checkin;
            global $checkout;
            global $roomprice;

            $height = 95;
            
            $dataname = array();
            $dataname = explode("\n", $roomname);
            
            $datacat = array();
            $datacat = explode("\n", $roomcategory);

            $datacin = array();
            $datacin = explode("\n", $checkin);

            $datacout = array();
            $datacout = explode("\n", $checkout);

            $dataprice = array();
            $dataprice = explode("\n", $roomprice);
            
            $length = max(count($dataname), count($datacat), count($datacin), count($datacout), count($dataprice));
            $dataname = array_pad($dataname, $length, '');
            $datacat = array_pad($datacat, $length, '');
            $datacin = array_pad($datacin, $length, '');
            $datacout = array_pad($datacout, $length, '');
            $dataprice = array_pad($dataprice, $length, '');
            
            $this->SetY(90);
            $this->SetX(50);


            for($i=0; $i < count($dataname); $i=$i+1){
                $this->SetY($height);
                $this->SetX(15);
                $this->Multicell($w[0], 10, $dataname[$i], 1, 'C');
                
                $this->SetY($height);
                $this->SetX(95);
                $this->Multicell($w[1], 10, $datacat[$i], 1, 'C');
                
                $this->SetY($height);
                $this->SetX(155);
                $this->Multicell($w[2], 10, $datacin[$i].' - '.$datacout[$i], 1, 'C');

                $this->SetY($height);
                $this->SetX(235);
                $this->Multicell($w[3], 10, $dataprice[$i].' RON', 1, 'C');

                $height = $height + 5;
            }
        }
    }

    $dataname = array();
    $dataname = explode("\n", $roomname);
    
    $datacat = array();
    $datacat = explode("\n", $roomcategory);

    $datacin = array();
    $datacin = explode("\n", $checkin);

    $datacout = array();
    $datacout = explode("\n", $checkout);

    $dataprice = array();
    $dataprice = explode("\n", $roomprice);
    
    $length = max(count($dataname), count($datacat), count($datacin), count($datacout), count($dataprice));
    $dataname = array_pad($dataname, $length, '');
    $datacat = array_pad($datacat, $length, '');
    $datacin = array_pad($datacin, $length, '');
    $datacout = array_pad($datacout, $length, '');
    $dataprice = array_pad($dataprice, $length, '');

    $pdf = new PDF('L', 'mm', array(210, 298));
    $pdf->AliasNbPages();
    $pdf->SetMargins(15, 15, 15);
    $pdf->AddPage();
    $pdf->detalii_hotel();
    $pdf->detalii_client();
    $pdf->FancyTable();
    $pdf->Output();

} else {
    require('../fpdf185/fpdf.php');
    class PDF extends FPDF{
        function Header() {
            $this->SetFont('Arial', 'B', 28);
            $this->SetTextColor(0);
            $this->Cell(134, 12,'Hotel Royal');
            $this->Ln();
            $this->Ln();
        }  

        function Footer() {
            $this->SetY(-35);
            $this->SetFont('Arial','I', 8);
            $this->Cell(0,10,'Document emis la data ' . date('Y-m-d'),0,0,'C');

            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }
    

    $text = "Pentru a face o rezervare trebuie sa va conectati!";

    $pdf = new PDF('L', 'mm', array(210, 298));
    $pdf->AliasNbPages();
    $pdf->SetMargins(15, 15, 15);
    $pdf->AddPage();
    $pdf->SetFont('Arial','', 12);
    $pdf->Write(2,$text);
    $pdf->Write(2,' Conectati-va acum!','https://hotelroyal.herokuapp.com/login.php');
    $pdf->Output();
}

?>