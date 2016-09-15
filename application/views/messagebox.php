<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @file messagebox.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 13.06.2016 12:52:07 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */

?>
<div class="container">
	<div class="row">
		<div class="page-header">
		  <h1>Messages to the kitchen <small> Critics Ideas...</h1>
		</div>
		<p class="text-info"><span class="glyphicon glyphicon-info-sign"></span> <span class="helptext_messagebox_info">[helptext_messagebox_info]</span></p>
	</div>
	
	<div class="row">
		<?php
		if($error->content != "" and $error->content != 1){?>
		<div class="alert alert-danger">
		<strong><?php echo $error->content; ?></strong>
		</div>
		<?php }else if($error->content == 1){?>
		<div class="alert alert-success">
		<strong><span class="glyphicon glyphicon-send"></span> Process was succesful</strong>
		</div>
			<?php } echo form_open('messages'); ?>
		<label for="basic-name">Your Name</label>
		<div class="input-group input-group-lg">
		  <input type="text" class="form-control" id="basic-name" name="name" placeholder="John Doe" aria-describedby="basic-addon">
		  <span class="input-group-addon" id="basic-addon"><span class="glyphicon glyphicon-user"></span> Name</span>
		</div>
		<label for="basic-mail">Your E-Mail Address <i>(OBA username)</i></label>
		<div class="input-group input-group-lg">
		  <input type="email" class="form-control" id="basic-mail" name="email" placeholder="johnd@outwardbound.com.au" aria-describedby="basic-addon2">
		  <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-envelope"></span> E-Mail</span>
		</div>
		<label for="basic-title">Title</label>
		<div class="input-group input-group-lg">
		  <input type="text" class="form-control" id="basic-title" name="title" placeholder="Title" aria-describedby="basic-addon">
		  <span class="input-group-addon" id="basic-addon">Title</span>
		</div>
		<label for="msg">Your message</label>
		<textarea id="msg" class="form-control" name="text" style="height:250px!important;"></textarea>
		<br>
		<button class="btn btn-lg btn-info" type="submit"><span class="glyphicon glyphicon-send"></span> Send</button>
		</form>
	</div>
</div>
