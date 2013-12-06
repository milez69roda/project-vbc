<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

   
class PDF extends FPDF { 

    function Header() {
        // Logo
        //$this->Image('logo.png',10,6,30);
        // Arial bold 15 
        /*if( $this->PageNo() > 1){
             $this->Cell(150,7,'You Comany Name',1,0,'L');
               $this->Ln(10);   
        }*/
    }

    // Page footer
    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    // Load data
    function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line)
            $data[] = explode(';',trim($line));
        return $data;
    } 

    // Better table
    function setContents($header, $data)
    {

        $this->SetFont('Arial','B',12);
        //company name
        $this->Cell(150,7,'Vanda Boxing Club',0,0,'L');
         // Move to the right
        $this->SetFont('Arial','',14); 
        $this->Cell(40,10,'INVOICE',0,0,'R'); 
        $this->Ln(0);        
		
        $this->SetFont('Arial','',11);
        $this->Ln();
        $this->Cell(100,5,'Finexis Building, 108 Robinson Road #01-01',0,0,'L');
        $this->Ln();
        $this->Cell(100,5,'Singapore 068900',0,0,'L');
        $this->Ln();
        $this->Cell(100,5,'Phone: +65 6305 2288 Fax: +65 6305 2299',0,0,'L');
        
        $this->SetFont('Arial','I',11);
        $this->Cell(90,5,'Date: '.date('F d, Y'),0,0,'R');
        $this->Ln(10);

        $this->SetFont('Arial','',12);
        // Column widths
		
        $w = array(105, 25, 25, 35);
        // Header
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],'BLRT',0,'C');
        $this->Ln();
        // Data
        $total = 0;
        foreach($data as $row)
        {
            $ammount = $row[3];   
            $this->Cell($w[0],6,$row[0],'L');
            $this->Cell($w[1],6,$row[1],'L'); 
            $this->Cell($w[2],6,$row[2],'L'); 
            $this->Cell($w[3],6,$ammount,'LR',0,'R');
            $this->Ln();

            $total += $ammount;
        } 
        //$this->Ln();
        // Closing line
        $this->Cell(150,7,'TOTAL','T', 0, 'L');
        //$this->Cell(40,7,number_format($total),'T', 0, 'R');
        $this->Cell(40,7,number_format($total,2, '.', ','),'T', 0, 'R');
    }
      
}  

?>

