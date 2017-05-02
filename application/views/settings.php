<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @file settings.php
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
 * Settings page
 * 
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
 ?>
<!-- webpage content --->
<div class="container" id="settings">
	<div class="row">
		<div class="page-header">
			<h1><span class="glyphicon glyphicon-wrench"></span> Settings <small>Global Settings</small> </h1>
		</div>
	</div>
<?php echo form_open('backend/settings/'); ?>
	<!-- show all settings -->
<div class="panel panel-default row">
	<div class="panel-heading">General Settings:</div>
  <div class="panel-body">
		<div class="input-group">
		  <span class="input-group-addon" id="baseUrl">Base Url</span>
		  <input type="text" class="form-control" name="base_url" placeholder="http://localhost/" value="<?php echo $base_url->content;?>" aria-describedby="baseUrl">
		</div>
		<br>
		<div class="input-group">
		  <span class="input-group-addon" id="PageName">Page Name</span>
		  <input type="text" class="form-control" name="pagename" placeholder="Kitchen Helper" value="<?php echo $pagename->content;?>" aria-describedby="PageName">
		</div>
		<br>
		<div class="input-group">
		  <span class="input-group-addon" id="ltdatabaserest">Last Database reset</span>
		  <input type="text" class="form-control disabled" disabled name="lastdbreset" value="<?php echo $lastdbreset->content;?>"  aria-describedby="ltdatabasereset">
		</div>
		<br>		
		<div class="input-group">
		  <span class="input-group-addon" id="LogoUrl">Logo Url</span>
		  <input type="text" class="form-control" name="LogoUrl" placeholder="http://localhost/images/logo.png" value="<?php if(property_exists($LogoUrl,"content")){echo $LogoUrl->content;}?>"  aria-describedby="LogoUrl">
		</div>
		<br>		
		<div class="input-group">
		  <span class="input-group-addon" id="EMailAddress">System E-Mail Address Domain</span>
		  <input type="text" class="form-control" name="EMailAddress" placeholder="false" value="<?php if(property_exists($EMailAddress,"content")){echo $EMailAddress->content;}?>"  aria-describedby="EMailAddress">
		</div>
		<br>		
		<div class="input-group">
		  <span class="input-group-addon" id="sendMail">Sending of E-Mail endabled</span>
		  <input type="text" class="form-control" name="sendMail" placeholder="false" value="<?php if(property_exists($sendMail,"content")){echo $sendMail->content;}?>"  aria-describedby="sendMail">
		</div>
		<br>
		<div class="input-group">
		  <span class="input-group-addon" id="PasswordName">CC Password</span>
		  <input type="text" class="form-control" name="password" placeholder="CCS Password"  aria-describedby="PasswordName">
		</div>
		<p class="text-danger">Password will be not shown there!</p>
  </div>
</div> <!-- / panel -->
<div class="panel panel-default row">
	<div class="panel-heading">Help texts:</div>
  <div class="panel-body">
	  <?php
	  if(is_array($helptexts->content)){
	  foreach($helptexts->content as $helptext){
		  ?>
		  <strong><?php echo $helptext->name;?>:</strong>
		  <?php
		  foreach($helptext->data as $key =>$content){
		  ?>
		<div class="input-group">
		  <span class="input-group-addon" id="<?php echo $key;?>"><?php echo $content->name;?></span>
		  <input type="text" class="form-control" name="<?php echo $key;?>"  value="<?php echo $content->content;?>" aria-describedby="<?php echo $key;?>">
		</div>
		<br>
	<?php
	}}}
	?>
  </div>
</div> <!-- / panel -->
 <div class="row"><hr>
 <input class="btn btn-info" type="submit" name="submit" value="Save"></form></div>
</div><!-- end page -->


