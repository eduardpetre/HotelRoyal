<?php

session_start();

require('../fpdf185/letter-template.php');

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
    if (isset($_GET['check-in']) && 
        isset($_GET['check-out'])){

            $checkin = $_GET['check-in'];   
            $checkout = $_GET['check-out'];
        
        } else {
            $checkin = date("Y-m-d", strtotime("+0 day"));
            $checkout = date("Y-m-d", strtotime("+1 day"));
        }

    $text = "Buna ziua, $name! Va multumim pentru ca ne-ati ales. Va asteptam cu drag in perioada $checkin - $checkout! Detaliile de plata vor fi transmise prin email. Daca nu mai aveti acces la adresa $email sau pentru orice alte nelamuri va rugam sa ne contactati.";
    
        
    $pdf=new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(85,10,"Hotel Royal\n\n",0,1,'C');
    $pdf->SetFont('Arial','', 10);
    $pdf->Justify($text,85,4);
    $pdf->Write(4,"\nSource: https://hotelroyal.herokuapp.com/\n\n");
    $pdf->Output();

} else {

    $text = "Pentru a face o rezervare trebuie sa va conectati!";

    $pdf=new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(85,10,"Hotel Royal\n\n",0,1,'C');
    $pdf->SetFont('Arial','', 10);
    $pdf->Justify($text,85,4);
    $pdf->Write(4,"\nSource: https://hotelroyal.herokuapp.com/\n\n");
    $pdf->Output();
}

?>