<?php
/**
 * @file Messages_backend.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 31.05.2016 13:44:47 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 
/**
 * Messages Backend Controller
  * Displays only index() if user is loggin if not it shows 404
 * @see Login::checkUser
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Messages_backend extends CI_Controller{
	public function index(){
		$this->load->model("login");
		if(Login::checkUser()->getRole() != 2){
			show_404();
			}
		//load settings model:
		$this->load->model("einstellungen");
		//data for the views
		$data = $this->einstellungen->load();//load actual settings
		//load views
		$this->load->view("backend_head",$data);
		$this->load->view("messages_backend",$data);
		$this->load->view("backend_bottom",$data);
	}
	/**
	 * shows a single message
	 * But only if user is logged in
	 **/
	public function show($id){
		$this->load->model("login");
		if(Login::checkUser()->getRole() != 2){
			show_404();
			}
		//load settings model:
		$this->load->model("einstellungen");
		//data for the views
		$this->einstellungen->set("page","messages");
		$this->einstellungen->set("id",$id);
		$data = $this->einstellungen->load();//load actual settings
		//load views
		$this->load->view("backend_head",$data);
		$this->load->view("messages_backend",$data);
		$this->load->view("backend_bottom",$data);
		}
	/**
	 * gens a pdf of a file
	 * @see Pdf
	 * @see FPDF
	 **/
	public function pdf($id){
		$this->load->library('container');
		$this->load->library('pdf');
		$pdf = $this->pdf;
		$object = $this->container->getMessageClass()->create($id);
		if(!is_null($object)){
				$pdf->AliasNbPages();
				$pdf->AddPage();
				$pdf->SetFont('Times','B',10);
				$pdf->Cell(0,12,"Sender: ");
				$pdf->SetFont('Times','',10);
				$pdf->ln(5);
				$pdf->Cell(0,12,"Name: ".$object->getSender()->getName()." ".$object->getSender()->getSurname());
				$pdf->ln(5);
				$pdf->Cell(0,12,"E-Mail: ".$object->getSender()->getEmail());
				$pdf->ln(5);
				$pdf->Cell(0,12,"Date: ".date("H:i d.m.Y",$object->getDate()));
				$pdf->ln(12);
				$pdf->ChapterTitle("Message: ".$object->getTitle());
				$pdf->MultiCell(0,5,$object->getMessage());
				$pdf->setTitle("Message from ".$object->getSender()->getName()." ".$object->getSender()->getSurname()." at ".date("H:i d.m.Y",$object->getDate()));
			}else{
				$pdf->AliasNbPages();
				$pdf->AddPage();
				$pdf->ChapterTitle("404 Error could not found document");
				$pdf->SetFont('Times','',12);
				$pdf->Cell(100,12,"System could not find requested document.");			
				}
			$pdf->Output();	
		}
	}
?>
