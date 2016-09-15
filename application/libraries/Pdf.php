<?php
/**
 * @file Pdf.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 07.06.2016 12:48:07 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
 * Alle Rechte vorbehalten.
 * Durch diese Lizenz ist der nachfolgende Quelltext in all seinen Erscheinungsformen [Beispiele: Kompiliert, Unkompiliert, Script Code] geschützt.
 * Im nachfolgenden Text werden die Worte Werk, Script und Quelltext genutzt Diese drei Wörter sind gleichzusetzen und zu schützen.
 * Der Autor dieses Werkes kann für keinerlei Schaden die durch das Werk enstanden sein könnten, entstehen werden verantwortlich gemacht werden.
 * 
 * Rechte und Pflichten des Nutzers dieses Werkes:
 * Der Nutzer dieses Werkes verpflichtet sich, diesen Lizenztext und die Autoren-Referenz auszuweisen und in seiner originalen Erscheinungsform zu belassen.
 * Sollte dieses Werk kommerziell genutzt werden, muss der Autor per E-Mail informiert werden, wenn eine E-Mail Adresse angegeben/bekannt ist.
 * Das Werk darf solange angepasst, verändert und zu verändertem Zwecke genutzt werden, wie dieser Lizenztext und die Autor(en)-Referenz ausgewiesen wird und
 * nicht gegen die Lizenzvereinbarungen verstößt.
 * Das Werk darf nicht für illigale Zwecke eingesetzt werden.
 **/
  if(!defined("USER_LIBS")){
  define("USER_LIBS",APPPATH."libraries/");
	}
 require_once USER_LIBS."Fpdf.php";
/**
 * Creates based on FPDF Class a PDF file
 * 
 * @see documentation http://www.fpdf.org/
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Pdf extends Fpdf
{
// Page header
function Header()
{
    // Logo
    $this->Image(APPPATH."../makeup/imgs/OBA-header-logo.png",10,6,80);
    $this->SetFont('Arial','I',9);
    $this->Cell($this->GetPageWidth()-30,10,'Date '.date("d/m/Y H:i"),0,0,'R');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Times','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
function ChapterTitle($label)
{
    // Arial 12
    $this->SetFont('Arial','',12);
    // Background color
    
    $this->SetFillColor(229,229,229);
    // Title
    $this->Cell(0,6,$label,0,1,'L',true);
    // Line break
    $this->Ln(4);
}
private $diff = array();
private $header = null;
// Better table
function ImprovedTable($header, $data)
{
    // Column widths
    // Header
	$this->diff = array();
    $this->header = $header;
    for($i=0;$i<count($header);$i++){
					if(is_array($header[$i])){
						$head = $header[$i][0];
						$width = $header[$i][1];
						$this->diff[] = $header[$i][1];
						}else{
						$width = $this->getWidth(count($header),$this->diff);
							$head = $header[$i];
							}
					$this->Cell($width,7,$head,1,0,'C');
    }
    $this->Ln();
    // Data
    foreach($data as $k => $row)
    {
		if(!is_numeric($k)){
			$row = $data[$k];
			$this->SetFillColor(229);
			$this->Cell($this->GetPageWidth()*0.90,6,$k,'TLRB','',"L",true);
			//$this->SetFillColor(255);
			$this->Ln();
			}
		$this->tableBody($row);
    }
}
private function getStyle($cont){
			$style = null;
			$content = null;
			if(is_array($cont) AND count($cont) == 2){
					if(array_key_exists("style",$cont)){
						$style = $cont["style"];
						$content = $cont[0];
					}
				}else if(!is_array($cont)){
					$content = $cont;
					}
			return 	array($content,$style);
	}
private function getWidth($childs,$check = null){
	if(is_null($check)){
		return ((($this->GetPageWidth()*0.90)/$childs));
	}else{
		if(is_array($check)){
			$sum = 0;
			foreach($check as $minus){
				$sum += $minus;
				}
			}
		$base = ($this->GetPageWidth()*0.90) - $sum;
		$base = ($base == 0)? 1:$base;
		$div = (($childs - count($check)) == 0)? 1:($childs - count($check));
		return ($base  / $div);
		}
	}
private function tableBody($data){
		if(is_array($data)){
		 foreach($data as $key => $cont){
			 if(is_array($cont)){
				if(count($cont) >= 2 AND !array_key_exists("style",$cont)){
					$this->tableBody($cont);
					}
				$value = $this->getStyle($cont);
				$content = $value[0];
				$style = $value[1];
			}else{
				$content = $cont;
				$style = null;
				}
			//create the real table:
			if(array_key_exists($key,$this->diff)){
			$diff = $this->diff[$key]."\n";
			}else{
				$diff = $this->getWidth(count($this->header),$this->diff);
				}
			if($content !== null){
			$this->Cell($diff,6,$content,'LRB',0,$style);
			}
			 
		 }
        $this->Ln();
		}
	}
}
?>
