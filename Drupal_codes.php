****************  Fields Collection    *******************

<?php $fc_fields = field_get_items('node', $about_page, 'field_about_tabs');
    $ids = array();
    foreach ($fc_fields as $fc_field) {
     $ids[] = $fc_field['value'];
    }
    $collections = field_collection_item_load_multiple($ids);
    if($collections):  $class = ' class="active"';?>
                <ul class="tabset">
                 <?php foreach ($collections as $i => $collection) {
      $collection = $collections [$i]; $tab_title;
      foreach($collection as $key => $value) {?>
      <?php if (strpos ($key, 'field') !== false) {?>
       <?php if (isset($value['und']) && $key=='field_tabs_title' && is_array($value ['und']) && isset($value['und'][0]['value'])) {
          $tab_title .= strtolower(
          str_replace(' ','-',($value['und'][0]['value']))).' ';
          echo '<li><a '.$class.' href="#'.strtolower(
          str_replace(' ','-',($value['und'][0]['value']))).'">'.$value['und'][0]['value'].'</a></li>'; $class = '';
        
       }?>
      <?php }
                     }
     }?>
                </ul>
$field_info_title = $node->field_info_title['und'][0]['value']; 
    $field_supporting_info_title = $node->field_supporting_info_title['und'][0]['value']; 
    $fc_fields = field_get_items('node', $node, 'field_essential_info');
    $ids = array();
    foreach ($fc_fields as $fc_field) {
     $ids[] = $fc_field['value'];
    }
    
    
****************************************************


************************ Page Template   **********************

$node = $vars['node'];
 if ($node->field_template) {
  $template_name= $node->field_template['und'][0]['value'];
  $vars['theme_hook_suggestions'][] = 'page__'.$template_name;
 }
 
 elseif (isset($vars['node']->type)) {
  $vars['theme_hook_suggestions'][] = 'page__' . $vars['node']->type;
 }
 
 
****************************************************************



*********************  Field Collection   ***************************


<?php $fc_fields = field_get_items('node', $node, 'field_essential_info');
    $ids = array();
    foreach ($fc_fields as $fc_field) {
     $ids[] = $fc_field['value'];
    }
    $collections = field_collection_item_load_multiple($ids);
    if($collections):?>
     <section class="orange-list">
                    <h2>Essential Safety Information</h2>
                        <ul>
                        <?php for ($i = 1; $i <= sizeof($collections); $i++) {
                                $collection = $collections [$i];
                                echo '<li>';
        $link = $button_label = $file_attach = $field_external_links = '';
                                foreach($collection as $key => $value) {

                                    if (strpos ($key, 'field') !== false) {
                                       if (isset($value['und']) && $key=='field_link_title' && is_array($value ['und']) && isset($value['und'][0]['value'])) {
                                           echo $value['und'][0]['value']; 
                                            
                                        }
          if (isset($value['und']) && $key=='field_button_label' && is_array($value ['und']) && isset($value['und'][0]['value'])) {
                                            $button_label =  $value['und'][0]['value']; 
                                            
                                        }
          if (isset($value['und']) && $key=='field_file_attach') {
                                           $file_attach = file_create_url($value['und'][0]['uri']);
             if(!$button_label) $button_label = 'Download';
              $link = '<a href="'.$file_attach.'" class="button" target="_blank">'.$button_label.'</a>';
                                            
                                        }
          elseif (isset($value['und']) && $key=='field_external_links' && is_array($value ['und']) && isset($value['und'][0]['value'])) {
           global $popupid; $popupid++;
             if(!$button_label) $button_label = 'View';
                                           $field_external_links = $value['und'][0]['value'];
             $link = '<a href="#popup'.$popupid.'" class="button lightbox">'.$button_label.'</a>';
             global $popup;
             
                                            
                                        }
          echo $link;
                                    }
                                } 
                                echo '</li>';  
                            } ?>
                     </ul>
     </section>
    <?php endif;?>





foreach ($collections as $i => $collection) {
        //for ($i = 1; $i <= sizeof($collections); $i++) {
                                //$collection = $collections [$i];
                                echo '<li>';
        $link = $button_label = $file_attach = $field_external_links = '';
                                foreach($collection as $key => $value) {
                                
                                
                                
                                

***********************************************************************************************
