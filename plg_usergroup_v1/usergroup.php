<?php
/**
* @package      EasySocial
* @copyright    Copyright (C) 2010 - 2014 Stack Ideas Sdn Bhd. All rights reserved.
* @license      GNU/GPL, see LICENSE.php
* EasySocial is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');

// Include the fields library
FD::import( 'admin:/includes/apps/apps' );
require_once( JPATH_ADMINISTRATOR . '/components/com_easysocial/includes/foundry.php' );

// Include helper file.
FD::import('admin:/includes/fields/dependencies');
FD::import('fields:/user/usergroup/helper');

// Get the current logged in user

class SocialFieldsUserUserGroup extends SocialFieldItem
{
    public function onRegister(&$post, &$registration)
    {
    	$params = $this->field->getApp()->getParams();
    	$fieldParams = $this->field->getParams();
		$defaultList = $fieldParams->get('default');
		
    	$all_user_groups = SocialFieldsUserUsergroupHelper::getAllUserGroups($defaultList);
        //$this->set('allusergroups', $all_user_groups);?>
        <div data-field-usergroup>
        <div class="form-group" data-field="" data-field-4="" data-sample-field="" data-sample-field-4="">
        <label class="col-sm-3 control-label" for="es-fields-8"><?php echo $fieldParams->get('title');?>:</label>
        <div class="col-sm-9 data">
		<?php if($selgroupid){ foreach($all_user_groups as $aug){?>
			<input style="vertical-align:sub;" type="checkbox" name="vusergroup[]" <?php if(in_array($aug->id,$selgroupid)){?>checked<?php }?> value="<?php echo $aug->id;?>"><?php echo " ".$aug->title;?><br>
		<?php }}else{ foreach($all_user_groups as $aug){?>
			<input style="vertical-align:sub;" type="checkbox" name="vusergroup[]" value="<?php echo $aug->id;?>"><?php echo " ".$aug->title;?><br>
		<?php }}?>
		</div><div class="col-sm-8 col-sm-offset-3" data-display-description="">
			<div class="help-block fd-small text-note">
				<strong>Note:</strong> <span data-description=""><?php echo $fieldParams->get('description');?>.</span>
			</div>
		</div></div></div><br><br>
    <?php }
	public function onEdit(&$post, &$user, $errors)
    {
    	$params = $this->field->getApp()->getParams();
    	$fieldParams = $this->field->getParams();
		$defaultList = $fieldParams->get('default');
        $all_user_groups = SocialFieldsUserUsergroupHelper::getAllUserGroups($defaultList);
        $sel_user_groups = SocialFieldsUserUsergroupHelper::getSelUserGroups($user->id);
        $slug = array();
        foreach ($sel_user_groups as $selg){
        	array_push($slug, $selg->cluster_id);
        }
        //$this->set('allusergroups', $all_user_groups);
        //$this->set('selgroupid', $slug);
        ?>
        <div data-field-usergroup>
        <div class="form-group" data-field="" data-field-4="" data-sample-field="" data-sample-field-4="">
        <label class="col-sm-3 control-label" for="es-fields-8"><?php echo $fieldParams->get('title');?>:</label>
        <div class="col-sm-9 data">
		<?php if($slug){ foreach($all_user_groups as $aug){?>
			<input style="vertical-align:sub;" type="checkbox" name="vusergroup[]" <?php if(in_array($aug->id,$slug)){?>checked<?php }?> value="<?php echo $aug->id;?>"><?php echo " ".$aug->title;?><br>
		<?php }}else{ foreach($all_user_groups as $aug){?>
			<input style="vertical-align:sub;" type="checkbox" name="vusergroup[]" value="<?php echo $aug->id;?>"><?php echo " ".$aug->title;?><br>
		<?php }}?>
		</div><div class="col-sm-8 col-sm-offset-3" data-display-description="">
			<div class="help-block fd-small text-note">
				<strong>Note:</strong> <span data-description=""><?php echo $fieldParams->get('description');?>.</span>
			</div>
		</div></div></div><br><br>
    <?php }
    public function onEditAfterSave(&$post, &$user)
    {
    	$db 	= FD::db();
		$sql	= $db->sql();
		$sql->delete( '#__social_clusters_nodes' );
		$sql->where( 'uid' , $user->id );
		$db->setQuery( $sql );
		$state	= $db->Query();
		
	    $ugarray = json_decode($user->vusergroup);
	    if(count($ugarray) > 0){
	    	foreach ($ugarray as $pug){
	    		$sql->clear();
	    		$sql->insert('#__social_clusters_nodes');
				$sql->values('cluster_id', $pug);
				$sql->values('type', 'user');
				$sql->values('uid', $user->id);
				$sql->values('state', '1');
				$sql->values('owner', '0');
				$sql->values('admin', '0');
				$sql->values('invited_by', '0');
				$sql->values('created', date('Y-m-d H:i:s'));
				$db->setQuery($sql);
				$db->Query();
	    	}
    	}
    }
	public function onSample()
    {
    	$params = $this->field->getApp()->getParams();
    	$fieldParams = $this->field->getParams();
		$defaultList = $fieldParams->get('default');
		$all_user_groups = SocialFieldsUserUsergroupHelper::getAllUserGroups($defaultList);
    	$all_user_groups2 = SocialFieldsUserUsergroupHelper::getAllUserGroups('vicky0');?>
        <div data-field-usergroup>
        <div class="form-group" data-field="" data-field-4="" data-sample-field="" data-sample-field-4="">
        <label class="col-sm-3 control-label" for="es-fields-8"><?php echo $fieldParams->get('title');?>:</label>
        <div class="col-sm-9 data">
			<?php foreach($all_user_groups as $aug){?>
				<input style="vertical-align:sub;" type="checkbox" name="vusergroup[]" value="<?php echo $aug->id;?>"><?php echo " ".$aug->title;?><br>
			<?php }?>
		</div>
        <div class="col-sm-8 col-sm-offset-3" data-display-description="">
			<div class="help-block fd-small text-note">
				<strong>Note:</strong> <span data-description=""><?php echo $fieldParams->get('description');?>.</span>
			</div>
		</div>
        </div>
        <div class="col-sm-12 data"><b>Available Groups are:</b></div>
        <div class="col-sm-12 data">
        	<?php foreach($all_user_groups2 as $aug2){?>
        		<span style="font-size:11px;float:left;padding:2px 4px;border:1px solid;margin:2px;"><?php echo $aug2->title.' : <b>'.$aug2->id.'</b>';?></span>
        	<?php }?>
        </div>
        </div>
    <?php }
    public function onRegisterAfterSave(&$post, &$user)
    {
    	$ugarray = json_decode($user->vusergroup);
    	if(count($ugarray) > 0){
	    	$db 	= FD::db();
			$sql 	= $db->sql();
	    	foreach ($ugarray as $pug){
	    		$sql->clear();
	    		$sql->insert('#__social_clusters_nodes');
				$sql->values('cluster_id', $pug);
				$sql->values('type', 'user');
				$sql->values('uid', $user->id);
				$sql->values('state', '1');
				$sql->values('owner', '0');
				$sql->values('admin', '0');
				$sql->values('invited_by', '0');
				$sql->values('created', date('Y-m-d H:i:s'));
				$db->setQuery($sql);
				$db->Query();
	    	}
    	}
    }
}
