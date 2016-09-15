<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @file Einstellungen.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 11.06.2016 19:16:16 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Settings Modul
 * 
 * COnnects to the data base and gets the settings
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Einstellungen extends CI_Model{
		/**
		 * @var array
		 * contains the settings
		 **/
		private $settings = array();
		private $password_ = "";
	    /**
	     * 
	     * Call the CI_Model constructor
	     * 
	     * **/
		public function __construct(){
				$this->load->database();
                parent::__construct();
		}
		/**
		 * get setting property from database table settings
		 * @param string $name
		 * @return mixed
		 * if success if not null
		 **/
		public function get($name){
				if(isset($this->settings[$name])){
					return $this->settings[$name];
				}else{
					$this->load->database();
					$data = $this->db->where("name",$name)->get("settings")->result();
					if(count($data) == 1){
						$this->settings[$name] = new StdClass();
						$this->settings[$name]->content = $data->content;
						return $this->settings[$name];
						}
					}
				return null;
			}
		/**
		 * load settings from database
		 * 
		 * converts the database entries in a viewer handelable form. Converts JSON text to objects send the orginal with it so that if its needed you can use the JSON.
		 * return structure: Array(
		 * [NAME-OF-SETTING] => StdClass(){
		 * [content]->mixed
		 * [id]->int
		 * [orginal]->string
		 * }
		 * )
		 * @return array
		 * Restuns an array which contains StdClass objects with the data
		 **/
		public function load(){
			$settings = $this->db->get("settings")->result();
			$set = array();
			foreach($settings as $key => $setting){
					foreach($setting as $k => $value){
						$conv = json_decode($value);
						if(json_last_error() == JSON_ERROR_NONE){
							$this->settings[$setting->name] = new StdClass();
							$this->settings[$setting->name]->$k = $conv;
							//for ajavascript potpuse
							$this->settings[$setting->name]->orginal = $value;
							$this->settings[$setting->name]->id =$setting->id;
							}else{
							$this->settings[$setting->name] = new StdClass();
							$this->settings[$setting->name]->$k = $value;
							$this->settings[$setting->name]->orginal = $value;
							$this->settings[$setting->name]->id =$setting->id;
								}
					}
				}
				return $this->settings;
			}
		/**
		 * getFrom
		 * 
		 * loads form into settings object
		 * @param string $option
		 **/
		 public function getForm($option){
			//load database
			$this->load->database();
			if($option == "helptexts"){
			$source = $this->settings["helptexts"]->content;
			foreach($source as $search => $value){
					foreach($value->data as $key => $val){
						if($this->input->post($key) != null){
							$this->settings["helptexts"]->content[$search]->data->$key->content = $this->input->post($key);
							}
					}
				}
			}else{
				$this->password_ = $this->settings["password"];
				foreach($_POST as $key => $content){
					$re = "/(helptext_)/"; 
					if($key != "helptexts" AND preg_match($re, $key, $matches) == 0){
						$this->settings[$key] = new StdClass();
						if($this->input->post($key) != null AND $key != "submit"){
							$this->settings[$key]->content = $this->input->post($key);
							}
						}
					}
				}
			 }
		public function update($key,$value){
			return $this->db->where("name",$key)->set("content",$value)->update("settings");
			}
		/**
		 * save
		 * 
		 * saves settings propertys in database
		 * if ihe name of the setting is password it hases it automaticly
		 * @return void
		 * */
		public function save(){
			$add = array();
			foreach($this->settings as $key => $setting){
				if($key == "helptexts"){
				$add[]= array(
					"name"=>$key,
					"content"=>json_encode($setting->content)
				);
				}else{
				if(property_exists($setting,"content") == true){
					if($key == "password"){
						$setting->content = password_hash($setting->content,PASSWORD_DEFAULT);
						}
					$add[]= array(
						"name"=>$key,
						"content"=>$setting->content
					);
				}else if($key == "password"){
					$add[]= array(
						"name"=>$key,
						"content"=>$this->password_->content
					);
					}
					}
				}
				//check password
				$this->db->empty_table("settings");
				$this->db->insert_batch('settings', $add);
			}
		/**
		 * sets setting
		 * 
		 * @param string $name
		 * set the name of the setting value
		 * @param mixed $val
		 * is the data
		 * @return void
		 **/
		public function set($name,$val){
			$this->settings[$name] = new StdClass();
			$this->settings[$name]->content = $val;
			$this->settings[$name]->orginal = $val;
		}
}
?>
