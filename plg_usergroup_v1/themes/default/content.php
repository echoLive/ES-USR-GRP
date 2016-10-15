<?php
	defined( '_JEXEC' ) or die( 'Unauthorized Access' );
?>
<div data-field-usergroup>
<?php if($selgroupid){ foreach($allusergroups as $aug){?>
	<input type="checkbox" name="vusergroup[]" <?php if(in_array($aug->id,$selgroupid)){?>checked<?php }?> value="<?php echo $aug->id;?>"><?php echo $aug->title;?><br>
<?php }}else{ foreach($allusergroups as $aug){?>
	<input type="checkbox" name="vusergroup[]" value="<?php echo $aug->id;?>"><?php echo $aug->title;?><br>
<?php }}?>
</div>
