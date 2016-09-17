<?php
/**
 * @file Installer.php 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 13.06.2016 23:46:16 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * @version 1.0
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
 define("KI_VERSION","1.0");
 define("C_DEFAULT","\e[39m");
 define("C_RED","\e[31m");
 define("C_GREEN","\e[32m");
 define("A_PATH","application/");
 define("C_PATH",A_PATH."config/config.php");
 define("DB_PATH",A_PATH."config/database.php");
 define("KI_CONFIG","install_data/config.php.bak");
 define("KI_DB","install_data/database.php.bak");
  define("KI_SQL","install_data/database.sql");
 class Installer {
	 private $display_config = false;
	 private $display_config_DB = false;
	 private $base_url = "http://localhost/";
	 private $language = "en";
	 private $hostname = "localhost";
	 private $dbuser = "admin";
	 private $dbpassword = "password";
	 private $db = "kitchenhelper";
	 private $dbprefix = "OBAK_";
	 private $name = "John";
	 private $surname = "Doe";
	 private $email = "John@doe.tld";
	 private $password = "password";
	 private $database = null;
	 private $pagename = "KitchenHelper Tool Version ".KI_VERSION;
	 
	 public function setup(){
echo "
#############################
#  KitchenHelper Installer  #
#############################

@version  ".KI_VERSION."
@license Cyroxx Software Lizenz 1.0
@author Simmon Renger <info@cyroxx.de>
@copyright Simon Renger <info@simonrenger.de>, All right reserved.

Initialization test:
";
$this->ini_test();
echo "\n\n
Installation:";
if($this->enter() == true){
	$this->commit();
	echo PHP_EOL.C_GREEN."Installation was succesfull".C_DEFAULT.PHP_EOL;
	$this->delete();
	}
}
private function enter(){
echo PHP_EOL."############Basic settings############";
echo "
Tipp: Leave empty for default value.
Please Enter the Base URL:";
$entry_bU = trim(fgets(STDIN));
$base_url = (strlen($entry_bU) != 0)? $entry_bU: $this->base_url;
echo "\nPlease select language: (en/de):";
$entry_lang = trim(fgets(STDIN));
$lang = (strlen($entry_lang) != 0)? $entry_lang:$this->language;
echo "\nPlease enter page name: (default: ".$this->pagename."):";
$entry_pagename = trim(fgets(STDIN));
$pagename = (strlen($entry_pagename) != 0)? $entry_password:$this->pagename;
//mysql
echo PHP_EOL."############Database infos############";
echo "\nPlease enter the database hostname: (default: ".$this->hostname."):";
$entry_dbh = trim(fgets(STDIN));
$hostname = (strlen($entry_dbh) != 0)? $entry_dbh:$this->hostname;
echo "\nPlease enter the database db user: (default: ".$this->dbuser."):";
$entry_dbu = trim(fgets(STDIN));
$dbuser= (strlen($entry_dbu) != 0)? $entry_dbu:$this->dbuser;
echo "\nPlease enter the database db user password: (default: ".$this->dbpassword."):";
$entry_dbup = trim(fgets(STDIN));
$dbpassword = (strlen($entry_dbup) != 0)? $entry_dbup:$this->dbpassword;
echo "\nPlease enter the database database: (default: ".$this->db."):";
$entry_db = trim(fgets(STDIN));
$db = (strlen($entry_db) != 0)? $entry_db:$this->db;
echo "\nPlease enter the database db prefix: (default: ".$this->dbprefix."):";
$entry_dbprefix = trim(fgets(STDIN));
$dbprefix = (strlen($entry_dbprefix) != 0)? $entry_dbprefix:$this->dbprefix;
echo PHP_EOL."############User infos############";
echo "\nPlease enter Name: (default: ".$this->name."):";
$entry_name = trim(fgets(STDIN));
$name = (strlen($entry_name) != 0)? $entry_name:$this->name;
echo "\nPlease enter Surame: (default: ".$this->surname."):";
$entry_surname = trim(fgets(STDIN));
$surname = (strlen($entry_surname) != 0)? $entry_name:$this->surname;
echo "\nPlease enter email adress: (default: ".$this->email."):";
$entry_email = trim(fgets(STDIN));
$email = (strlen($entry_email) != 0)? $entry_email:$this->email;
echo "\nPlease enter password: (default: ".$this->password."):";
$entry_password = trim(fgets(STDIN));
$password = (strlen($entry_password) != 0)? $entry_password:$this->password;
echo PHP_EOL."############Basic settings############";
echo PHP_EOL."base_url:".$base_url;
echo PHP_EOL."lang:".$lang;
echo PHP_EOL."page name:".$pagename;
echo PHP_EOL."############Database infos############";
echo PHP_EOL."hostname:".$hostname;
echo PHP_EOL."database user:".$dbuser;
echo PHP_EOL."database user password:".$dbpassword;
echo PHP_EOL."database name:".$db;
echo PHP_EOL."Table name prefix:".$dbprefix;
echo PHP_EOL."############User infos############";
echo PHP_EOL."Name:".$name;
echo PHP_EOL."Surname:".$surname;
echo PHP_EOL."E-Mail:".$email;
echo PHP_EOL."password:".$password;
echo "\nAre your entries correct? (y/n)";
$isCorrect = trim(fgets(STDIN));
if($isCorrect === "n"){
	//start again
	return $this->enter();
	}else{
		//save:
		$this->base_url = $base_url;
		$this->language = $lang;
		$this->hostname = $hostname;
		$this->dbuser = $dbuser;
		$this->dbpassword = $dbpassword;
		$this->db = $db;
		$this->dbprefix = $dbprefix;
		$this->name = $name;
		$this->surname = $surname;
		$this->email = $email;
		$this->password = $password;
		$this->pagename = $pagename;
		//check if database data are right:
		$dbCheck = new mysqli($hostname,$dbuser,$dbpassword,$db);
		if($dbCheck->connect_error){
			echo "checking database connection ... error:(".$dbCheck->connect_errno.") ".$dbCheck->connect_error." ".C_RED."[FAILED]".C_DEFAULT.PHP_EOL;
			echo PHP_EOL."############Retry############";
			return $this->enter();
			}else{
				$this->database = $dbCheck;
				echo "checking database connection ... done ".C_GREEN."[OK]".C_DEFAULT.PHP_EOL;
				return true;
				}
		return false;
		}
		return false;
	}
private function ini_test(){
	if(php_sapi_name() === 'cli'){
		echo "API test ... CLI ".C_GREEN."[OK]".C_DEFAULT.PHP_EOL;
		//check if install_data existst:
		if($this->file("install_data",false)){
				$this->file(KI_CONFIG);
				$this->file(KI_DB);
				$this->file(KI_SQL,true,false,true,true);
		}
		}else{
		echo C_RED."FATAL ERROR: PROGRAMM RUNS NOT IN CLI EXIT!".C_DEFAULT.PHP_EOL;
		exit();
		}
		$this->clean(C_PATH);
		$this->clean(DB_PATH);
	}
	private function clean($file){
			//create
			if(file_put_contents($file,"") !== false){
				echo "create config ".$file." ... done ".C_GREEN."[OK]".C_DEFAULT.PHP_EOL;
				}else{
					$this->display_config = true;
					echo "create config $file ... failed ".C_RED."[FAILED]".C_DEFAULT.PHP_EOL;
					}
		}
	private function file($filename,$readable = true,$write = true,$exit = true,$print = true){
		if(file_exists($filename)){
			if($print == true){
			echo "check ".$filename." ... found ".C_GREEN."[OK]".C_DEFAULT.PHP_EOL;
				}
			if($readable == true OR $write == true){
			   if(is_readable($filename) OR is_writeable($filename)){
				   if($print == true){
						echo "check ".$filename." ... readable or writeable ".C_GREEN."[OK]".C_DEFAULT.PHP_EOL;
					}
				return true;
				}else{
					echo "check ".$filename." ... not readable or writeable ".C_RED."[FAILED]".C_DEFAULT.PHP_EOL;
					if($exit == true){
						echo "FATAL ERROR: ".$filename." ... not found ... exit! ".C_RED."[FAILED]".C_DEFAULT.PHP_EOL;
							exit();
						}
						return false;
				}
			}
		return true;
		}else{
			echo "check ".$filename." ... not found ".C_RED."[FAILED]".C_DEFAULT.PHP_EOL;
			if($exit == true){
				echo "FATAL ERROR: ".$filename." ... not found ... exit! ".C_RED."[FAILED]".C_DEFAULT.PHP_EOL;
					exit();
				}
				return false;
			}
		}
	private function commit(){
		$encrypt_key = $this->genKey();
		//saves files:
		//1) load dummy files:
		$config = file_get_contents(KI_CONFIG);
		$db = file_get_contents(KI_DB);
		//safe cfg
		if( file_put_contents(C_PATH,$this->find(
			array("[base_url]","[lang]","[encrypt_key]"),
			array(
			$this->base_url,
			$this->language,
			$encrypt_key
			),$config
		)
		) !== false){
			echo "write config ".C_PATH." ... done ".C_GREEN."[OK]".C_DEFAULT.PHP_EOL;
			}else{
				echo "write config ".C_PATH." ... error ... exit()".C_RED."[FAILED]".C_DEFAULT.PHP_EOL;
				exit();
				}
		//safe db
		if(file_put_contents(DB_PATH,$this->find(
			array(
			"[hostname]",
			"[dbuser]",
			"[dbpassword]",
			"[db]",
			"[dbprefix]"
			),
			array(
			$this->hostname,
			$this->dbuser,
			$this->dbpassword,
			$this->db,
			$this->dbprefix
			),$db
		)
		)!== false){
			echo "write database config ".DB_PATH." ... done ".C_GREEN."[OK]".C_DEFAULT.PHP_EOL;
			}else{
				echo "write database config ".DB_PATH." ... error ... exit()".C_RED."[FAILED]".C_DEFAULT.PHP_EOL;
				exit();
				}
		echo "########start filling database########".PHP_EOL;
		//install MYSQL Data
		$this->SQLImport();
		}
	private function find($search,$rep,$data){
		for($x = 0;$x < count($search);$x++){
			$data = str_replace($search[$x],$rep[$x],$data);
			}
		return $data;
		}
	private function genKey(){
		$key = "";
		for($x = 0;$x < 64;$x++){
			$key .= chr(rand(33,125));
			}
		return base64_encode($key);
		}
	private function SQLImport(){
		$handle = @fopen(KI_SQL, "r");
		if ($handle) {
			$sql = "";
			while (($buffer = fgets($handle, 4096)) !== false) {
				if(preg_match("/(--)|(\/\*)/",$buffer)){
					//echo $buffer;
				}else{
					$sql .= trim($buffer);
					if(preg_match("/;/",$buffer)){
						$this->executeSQL($sql);
						$sql = "";
						}
					}
			}
			if (!feof($handle)) {
				echo "FATAL ERROR: ".$filename." ... error ... exit! ".C_RED."[FAILED]".C_DEFAULT.PHP_EOL;
				die();
			}
			fclose($handle);
		}
	}
	private function executeSQL($query){
		$mysqli = $this->database;
		//query edit:
		$query = $this->find(
			array("[prefix]",
			"[name]",
			"[surname]",
			"[password]",
			"[email]",
			"[baseurl]",
			"[pagename]"
			),
			array(
			$this->dbprefix,
			$this->name,
			$this->surname,
			password_hash($this->password, PASSWORD_DEFAULT),
			$this->email,
			$this->base_url,
			$this->pagename
			),
		$query);
		if ($mysqli->query($query) === TRUE) {
			echo "SQL Query insert ... done ".C_GREEN."[OK]".C_DEFAULT.PHP_EOL;
		}else{
			echo "FATAL ERROR: ".$mysqli->error." ... error ... exit! ".C_RED."[FAILED]".C_DEFAULT.PHP_EOL;
			exit();
			}
		}
	private function delete(){
		@unlink(KI_CONFIG);
		@unlink(KI_DB);
		@unlink(KI_SQL);
		@rmdir("install_data/");
		@unlink(Installer.php);
		}
}

(new Installer())->setup();

?>
