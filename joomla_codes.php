<?php

function countModules($position) {
  $document = JFactory::getDocument();
  $renderer = $document->loadRenderer('module');
  $modules = JModuleHelper::getModules($position);
  
  return is_array($modules) ? count($modules) : 0;
 }
 
 function loadPosition($position, $style = 'none') {
  $document = JFactory::getDocument();
  $renderer = $document->loadRenderer('module');
  $modules = JModuleHelper::getModules($position);
  $params  = array('style' => $style);
  
  foreach ($modules as $module) {
   echo $renderer->render($module, $params);
  }
 }
 
 
 
 
 
JLoader::register('fieldattach', 'components/com_fieldsattach/helpers/fieldattach.php'); 
echo $_image = fieldattach::getImg(JRequest::getVar('id'), 4); 
$view = JRequest::getVar('view');
$layout = JRequest::getVar('layout');
$option = JRequest::getVar('option');
$pageclass_sfx = '';
if($option == 'com_content' && $view=='article' && !$tpl->is_home()){
	
	
}


?>


<?php $document = &JFactory::getDocument();
          $renderer = $document->loadRenderer('modules');
          $options = array('style' => 'products');
          $position = 'breadcrumb';
          echo $renderer->render($position, $options, null); ?>
		  
          
          



<?php
  $itemid = JRequest::getVar('Itemid');
  $menu = &JSite::getMenu();
  $active = $menu->getItem($itemid);
  $params = $menu->getParams( $active->id );
  $pageclass = $params->get( 'pageclass_sfx' );
?>




<?php 
$db=& JFactory::getDBO();    
$db->setQuery("SELECT * FROM #__attachments WHERE parent_id = ".JRequest::getVar('id'));
$thumbnails = $db->loadObjectList();    
if ($thumbnails)
{ ?>
<ul class="large-img">
 <?php foreach($thumbnails as $thumbnail) { ?>
<li><a href="#"><img src="<?php echo $thumbnail->url; ?>" alt="<?php echo $thumbnail->description; ?>" /></a></li>
    <?php }?>
</ul>
<?php }?>





<?php
$username =& JFactory::getUser();
 if ($username->guest) {
 echo '<a href="http://www.yoursite.com/index.php?option=com_user&view=login" >Login</a>';
  } else {
  $name = $username->get('username'); 
  echo 'Hi ' . $name . ' -  <a href="http://www.yoursite.com/index.php?option=com_user&task=logout" >Logout</a>';
  }

$username =& JFactory::getUser();
        if ($username->guest)
        {
         echo '<a class="login" href="'.$tpl->base_url().'index.php/component/users/?view=login" >Acceso</a>';
        }
        else
        {
         $logout = JRoute::_('index.php?option=com_users&amp;task=user.logout').'&amp;'.JUtility::getToken().'=1'; 
         echo '<a class="login" href="'.$logout.'" >Logout</a>';
        }
       ?>
	   
       
       


Render The Module in template 

<?php $document = &JFactory::getDocument();
          $renderer = $document->loadRenderer('modules');
          $options = array('style' => 'products');
          $position = 'products';
          echo $renderer->render($position, $options, null); ?>
		  
          

<?php
$menu = JSite::getMenu();
$parent = $menu->getItem($menu->getActive()->parent)->name;
$menu = &JSite::getMenu();
$active = $menu->getActive();
$pageName = $active->title;  //the current pages’ name
$parentId = $active->tree[0];
$parentName = $menu->getItem($parentId)->title;





How to call the fields attach in Module

Jloader::register('fieldattach', 'components/com_fieldsattach/helpers/fieldattach.php'); 

echo fieldattach::getValue($item->id, 2));


?>