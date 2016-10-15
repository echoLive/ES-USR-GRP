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

class SocialFieldsUserUsergroupHelper
{
    public static function getAllUserGroups($ds)
    {
        $db 		= FD::db();
		$sql 		= $db->sql();
		
		if(trim($ds) != '' && $ds != 'vicky0'){
			$dslist 	= explode(',',trim($ds));
		}
		
		$sql->select( '#__social_clusters' );
		$sql .= ' WHERE';
		if(isset($dslist)){
			foreach ($dslist as $d){
				if($d != ''){
					$sql .= ' id="'.$d.'" OR';
				}
			}
			$sql = rtrim($sql,' OR');
			$sql .= ' AND';
		}
		$sql .= ' state="1"';
		$db->setQuery( $sql );
		$result	= $db->loadObjectList();
		return $result;
    }
    public static function getSelUserGroups($uid){
    	$db 		= FD::db();
		$sql 		= $db->sql();

		$sql->select( '#__social_clusters_nodes' );
		$sql->where( 'uid' , $uid );
		$sql->where( 'state' , '1' );

		$db->setQuery( $sql );
		$result	= $db->loadObjectList();
		return $result;
    }
}
