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
		
        $w = array(90, 25, 25, 25, 25);
        // Header
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],'BLRT',0,'C');
        $this->Ln();
        // Data
        $total_failed = 0;
        $total_success = 0;
        foreach($data as $row)
        {
            $failed = $row[3];   
            $success = $row[4];   
            $this->Cell($w[0],6,$row[0],'L');
            $this->Cell($w[1],6,$row[1],'L'); 
            $this->Cell($w[2],6,$row[2],'L'); 
            $this->Cell($w[3],6,@number_format($failed,2, '.', ','),'LR',0,'R');
            $this->Cell($w[4],6,@number_format($success,2, '.', ','),'LR',0,'R');
            $this->Ln();

            $total_failed += $failed;
            $total_success += $success; 
        } 
        //$this->Ln();
        // Closing line
        $this->Cell(140,7,'TOTAL FAILED','T', 0, 'R');
        //$this->Cell(40,7,number_format($total),'T', 0, 'R');
        $this->Cell(25,7,number_format($total_failed,2, '.', ','),'T', 0, 'R');
		 $this->Cell(25,7,'','T', 0, 'R');
		$this->Ln();
        $this->Cell(140,7,'TOTAL SUCCESS',0, 0, 'R');
        //$this->Cell(40,7,number_format($total),'T', 0, 'R');
        $this->Cell(50,7,number_format($total_success,2, '.', ','),0, 0, 'R');
    }
	
	
    function individual($info, $header, $data){

        $this->SetFont('Arial','B',14);
        //company name
        $this->Cell(150,7,'Vanda Boxing Club Pte Ltd',0,0,'L');
         // Move to the right
        $this->SetFont('Arial','',20); 
        $this->Cell(40,10,'INVOICE',0,0,'R'); 
        $this->Ln(0);        
		
        $this->SetFont('Arial','',9);
        $this->Ln();
        $this->Cell(100,5,'108 Robinson Road, #01-01 Finexis Building',0,0,'L');
        $this->Ln();
        $this->Cell(100,5,'068900',0,0,'L');
        $this->Ln();
		$this->Cell(100,5,'Singapore',0,0,'L');
       
		$this->Ln();        
		$this->Cell(155,5,'Terms: ',0,0,'R');
		$this->Cell(35,5,'Due On Receipt',0,0,'R');
		
	    $this->Ln(); 
		
        $this->Cell(100,5,'Bill To: ('.$info->pay_ref.') '.$info->ai_fname.', '.$info->ai_lname,0,0,'L');
        $this->SetFont('Arial','',9);
        $this->Cell(55,5,'Invoice Date: ',0,0,'R');
        $this->Cell(35,5,date('d M Y'),0,0,'R');
        
		$this->Ln(10);

        $this->SetFont('Arial','',9);
        // Column widths
		
        $w = array(90, 25, 25, 50);
		
		// Colors, line width and bold font
		/* $this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);  */
		//$this->SetFont('','B');
		$this->SetTextColor(255);
        // Header
        for($i=0;$i<count($header);$i++){ 
            $this->Cell($w[$i],7,$header[$i],'BLRT',0,'C', true);
		}	
        $this->Ln();
		
		// Color and font restoration
		/* $this->SetFillColor(224,235,255);
		$this->SetTextColor(0); */
		//$this->SetFont('');		
		$this->SetTextColor(0);
		$fill = false;
		
        // Data
        $total_failed = 0;
        $total_success = 0;
		$total_due = array();
        foreach($data as $row) {
		 
            $failed = $row[2];   
            $success = $row[3]; 
			
			$this->SetTextColor(0);
			
			$mem_name = explode('- S',$info->mem_name);
            $this->Cell($w[0],6,$mem_name[0],'L', $fill);
            $this->Cell($w[1],6,$row[0],'L', $fill); 
            $this->Cell($w[2],6,$row[1],'L', $fill); 
			if( $success > 0  ){
				$this->Cell($w[3],6,@number_format($success,2, '.', ','),'LR',0,'R', $fill );
				$total_due["'".$row[1]."'"][] = $success;
            }else{
				$this->SetTextColor(255,0,0);
				$this->Cell($w[3],6,'-'.@number_format($failed,2, '.', ','),'LR',0,'L', $fill);
				$total_due["'".$row[1]."'"][] = '-'.$failed;
            }
			$this->Ln();

            $total_failed += $failed;
            $total_success += $success; 
        } 
		
		$past_due = 0;
		foreach($total_due as $amnt){
			$s = array_sum($amnt);	
			if( $s <= 0){
				$past_due += abs($s);
			}
		}
        //$this->Ln();
        // Closing line
        /* $this->Cell(140,7,'TOTAL FAILED','T', 0, 'R');
        //$this->Cell(40,7,number_format($total),'T', 0, 'R');
        $this->Cell(25,7,number_format($total_failed,2, '.', ','),'T', 0, 'L');
		$this->Cell(25,7,'','T', 0, 'R'); */
		
		$this->Cell(190,7,'','T', 0, 'R');
		$this->Ln(); 
		$this->Cell(140,7,'Balance Due','T', 0, 'R');
        //$this->Cell(40,7,number_format($total),'T', 0, 'R');
        $this->Cell(50,7,number_format($past_due,2, '.', ','),'T', 0, 'R');
		 
    }	
      
}  

?> 