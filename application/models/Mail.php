<?php
/**
 * @file Mail.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 07.06.2016 08:48:21 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Mail extends CI_Model{
	private $sendMail = true;
	private $texts;
	public function __construct($to = null,$subject = null,$message = null){
		$this->load->model("einstellungen");
		if($this->einstellungen->load()["sendMail"]->content == true){
			$this->load->library('email');
			$this->email->from($this->einstellungen->load()["EMailAddress"]->content);
			$this->texts = $this->einstellungen->load()["helptexts"]->content[5];
			if($to != null){
				$this->setTo($to);
				$this->setSubject($subject);
				$this->setMessage($message);
			}
		}else{
			$this->sendMail = false;
			}
		}
	
	public function setTo($to){
		$this->email->to($to);
		}
	public function setSubject($subject,$substrs = null){
		$re = '/{([aA-zZ0-9]+)}/i';
		if(!preg_match($re, $subject, $matches)){
				foreach($this->texts as )
				}
		$this->email->subject($subject);
		}
	public function setMessage($message,$substrs = null){
			$re = '/{([aA-zZ0-9]+)}/i';
			if(preg_match($re, $message, $matches)){
				
			}
			$this->email->message($message);
		}
	
	public function send(){
		if($this->sendMail == true){
			return $this->email->send();
		}else{
			return null;
			}
		}
	
	}
	
?>
