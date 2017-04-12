// Featured Image
 <?php if(has_post_thumbnail()): ?><?php the_post_thumbnail('slider-post-thumbnail'); ?><?php endif; ?>
 <?php if(has_post_thumbnail()): ?><?php the_post_thumbnail('page-post-thumbnail', array('class' => 'alignright')); ?><?php endif; ?>

// Large image
<?php 
 if ( has_post_thumbnail()) {
   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
   echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
   echo get_the_post_thumbnail($post->ID, 'thumbnail'); 
   echo '</a>';
 }
?>

<?php  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;  ?>

<?php

		**********************  Twitter for Wordpress   **************************************
		
$messages = fetch_rss('https://api.twitter.com/1/statuses/user_timeline.rss?screen_name='.$username);

?>

<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" class="author"><?php the_author_meta('display_name'); ?></a>

<?php
global $withcomments;
$withcomments = 1;
comments_template( 'comments.php', true );


///////////////  Remove and Add auto P filter     ///////////////////////
remove_filter( 'the_content', 'wpautop' ); add_filter('the_content', 'wpautop', 9999, 2);
?>

<?php
// add title in widget filter
function theme_widget_title_filter($title){
    $title = str_replace(array('[',']','&#039;'),array('<','>','"'),$title);
    return $title;
}
add_filter('widget_title', 'theme_widget_title_filter');

?>

**************  Page options URL  ******************
http://codex.wordpress.org/Option_Reference
<?php get_option('page_for_posts');
      get_option('page_on_front'); 
 ?>
***********************************


<?php $arc_year = get_the_time('Y'); ?>
  <?php $arc_month = get_the_time('m'); ?>
  <?php $arc_day = get_the_time('d'); ?>
<li> <span>Date</span><a href="<?php echo get_day_link($arc_year, $arc_month, $arc_day); ?>">

<?php   
            $attachments = get_children(array('post_parent' => $post->ID,
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
			'order' => 'asc',
			'orderby' => 'menu_order'));
                          
            if($attachments)
            {?>
            <div class="visual">
                <h2>Produktfoton:</h2>
            <?php
            foreach($attachments as $att_id => $attachment) 
            {?>
                <div class="frame"><a href="<?php echo wp_get_attachment_url($attachment->ID) ?>" rel="gallery"><?php echo wp_get_attachment_image($attachment->ID, 'custom-thumbnail');?><span class="zoom"></span></a></div>
          <?php } ?>
                        
        </div>
        <?php }
		
		
		
		/////////////////  Attachment Function code  start   //////////////////////////
		
		//////////   pu this function in functions.php
		
		function my_attachment_image($post_id=0) {
		 if ($post_id<1) {
				$post_id = get_the_ID();
			}
		 $featured_image_id = get_post_thumbnail_id( $post_id );
		 if ($images = get_children(array(
		  'post_parent' => $post_id,
		  'post_type' => 'attachment',
		  'post_mime_type' => 'image',
		  'post__not_in' => array($featured_image_id),
		  'orderby' => 'menu_order',
		  'order' => 'ASC'
		  )))
			{
				echo '<ul class="gallery">';
				foreach($images as $image) {
				$attachment=wp_get_attachment_image_src($image->ID, 'gallery-prewiev');
				$attachment_full=wp_get_attachment_image_src($image->ID, 'gallery-full'); ?>
				<li>
					<a href="#"><img src="<?php echo $attachment[0]; ?>" width="175" height="128" alt="image description"></a>
					<a rel="lightbox[gallery1]" title="<?php echo $image->post_content; ?>" class="text" href="<?php echo $attachment_full[0]; ?>">VIEW IMAGE</a>
				</li><?php
				}
				echo '</ul>';
			}
		}
		
		
		////////////////  End of functions .php   ///////////////////////////
		
		
		///  cal the function 
		
		echo my_attachment_image();
		
		
		//////////////////
		
		
		
		
		
		?>



//  JQuery
<?php wp_enqueue_script('jquery'); ?>




<?php
        	if(function_exists('bcn_display_list'))
			{
				echo '<div class="breadcrumbs-holder"><ul class="breadcrumbs">';
				echo '<li><a href="'.get_bloginfo('url').'" class="home"></a></li>' ;
				bcn_display_list();
				echo '</ul></div>' ;
			}
		?>


/// call posts from specific custom taxonomy

<?php $args = array('post_type' => 'gallery','tax_query' => array( array('taxonomy' => 'Gallery1_Taxonomies','field' => 'id','terms' =>Gallery1CategoryID)));
query_posts($args);
 ?>
 
 // list of all taxonomies
 <?php
$taxonomy = 'Gallery1_Taxonomies';
$tax_terms = get_terms($taxonomy);
?>
<ul class="sub-nav">
<?php
foreach ($tax_terms as $tax_term) {?>
<li><a href="<?php echo esc_attr(get_term_link($tax_term, $taxonomy)); ?>"><span><?php echo $tax_term->name; ?></span></a></li>
<?php } ?>
</ul>
 


<?php

function new_excerpt_length($length) {
	return 40;
}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($more) {
       global $post;
	return '<a href="'. get_permalink($post->ID) . '" class="btn-more">More</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

?>





<?php echo str_replace(array('[site-url]','[template-url]'),array(get_bloginfo('url'),get_bloginfo('template_url')),$_img); ?>



<?php //******************************************************************************************************************************** ?>
   <?php  add page expert filter ?>


<?php add_post_type_support( 'page', 'excerpt' ); ?>

<?php //******************************************************************************************************************************** ?>




<?php  // ********************************************* Twitter Messages ****************************************?>
			
            // add conde in widget.php
            
 <?php 
 
 class Widget_Twitter_Messages extends WP_Widget {
 function Widget_Twitter_Messages() {
  $widget_ops = array('description' => __( "Widget Description." ), 'classname' => 'widget-twitter-messages' );
  $this->WP_Widget('twitter-messages', __('Custom Twitter Messages'), $widget_ops);
 }
 function widget($args, $instance) {
  extract( $args );
  $title = apply_filters('widget_title', empty($instance['title']) ? false : $instance['title']);
  $username = empty($instance['username']) ? 'username' : $instance['username'];
  $num = empty($instance['num']) ? 1 : intval($instance['num']);
  echo $before_widget;
  //echo '<h2><span>Get</span> talking...</h2><div class="twitter-holder"><div class="twitter-frame"><div class="twitter-content"><div class="heading"><strong class="title">@ESOF2012</strong><span class="sub-title">#esof2012</span></div>';  
  custom_twitter_messages($username,$num);
  //echo '</div></div></div>';
  echo $after_widget;
 }
 function update($new_instance, $old_instance) {
  return $new_instance;
 }
 function form($instance) {
  $title = esc_attr($instance['title']);
  $username = esc_attr($instance['username']);
  $num = esc_attr($instance['num']);
  ?>
   <p><label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e('Title:'); ?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
   </label></p>
   <p><label for="<?php echo $this->get_field_id('username'); ?>">
    <?php _e('Username:'); ?>
    <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" />
   </label></p>
   <p><label for="<?php echo $this->get_field_id('num'); ?>">
    <?php _e('Number of items:'); ?>
    <input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo $num; ?>" size="2" />
   </label></p>
  <?php
 }
}
add_action('widgets_init', create_function('', 'return register_widget("Widget_Twitter_Messages");'));

 ?>    
 
 
 <?php end widget.php code                  ?>       
 
 
 <?php    put data in functions.php      ?>
 
 <?php
 
 function custom_twitter_messages($username = '', $num = 1){
	 
  define('MAGPIE_CACHE_ON', true);
  define('MAGPIE_CACHE_AGE', 8000);
  define('MAGPIE_INPUT_ENCODING', 'UTF-8');
  define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');
  define('MAGPIE_FETCH_TIME_OUT', 15);
  
 global $twitter_options;
 include_once(ABSPATH . WPINC . '/rss.php'); 
 //$messages = fetch_rss('http://twitter.com/statuses/user_timeline/'.$username.'.rss');  
 $messages = fetch_rss('https://api.twitter.com/1/statuses/user_timeline.rss?screen_name='.$username);
 if ($username == '') {
  echo '<div class="twitter-box"><p>';
   echo 'RSS not configured';
  echo '</p></div>';
 } else {
  if ( empty($messages->items) ) {
   echo '<div class="twitter-box"><p>';
    echo 'No public Twitter messages.';
   echo '</p></div>';
  } else {
   $i = 0;
   foreach($messages->items as $message){
    $msg = " ".substr(strstr($message['description'],': '), 2, strlen($message['description']))." ";
    $link = $message['link'];
    $msg = hyperlinks($msg);
    $msg = twitter_users($msg);
    echo '<p>'. $msg .'<a href="'. $link .'">'.$username.'</a></p>';
    $time = strtotime($message['pubdate']);
    echo '<em class="date">'. date('g:i d/m/y',$time) .'</em>';
    $i++;
    if($i >= $num) break;
   }
  }
 } 
}




//    and also first delete the twitter plugin and then copy data from twitter.php and paste it in functions.php
 
 ?>
 
 <?php end function.php data  ?>
            

<?php *************************************** end  Twitter Messages ***********************************************************?>








<?php

// start get Custom Field data in sidebar.php
global $wp_query; $_object = $wp_query->queried_object; 
in $_object you will have an object of current page or post, now you can use $_object->ID to use in get_post_meta() Function
// End get Custom Field data in sidebar.php





//Custom Post Type Lables
$labels = array(
  'name' => _x('Slider', 'post type general name'),
  'singular_name' => _x('Slide', 'post type singular name'),
  'add_new' => _x('Add New', 'Slide'),
  'add_new_item' => __('Add New Slide'),
  'edit_item' => __('Edit Slide'),
  'new_item' => __('New Slide'),
  'view_item' => __('View Slides'),
  'search_items' => __('Search Slides'),
  'not_found' =>  __('Nothing found'),
  'not_found_in_trash' => __('Nothing found in Trash'),
  'parent_item_colon' => ''
 );

//Custom Post Type Arguments 
 $args = array(
  'labels' => $labels,
  'public' => true,
  'has_archive' => true,
  'publicly_queryable' => true,
  'show_ui' => true,
  'query_var' => true, 
  'rewrite' => true,
  'capability_type' => 'post',
  'hierarchical' => true,
  'menu_position' => null,
  'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields'  )
   ); 

//Register Custom Post Type.   
 register_post_type( 'slider' , $args );
 
 
$getposts = new WP_Query( array( 'post_type' => 'spotlight'));
if($getposts->have_posts()):
while( $getposts->have_posts() ) : $getposts->the_post();




////////////////    Start Code of Meta Box   //////////////////////


function theme_meta_box() {
    if ( function_exists('add_meta_box') ){
        add_meta_box('related_id_1', 'Select Category', 'related_posts_field_1', 'post');        
    }
}

function related_posts_field_1() {
    global $post;
    $posts = array();
    $original_post = $post;
    $selected_category = get_post_meta( $post->ID, 'selected_category', true);

   $terms = get_categories('hide_empty=0');
   $count = count($terms);?>
 <p> 
        <?php if($terms): ?>
            <select name="selected_category" id="selected_category">
            <?php foreach ( $terms as $term ): ?>
             <?php if(trim($selected_category)==trim($term->name)) $selected = 'selected="selected"'; else $selected = '';?>
                <option value="<?php echo $term->name;?>"<?php echo $selected ;?>><?php echo $term->name;?></option>
            <?php endforeach;?>
            </select>
        <?php endif;?>
 </p>
    <?php
}

add_action('save_post', 'theme_insert_post');
function theme_insert_post($post_id) {
    
    if ($_POST['selected_category'])
        update_post_meta($post_id, 'selected_category', $_POST['selected_category']);
    else
        delete_post_meta($post_id, 'selected_category');   
        
}

add_action('admin_menu', 'theme_meta_box');




////////////////////    End of Meta box Code    ////////////////////////////



//////////////    Filter to change next abd previous links class of navigation    ////////////////////

add_filter('next_post_link','add_css_class_to_next_post_link');
function add_css_class_to_next_post_link($link) {
$link = str_replace("<a ", "<a class='next'  ", $link);
return $link;
}

add_filter('previous_post_link','add_css_class_to_prev_post_link');
function add_css_class_to_prev_post_link($link) {
$link = str_replace("<a ", "<a class='previous'  ", $link);
return $link;
}


                   OR try another code
				   
add_filter('next_posts_link_attributes', 'posts_link_next_class');
function posts_link_next_class() {
    return 'class="next-paginav paginav"';
} 
add_filter('previous_posts_link_attributes', 'posts_link_prev_class');
function posts_link_prev_class() {
    return 'class="prev-paginav paginav"';
}




/////////////////////////////////////////////////////////////////////////////////





//featured pages widget start from here
class Custom_Widget_Feature_Page extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'custom_widget_feature_page', 'description' => __( "Display the Feature page") );
        parent::__construct('feature-page', __('Display Feature Page'), $widget_ops);
        $this->alt_option_name = 'custom_widget_feature_page';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('custom_widget_feature_page', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);

        $r = new WP_Query(array('post_type' => 'page', 'p' => $instance['page'], 'no_found_rows' => true, 'post_status' => 'publish'));
        if ($r->have_posts()) :
?>
<?php echo $before_widget; ?>
<?php if ( $title ) echo $before_title . $title . $after_title; ?>

<?php  while ($r->have_posts()) : $r->the_post(); ?>
<?php if (has_post_thumbnail(get_the_ID())) : ?>
<article class="box">
    <div class="image-box">
        <div class="holder">
        <?php the_post_thumbnail(get_the_ID()); ?>
    </div>
      </div>
    <?php endif; ?>  
<h3><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></h3>
<?php endwhile; ?>
</article>
<?php echo $after_widget; ?>
<?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('custom_widget_feature_page', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);       
        $instance['page'] = (int) $new_instance['page'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['custom_widget_feature_page']) )
            delete_option('custom_widget_feature_page');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('custom_widget_feature_page', 'widget');
    }

    function form( $instance ) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $page = $instance['page'];
?>
<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

<p>
<label>
<?php _e( 'Pages' ); ?>:
<?php wp_dropdown_pages( array( 'name' => $this->get_field_name("page"), 'selected' => $instance["page"] ) ); ?>
</label>
</p>
<?php
    }
}

add_action('widgets_init', create_function('', 'return register_widget("Custom_Widget_Feature_Page");'));


*******************  End of widget  **********************************




.....................  qtranslate ------------------------------------------


 if(function_exists('qtrans_generateLanguageSelectCode')) echo custom_qtrans_generateLanguageSelectCode();
 
 
function custom_qtrans_generateLanguageSelectCode($style='', $id='') {
 global $q_config;
 if($style=='') $style='text';
 if(is_bool($style)&&$style) $style='image';
 if(is_404()) $url = get_option('home'); else $url = '';
 if($id=='') $id = 'qtranslate';
 $id .= '-chooser';
 switch($style) {
  case 'image':
  case 'text':
  case 'dropdown':
   echo '<ul class="language" id="'.$id.'">';
   foreach(qtrans_getSortedLanguages() as $language) {
    $classes = array('lang-'.$language);
    if($language == $q_config['language'])
     $classes[] = 'active';
    echo '<li class="'. implode(' ', $classes) .'"><a href="'.qtrans_convertURL($url, $language).'"';
    // set hreflang
    echo ' hreflang="'.$language.'" title="'.$q_config['language_name'][$language].'"';
    if($style=='image')
     echo ' class="qtrans_flag qtrans_flag_'.$language.'"';
    echo '><span';
    if($style=='image')
     echo ' style="display:none"';
    echo '>'.$q_config['language_name'][$language].'</span></a></li>';
   }
   echo "</ul><div class=\"qtrans_widget_end\"></div>";
   if($style=='dropdown') {
    echo "<script type=\"text/javascript\">\n// <![CDATA[\r\n";
    echo "var lc = document.getElementById('".$id."');\n";
    echo "var s = document.createElement('select');\n";
    echo "s.id = 'qtrans_select_".$id."';\n";
    echo "lc.parentNode.insertBefore(s,lc);";
    // create dropdown fields for each language
    foreach(qtrans_getSortedLanguages() as $language) {
     echo qtrans_insertDropDownElement($language, qtrans_convertURL($url, $language), $id);
    }
    // hide html language chooser text
    echo "s.onchange = function() { document.location.href = this.value;}\n";
    echo "lc.style.display='none';\n";
    echo "// ]]>\n</script>\n";
   }
   break;
  case 'both':
   echo '<ul class="qtrans_language_chooser" id="'.$id.'">';
   foreach(qtrans_getSortedLanguages() as $language) {
    echo '<li';
    if($language == $q_config['language'])
     echo ' class="active"';
    echo '><a href="'.qtrans_convertURL($url, $language).'"';
    echo ' class="qtrans_flag_'.$language.' qtrans_flag_and_text" title="'.$q_config['language_name'][$language].'"';
    echo '><span>'.$q_config['language_name'][$language].'</span></a></li>';
   }
   echo "</ul><div class=\"qtrans_widget_end\"></div>";
   break;
 }
}







....................  Exclude category posts from archive page  .................

global $wpdb;
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
query_posts(
	array_merge(
		array
		(
			'category__in' => array($cat),
			'category__not_in' => array(3,4),
			'paged' => $paged
		), $wp_query->query
	)
);






function get_dynamic_sidebar($index = 1)
{
$sidebar_contents = "";
ob_start();
dynamic_sidebar($index);
$sidebar_contents = ob_get_clean();
return $sidebar_contents;
}




function filter_template_contact_form($text) {
	$starting_year = 1950;
	$currentyear = date('Y');
	$newtext = "" ;
	while($starting_year <= $currentyear)
	{
		$newtext .= '<option value="'.$starting_year.'">'.$starting_year.'</option>' ;
		$starting_year++;
	}
	
	$finding_text = '<option value="yearlist">yearlist</option>' ;
 return str_replace($finding_text,$newtext, $text);
}

add_filter('the_content', 'filter_template_colum1_open');







*****************    author role  *********************************
$user = new WP_User( $post->post_author ); 
echo $user->roles[0];




******************   relative time    ********************
<?php $time = strtotime(get_the_time());
       if ( ( abs( time() - $time) ) < 86400 )
        $h_time = sprintf( __('%s ago'), human_time_diff( $time ) );
       else
      $h_time = date(__('Y/m/d'), $time);
      ?>

or ------------
recommended
<?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>


<?php
**********************************  parent page title for second level items  ****************************************************

function parent_title($location) {
 $locations = get_nav_menu_locations();
 if (isset( $locations[ $location ] )) {
  $menu = wp_get_nav_menu_object( $locations[ $location ] );
  if ($menu) {
   $menu_items = wp_get_nav_menu_items( $menu->term_id );
   
   _wp_menu_item_classes_by_context($menu_items);
   
   $current_item = null;
   
   foreach ($menu_items as $menu_item) {
    if (in_array('current-menu-item', $menu_item->classes)) {
     $current_item = $menu_item;
     break;
    }
   }
   
   if ($current_item) {
    $parent_item = $current_item;

    while ($parent_item->menu_item_parent) {
     foreach ($menu_items as $menu_item) {
      if ($menu_item->ID == $parent_item->menu_item_parent) {
       $parent_item = $menu_item;
       break;
      }
     }
    }
    
	$itemclasses = empty( $parent_item->classes ) ? array() : (array) $parent_item->classes;
	if(in_array('current_page_ancestor',$itemclasses))
	{
		echo '<h1>'.get_the_title($parent_item->object_id).'</h1>' ;
	}	
   }
  }
 }
}

?>



<?php

//  Custom Next and Previous  Post id's of custom post type
$postlist_args = array(
   'posts_per_page'  => -1,  
   'order'           => 'ASC',
   'post_type'       => 'projects',
   'your_taxonomy_name' => 'specific taxonomy term'
); 
$postlist = get_posts( $postlist_args );

$ids = array();
foreach ($postlist as $thepost) {
   $ids[] = $thepost->ID;
}

$thisindex = array_search($post->ID, $ids);
$previd = $ids[$thisindex-1];
$nextid = $ids[$thisindex+1];



//  share this counts for all icons
http://99webtools.com/script-to-get-shared-count.php






function menu_item_has_childs($item_id)
{
    $childs = 0;
    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object($locations['primary']); 
    $menu_items = wp_get_nav_menu_items($menu->term_id);
    foreach($menu_items as $item){ if($item->menu_item_parent == $item_id){$childs++; break;}}
    return $childs;
}
?>




<?php 

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
function clear_image($id,$size='full',$icon=false,$attr=array()){
	return remove_thumbnail_dimensions(wp_get_attachment_image($id,$size,$icon,$attr));
}

echo clear_image($img['id'],'footer-info-thumbnail'); 



global $wp_query; $found_posts = $wp_query->post_count
$wp_query->found_posts
?>




<?php ///  Start code for Ratina   ?>

//// Block File Image : 

<?php global $image, $image_alt , $_image_sizes; ?>
<span data-picture data-alt="image description">
    <span data-src="<?php echo $image[$_image_sizes[0]]['src']; ?>" ></span>
    <span data-src="<?php echo $image[$_image_sizes[1]]['src']; ?>" data-media="(max-width:767px)" ></span>
    <span data-src="<?php echo $image[$_image_sizes[2]]['src']; ?>" data-media="(max-width:767px) and (-webkit-min-device-pixel-ratio:1.5), (max-width:767px) and (min-resolution:144dpi)" ></span>
    <!--[if (lt IE 9) & (!IEMobile)]>
        <span data-src="<?php echo $image[$_image_sizes[0]]['src']; ?>"></span>
    <![endif]-->
    <noscript><img src="<?php echo $image[$_image_sizes[0]]['src']; ?>" alt="image description" ></noscript>
</span>

<?php global $image, $image_alt; $_image_sizes = ''; ?>
_______________________

function theme_retina_image($image_id, $image_sizes, $template = null) {
 global $image, $image_alt ,  $_image_sizes;
 
 if ($image_post = get_post($image_id)) {
  $image_alt = get_post_meta($image_post->ID, '_wp_attachment_image_alt', true);
  foreach($image_sizes as $size) {
   
   list($image[$size]['src'], $image[$size]['width'], $image[$size]['height']) = wp_get_attachment_image_src($image_post->ID, $size);
   $_image_sizes[] = $size;
  }
  get_template_part('blocks/images/retina-image', $template);
 }
}
<?php theme_retina_image($thumb_id,array('thumbnail_730x450','thumbnail_300x185','thumbnail_600x370'),'featured');?>

<?php //  End code for Ratina?>



<?php // Allow mimetypes
function allowUploadMimes($existing_mimes) {
	$existing_mimes['svg'] = 'image/svg+xml';
	
	return $existing_mimes;
}
add_filter( 'mime_types', 'allowUploadMimes' );





wp_pagenavi( array( 'query' => $wp_query ) );











$getmonthno = $_REQUEST['month_filter'];

	$monthlist_1 = array(01,03,05,07,08,10,12);
	$monthlist_2 = array(04,06,09,11);
	$monthlist_3 = array(02);
	
	$years = $metasearch = array(); 
	$args = array(
			'posts_per_page'	=> -1,
			'post_type'		=> 'event');
	
	$all_posts = get_posts(array('post_type' => 'event', 'posts_per_page' => -1));
	if($all_posts){ $counter=1;
		foreach($all_posts as $singlepost){
			$start_date = get_field('start_date', $singlepost->ID);
			$month = date('m',$start_date);
			$year = date('y',$start_date);
			if($month == $getmonthno){
				if(!in_array($year,$years))
				{
					if(in_array($mont,$monthlist_1)){
						$month_end = 31 ;
					}elseif(in_array($month,$monthlist_2)){
						$month_end = 30 ;
					}elseif(in_array($month,$monthlist_3)){
						$month_end = 29 ;
					}
					
					if($counter == 1){
						$args['meta_query'] = array('relation' => 'OR');
					}
					
					$monthname = get_month_name($month);
					$start_time = strtotime("1 ".$monthname." ".$year."");
					$end_time = strtotime($month_end." ".$monthname." ".$year."");
					
					$args['meta_query'][] = array(
						'key'         => 'start_date',
						'value'    => array($start_time, $end_time),
						'compare'    => 'BETWEEN',
					);
					
					$counter++;
				}
			}
		}





*****************   Permalinks redirect issue   ****************

Add this code in .htaccess file

ErrorDocument 404 /index.php?error=404

# BEGIN WordPress
<IfModule mod_rewrite.c>
ErrorDocument 404 /index.php?error=404
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>

# END WordPress



***************************************************************



****************  Wordpress comments fields order   *************************

function wp34731_move_comment_field_to_bottom( $fields ) {
$comment_field = $fields['comment'];
unset( $fields['comment'] );
$fields['comment'] = $comment_field;

return $fields;
}
add_filter( 'comment_form_fields', 'wp34731_move_comment_field_to_bottom' );



**********************************************************************



**********************  get data from multiple taxonomies with And order   ************************


$terms = get_terms('slider-category');
      if($terms){
       foreach($terms as $term){
        $taxonomy[] = array(
         'taxonomy' => 'slider-category',
         'field'    => 'id',
         'terms'    => array($term->term_id),
        );
       }
      }
      
      $args = array(
      'post_type' => 'slider',
      'posts_per_page' => -1,
      'tax_query'  => array($taxonomy),
     );
	 
	 
	 
***************************************************************************



************************  Get tribe events fields data   ***********************

$full_address[] = tribe_get_address();
 $full_address[] = tribe_get_city();
 $full_address[] = tribe_get_state();
 $full_address[] = tribe_get_country();
 
 
**********************************************************************



*****************  Comments on index.php   *******************************

function get_comments_template()
{
    $comments_template = "";
    ob_start();
    global $withcomments,$comment,$post,$id;
 $withcomments = 1;
 comments_template( '/comments.php', true );
 //echo get_template_directory().'/comments.php';
    $comments_template = ob_get_clean();
    return $comments_template;
} 
function theme_comment($comment, $args, $depth) {
 $GLOBALS['comment'] = $comment; ?>
 
 <div class="comment">
  <?php //echo get_avatar( $comment, 48 ); ?>
        <div class="info">
            <strong class="name"><?php comment_author_link(); ?> <?php _e(':', 'base'); ?></strong>
            <time datetime="2008-09-03"><?php comment_date('F d, Y'); ?> <?php _e('at', 'base'); ?> <?php comment_time('g:i a'); ?></time>
        </div>
        <?php if ($comment->comment_approved == '0') : ?>
        <div class="text">
        <p><?php _e('Your comment is awaiting moderation.', 'base'); ?></p>
        </div>
        <?php else: ?>
        <?php comment_text(); ?>
        <?php endif; ?>
        
        <?php
            comment_reply_link(array_merge( $args, array(
                'reply_text' => __('Reply', 'base'),
                'before' => '<p>',
                'after' => '</p>',
                'depth' => $depth,
                'max_depth' => $args['max_depth']
            ))); ?>
  
 <?php }
 function theme_comment_end() { ?>
  </div>
 <?php } ?>
 
 


*******************************************************************



********************  user Role   ***********************

global $user;
 if ( isset( $user->roles ) && is_array( $user->roles ) ) {
  //check for admins
  if ( in_array( 'administrator', $user->roles ) ) {
   // redirect them to the default place
   //return get_permalink(get_option('page_for_posts'));
   return $redirect_to;
  } else {
   //return home_url();
   return get_permalink(get_option('page_for_posts'));
  }
 }
 

*********************************************************




***********************  Remove width and height   ************************

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}


******************************************************

?>
<?php


**********************  Div on image   ***********************************

function div_on_images($html, $id, $caption, $title, $align, $url, $size, $alt) {   
 $html = remove_width_attribute(get_image_tag($id, $alt, $title, $align, $size));
 
 $before_html = '<div class="img-holder">'; 
 $after_html = '</div>'; 
 $before_caption = '<span class="caption">';
 $after_caption = '</span>';
 
   $rel = $rel ? ' rel="attachment wp-att-' . esc_attr($id).'"' : '';
 
    if ( $url ) {
        $html = $before_html.'<a href="' . esc_attr($url) . "\"$rel>$html</a>";
  if($caption)
  {
   $html .= $before_caption.$caption.$after_caption ;
  }
  $html .= $after_html;
    } else {
        $html = $before_html.$html ;
  if($caption)
  {
   $html .= $before_caption.$caption.$after_caption ;
  }
  $html .= $after_html;
    }
 
    return $html;
}
add_filter('image_send_to_editor', 'div_on_images', 10, 8);
 
 
 
 
 
 
*******************************  Archive  Functions    ********************************************


[7/30/2013 1:07:27 PM] Shafayat Ali: custom archive funtion to get posts by year 

function custom_get_archives($args = '') {
    global $wpdb, $wp_locale;

    $defaults = array(
        'type' => 'yearly', 'limit' => '',
        'format' => 'html', 'before' => '',
        'after' => '', 'show_post_count' => false,
        'echo' => 1, 'order' => 'DESC',
    );

    $r = wp_parse_args( $args, $defaults );
    extract( $r, EXTR_SKIP );

    if ( '' == $type )
        $type = 'monthly';

    if ( '' != $limit ) {
        $limit = absint($limit);
        $limit = ' LIMIT '.$limit;
    }

    $order = strtoupper( $order );
    if ( $order !== 'ASC' )
        $order = 'DESC';

    // this is what will separate dates on weekly archive links
    $archive_week_separator = '&#8211;';

    // over-ride general date format ? 0 = no: use the date format set in Options, 1 = yes: over-ride
    $archive_date_format_over_ride = 0;

    // options for daily archive (only if you over-ride the general date format)
    $archive_day_date_format = 'Y/m/d';

    // options for weekly archive (only if you over-ride the general date format)
    $archive_week_start_date_format = 'Y/m/d';
    $archive_week_end_date_format    = 'Y/m/d';

    if ( !$archive_date_format_over_ride ) {
        $archive_day_date_format = get_option('date_format');
        $archive_week_start_date_format = get_option('date_format');
        $archive_week_end_date_format = get_option('date_format');
    }

    //filters
    $where = apply_filters( 'getarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r );
    $join = apply_filters( 'getarchives_join', '', $r );

    $output = '';

    if ('yearly' == $type) {
        $query = "SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date $order $limit";
        $key = md5($query);
        $cache = wp_cache_get( 'wp_get_archives' , 'general');
        if ( !isset( $cache[ $key ] ) ) {
           $arcresults = $wpdb->get_results($query);
            $cache[ $key ] = $arcresults;
            wp_cache_set( 'wp_get_archives', $cache, 'general' );
        } else {
            $arcresults = $cache[ $key ];
        }
        if ($arcresults) { $output =""; $out=""; $out2=""; $c=1;
            $output .= '<div class="tab-content">';
            $afterafter = $after;
            foreach ( (array) $arcresults as $arcresult) {
               // $url = get_year_link($arcresult->year);
                //$text = sprintf('%d', $arcresult->year);
                $output .= '<div id="tab'.$arcresult->year.'"><div class="carousel-news"><div class="mask"><div class="slideset">';
                    query_posts('year='.$arcresult->year.'&showposts=-1');
                        if (have_posts()):
                            while (have_posts()) : the_post();
                                $output .= '<div class="slide">';
                                    $output .= '<div class="text">';
                                        $output .= '<h1>'.get_the_time('d F Y').'</h1>';
                                        $output .= get_the_content();
                                    $output .= '</div>';
                                    if(has_post_thumbnail()):
                                        $src = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
                                        $output .= '<div class="img-holder"><img src="'.$src.'" alt="'. get_post_meta(get_post_thumbnail_id(get_the_ID()) , '_wp_attachment_image_alt', true).'"></div>';
                                        $attachments = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order',
                                        'order' => 'ASC', 'exclude' => get_post_thumbnail_id()));
                                        if($attachments)
                                        {
                                            foreach($attachments as $att_id => $attachment) 
                                            {
                                                $src = wp_get_attachment_url($attachment->ID);
                                                $output .= '<div class="img-holder"><img src="'.$src.'" alt="'. get_post_meta($attachment->ID , '_wp_attachment_image_alt', true).'"></div>';
                                            } 
                                        }
                                    endif;
                                $output .= '</div>';
                            endwhile;
                        endif;
                    wp_reset_query();
                 $output .= '</div></div><div class="btns-holder"><a class="btn-prev" href="#">Previous</a>
                 <a class="btn-next" href="#">Next</a></div></div></div>';
                 if($c==1){$class='class="active"';}else{$class="";}
                 $out .= '<li><a '.$class.' href="#tab'.$arcresult->year.'">'.$arcresult->year.'</a></li>';
                 $c++;
            }
            $output .= '</div>';
            
            $out2 = '<div class="tabset-holder"><span class="title">ARCHIVE</span><ul class="tabset">'.$out.'</ul></div>';
        }
    }  
    if ( $echo )
        echo $output.$out2;
    else
        return $output;
}
[7/30/2013 1:08:14 PM] Shafayat Ali: year and month wise archive hirarchy

<?php
global $wpdb;
$limit = 0;
$year_prev = null;
$months = $wpdb->get_results("SELECT DISTINCT MONTH( post_date ) AS month , YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post' GROUP BY month , year ORDER BY post_date DESC");
foreach($months as $month) :
 $year_current = $month->year;
 if ($year_current != $year_prev){
  if ($year_prev != null){?>
  
  <?php } ?>
 
 <li class="archive-year"><a href="<?php bloginfo('url') ?>/<?php echo $month->year; ?>/"><?php echo $month->year; ?></a></li>
 
 <?php } ?>
 <li><a href="<?php bloginfo('url') ?>/<?php echo $month->year; ?>/<?php echo date("m", mktime(0, 0, 0, $month->month, 1, $month->year)) ?>"><span class="archive-month"><?php echo date("F", mktime(0, 0, 0, $month->month, 1, $month->year)) ?></span></a></li>
<?php $year_prev = $year_current;

if(++$limit >= 18) { break; }

endforeach; ?>
[7/30/2013 1:08:33 PM] Shafayat Ali: custom widget archive
class custom_monthly_Widget_Archives extends WP_Widget {

 function __construct() {
  $widget_ops = array('classname' => 'widget_archive', 'description' => __( 'A monthly archive of your site&#8217;s posts') );
  parent::__construct('monthly-archives', __('Monthly Archives'), $widget_ops);
 }

 function widget( $args, $instance ) {
  extract($args);
  $c = ! empty( $instance['count'] ) ? '1' : '0';
  $d = ! empty( $instance['dropdown'] ) ? '1' : '0';
  $title = apply_filters('widget_title', empty($instance['title']) ? __('') : $instance['title'], $instance, $this->id_base);

  echo $before_widget;
  if ( $title )
   echo $before_title . $title . $after_title;

  if ( $d ) {
?>

<?php
  } else {
   
   ?>
 
 <?php
   global $wpdb;
$year_prev = null;
$months = $wpdb->get_results( "SELECT DISTINCT MONTH( post_date ) AS month ,
        YEAR( post_date ) AS year,
        COUNT( id ) as post_count FROM $wpdb->posts
        WHERE post_status = 'publish' and post_date <= now( )
        and post_type = 'post'
        GROUP BY month , year
        ORDER BY post_date DESC");
        
if($months)(think)>
<ul class="date-list">
<?php        
foreach($months as $month) :
 $year_current = $month->year;
 if ($year_current != $year_prev){
  if ($year_prev != null){ echo '</ul>       
 </li>';} ?> 
         <li><h3><?php echo $month->year;?></h3>
         <ul class="month-list">  
 <?php } ?>
 
    <?php  if(get_option('permalink_structure')) {?>
  <li><a href="<?php bloginfo('url') ?>/<?php echo $month->year; ?>/<?php echo date("m", mktime(0, 0, 0, $month->month, 1, $month->year)) ?>"> 
   <?php echo date("F", mktime(0, 0, 0, $month->month, 1, $month->year)) ?>
   
  </a></li><?php } else { $url= get_bloginfo('url').'?m='.$month->year.date("m", mktime(0, 0, 0, $month->month, 1, $month->year));?> <li><a href="<?php echo $url; ?>"> 
   <?php echo date("F", mktime(0, 0, 0, $month->month, 1, $month->year)) ?>
   
  </a></li>
  <?php }?>
 
<?php $year_prev = $year_current;
endforeach;?>
</ul></ul>
<?php endif;
?>

<?php

  echo $after_widget;
 }}

 function update( $new_instance, $old_instance ) {
  $instance = $old_instance;
  $new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
  $instance['title'] = strip_tags($new_instance['title']);
  $instance['count'] = $new_instance['count'] ? 1 : 0;
  $instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

  return $instance;
 }

 function form( $instance ) {
  $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
  $title = strip_tags($instance['title']);
  $count = $instance['count'] ? 'checked="checked"' : '';
  $dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php _e('Title:'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>
<p>
  <input class="checkbox" type="checkbox" <?php echo $dropdown; ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" />
  <label for="<?php echo $this->get_field_id('dropdown'); ?>">
    <?php _e('Display as dropdown'); ?>
  </label>
  <br/>
  <input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" />
  <label for="<?php echo $this->get_field_id('count'); ?>">
    <?php _e('Show post counts'); ?>
  </label>
</p>
<?php
 }
}
add_action('widgets_init', create_function('', 'return register_widget("custom_monthly_Widget_Archives");'));
[7/30/2013 1:08:43 PM] Shafayat Ali: Custom Archive Function

function custom_get_archives($args = '') {
 global $wpdb, $wp_locale;

 $defaults = array(
  'type' => 'monthly', 'limit' => '',
  'format' => 'html', 'before' => '',
  'after' => '', 'show_post_count' => false,
  'echo' => 1
 );

 $r = wp_parse_args( $args, $defaults );
 extract( $r, EXTR_SKIP );

 if ( '' == $type )
  $type = 'monthly';

 if ( '' != $limit ) {
  $limit = absint($limit);
  $limit = ' LIMIT '.$limit;
 }

 // this is what will separate dates on weekly archive links
 $archive_week_separator = '&#8211;';

 // over-ride general date format ? 0 = no: use the date format set in Options, 1 = yes: over-ride
 $archive_date_format_over_ride = 0;

 // options for daily archive (only if you over-ride the general date format)
 $archive_day_date_format = 'Y/m/d';

 // options for weekly archive (only if you over-ride the general date format)
 $archive_week_start_date_format = 'Y/m/d';
 $archive_week_end_date_format = 'Y/m/d';

 if ( !$archive_date_format_over_ride ) {
  $archive_day_date_format = get_option('date_format');
  $archive_week_start_date_format = get_option('date_format');
  $archive_week_end_date_format = get_option('date_format');
 }

 //filters
 $where = apply_filters( 'getarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r );
 $join = apply_filters( 'getarchives_join', '', $r );

 $output = '';

 if ( 'monthly' == $type ) {
  $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date ASC $limit";
  $key = md5($query);
  $cache = wp_cache_get( 'wp_get_archives' , 'general');
  if ( !isset( $cache[ $key ] ) ) {
   $arcresults = $wpdb->get_results($query);
   $cache[ $key ] = $arcresults;
   wp_cache_set( 'wp_get_archives', $cache, 'general' );
  } else {
   $arcresults = $cache[ $key ];
  }
  if ( $arcresults ) {
   $afterafter = $after;
   foreach ( (array) $arcresults as $arcresult ) {
    $url = get_month_link( $arcresult->year, $arcresult->month );
    /* translators: 1: month name, 2: 4-digit year */
    $text = sprintf(__('%1$s'), $wp_locale->get_month_abbrev($wp_locale->get_month($arcresult->month)));
    $text .='.';
    if ( $show_post_count )
     $after = '&nbsp;('.$arcresult->posts.')' . $afterafter;
    $output .= get_archives_link($url, $text, $format, $before, $after);
   }
  }
 } elseif ('yearly' == $type) {
  $query = "SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date DESC $limit";
  $key = md5($query);
  $cache = wp_cache_get( 'wp_get_archives' , 'general');
  if ( !isset( $cache[ $key ] ) ) {
   $arcresults = $wpdb->get_results($query);
   $cache[ $key ] = $arcresults;
   wp_cache_set( 'wp_get_archives', $cache, 'general' );
  } else {
   $arcresults = $cache[ $key ];
  }
  if ($arcresults) {
   $afterafter = $after;
   foreach ( (array) $arcresults as $arcresult) {
    $url = get_year_link($arcresult->year);
    $text = sprintf('%d', $arcresult->year);
    if ($show_post_count)
     $after = '&nbsp;('.$arcresult->posts.')' . $afterafter;
    $output .= get_archives_link($url, $text, $format, $before, $after);
   }
  }
 } elseif ( 'daily' == $type ) {
  $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, DAYOFMONTH(post_date) AS `dayofmonth`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) ORDER BY post_date DESC $limit";
  $key = md5($query);
  $cache = wp_cache_get( 'wp_get_archives' , 'general');
  if ( !isset( $cache[ $key ] ) ) {
   $arcresults = $wpdb->get_results($query);
   $cache[ $key ] = $arcresults;
   wp_cache_set( 'wp_get_archives', $cache, 'general' );
  } else {
   $arcresults = $cache[ $key ];
  }
  if ( $arcresults ) {
   $afterafter = $after;
   foreach ( (array) $arcresults as $arcresult ) {
    $url = get_day_link($arcresult->year, $arcresult->month, $arcresult->dayofmonth);
    $date = sprintf('%1$d-%2$02d-%3$02d 00:00:00', $arcresult->year, $arcresult->month, $arcresult->dayofmonth);
    $text = mysql2date($archive_day_date_format, $date);
    if ($show_post_count)
     $after = '&nbsp;('.$arcresult->posts.')'.$afterafter;
    $output .= get_archives_link($url, $text, $format, $before, $after);
   }
  }
 } elseif ( 'weekly' == $type ) {
  $week = _wp_mysql_week( '`post_date`' );
  $query = "SELECT DISTINCT $week AS `week`, YEAR( `post_date` ) AS `yr`, DATE_FORMAT( `post_date`, '%Y-%m-%d' ) AS `yyyymmdd`, count( `ID` ) AS `posts` FROM `$wpdb->posts` $join $where GROUP BY $week, YEAR( `post_date` ) ORDER BY `post_date` DESC $limit";
  $key = md5($query);
  $cache = wp_cache_get( 'wp_get_archives' , 'general');
  if ( !isset( $cache[ $key ] ) ) {
   $arcresults = $wpdb->get_results($query);
   $cache[ $key ] = $arcresults;
   wp_cache_set( 'wp_get_archives', $cache, 'general' );
  } else {
   $arcresults = $cache[ $key ];
  }
  $arc_w_last = '';
  $afterafter = $after;
  if ( $arcresults ) {
    foreach ( (array) $arcresults as $arcresult ) {
     if ( $arcresult->week != $arc_w_last ) {
      $arc_year = $arcresult->yr;
      $arc_w_last = $arcresult->week;
      $arc_week = get_weekstartend($arcresult->yyyymmdd, get_option('start_of_week'));
      $arc_week_start = date_i18n($archive_week_start_date_format, $arc_week['start']);
      $arc_week_end = date_i18n($archive_week_end_date_format, $arc_week['end']);
      $url  = sprintf('%1$s/%2$s%3$sm%4$s%5$s%6$sw%7$s%8$d', home_url(), '', '?', '=', $arc_year, '&amp;', '=', $arcresult->week);
      $text = $arc_week_start . $archive_week_separator . $arc_week_end;
      if ($show_post_count)
       $after = '&nbsp;('.$arcresult->posts.')'.$afterafter;
      $output .= get_archives_link($url, $text, $format, $before, $after);
     }
    }
  }
 } elseif ( ( 'postbypost' == $type ) || ('alpha' == $type) ) {
  $orderby = ('alpha' == $type) ? 'post_title ASC ' : 'post_date DESC ';
  $query = "SELECT * FROM $wpdb->posts $join $where ORDER BY $orderby $limit";
  $key = md5($query);
  $cache = wp_cache_get( 'wp_get_archives' , 'general');
  if ( !isset( $cache[ $key ] ) ) {
   $arcresults = $wpdb->get_results($query);
   $cache[ $key ] = $arcresults;
   wp_cache_set( 'wp_get_archives', $cache, 'general' );
  } else {
   $arcresults = $cache[ $key ];
  }
  if ( $arcresults ) {
   foreach ( (array) $arcresults as $arcresult ) {
    if ( $arcresult->post_date != '0000-00-00 00:00:00' ) {
     $url  = get_permalink( $arcresult );
     if ( $arcresult->post_title )
      $text = strip_tags( apply_filters( 'the_title', $arcresult->post_title, $arcresult->ID ) );
     else
      $text = $arcresult->ID;
     $output .= get_archives_link($url, $text, $format, $before, $after);
    }
   }
  }
 }
 if ( $echo )
  echo $output;
 else
  return $output;
}
[7/30/2013 1:08:59 PM] Shafayat Ali: get archive of specific category year and monthly wise with post listing

function custom_get_archives($args = '') {
 global $wpdb, $wp_locale;

 $defaults = array(
  'type' => 'monthly', 'limit' => '',
  'format' => 'html', 'before' => '',
  'after' => '', 'show_post_count' => false,
  'echo' => 1
 );

 $r = wp_parse_args( $args, $defaults );
 extract( $r, EXTR_SKIP );

 if ( '' == $type )
  $type = 'monthly';

 if ( '' != $limit ) {
  $limit = absint($limit);
  $limit = ' LIMIT '.$limit;
 }

 // this is what will separate dates on weekly archive links
 $archive_week_separator = '&#8211;';

 // over-ride general date format ? 0 = no: use the date format set in Options, 1 = yes: over-ride
 $archive_date_format_over_ride = 0;

 // options for daily archive (only if you over-ride the general date format)
 $archive_day_date_format = 'Y/m/d';

 // options for weekly archive (only if you over-ride the general date format)
 $archive_week_start_date_format = 'Y/m/d';
 $archive_week_end_date_format = 'Y/m/d';

 if ( !$archive_date_format_over_ride ) {
  $archive_day_date_format = get_option('date_format');
  $archive_week_start_date_format = get_option('date_format');
  $archive_week_end_date_format = get_option('date_format');
 }

 //filters
 $where = apply_filters( 'getarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r );
 $join = apply_filters( 'getarchives_join', '', $r );

 $output = '';

 if ( 'monthly' == $type ) {
  
  $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
  $key = md5($query);
  $cache = wp_cache_get( 'wp_get_archives' , 'general');
  if ( !isset( $cache[ $key ] ) ) {
   $arcresults = $wpdb->get_results($query);
   $cache[ $key ] = $arcresults;
   wp_cache_set( 'wp_get_archives', $cache, 'general' );
  } else {
   $arcresults = $cache[ $key ];
  }
  
  if ( $arcresults ) {
   $output ='<ul class="news-list">';
   foreach ( (array) $arcresults as $arcresult ) {
    if($arcresult->year == date('Y')){
     $url = get_month_link( $arcresult->year, $arcresult->month );
     /* translators: 1: month name, 2: 4-digit year */
     $text = sprintf(__('%1$s %2$d'), $wp_locale->get_month($arcresult->month), $arcresult->year);
     
     $output .= '<li><strong>'.strtoupper($text).'</strong>';//get_archives_link($url, $text,'<strong>','</strong>');
      query_posts( 'cat='.nieuwesCatID.'&year='.$arcresult->year.'&monthnum='.$arcresult->month );
      $output  .='<ul>';
      while (have_posts()) : the_post(); 
       $output .='<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
      endwhile;
      $output  .='</ul>';
      
     $output .= '</li>';
    }
   }
    $output .= '<li><ul class="archive-list">';
    wp_reset_query();
    $query = "SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date DESC $limit";
    $key = md5($query);
    $cache = wp_cache_get( 'wp_get_archives' , 'general');
    if ( !isset( $cache[ $key ] ) ) {
     $arcresults = $wpdb->get_results($query);
     $cache[ $key ] = $arcresults;
     wp_cache_set( 'wp_get_archives', $cache, 'general' );
    } else {
     $arcresults = $cache[ $key ];
    }
    if ($arcresults) {
     $afterafter = $after;
     foreach ( (array) $arcresults as $arcresult) {
      if($arcresult->year != date('Y')){
       $url = get_year_link($arcresult->year);
       $text = sprintf('%d', $arcresult->year);
       
       if ($show_post_count)
        $after = '&nbsp;('.$arcresult->posts.')' . $afterafter;
        
       $output .= '<li>'.get_archives_link($url, $text, $format, $before, $after).'</li>';
      }
     }
    }
   
   $output .='</ul></li></ul>';
  }
  
  } 
 
 if ( $echo )
  echo $output;
 else
  return $output;
}



****************************************************************



*************************  Second Level Menu   **************************************

class Custom_Walker_Page extends Walker {
 /**
  * @see Walker::$tree_type
  * @since 2.1.0
  * @var string
  */
 var $tree_type = 'page';

 /**
  * @see Walker::$db_fields
  * @since 2.1.0
  * @todo Decouple this.
  * @var array
  */
 var $db_fields = array ('parent' => 'post_parent', 'id' => 'ID');

 /**
  * @see Walker::start_lvl()
  * @since 2.1.0
  *
  * @param string $output Passed by reference. Used to append additional content.
  * @param int $depth Depth of page. Used for padding.
  */
 function start_lvl(&$output, $depth) {
  $indent = str_repeat("\t", $depth);
  $output .= "\n$indent<div class='slide'><ul>\n";
 }

 /**
  * @see Walker::end_lvl()
  * @since 2.1.0
  *
  * @param string $output Passed by reference. Used to append additional content.
  * @param int $depth Depth of page. Used for padding.
  */
 function end_lvl(&$output, $depth) {
  $indent = str_repeat("\t", $depth);
  $output .= "$indent</ul></div>\n";
 }

 /**
  * @see Walker::start_el()
  * @since 2.1.0
  *
  * @param string $output Passed by reference. Used to append additional content.
  * @param object $page Page data object.
  * @param int $depth Depth of page. Used for padding.
  * @param int $current_page Page ID.
  * @param array $args
  */
 function start_el(&$output, $page, $depth, $args, $current_page) {
  if ( $depth )
   $indent = str_repeat("\t", $depth);
  else
   $indent = '';

  extract($args, EXTR_SKIP);
  $css_class = array('page_item', 'page-item-'.$page->ID);
  if ( !empty($current_page) ) {
   $_current_page = get_page( $current_page );
   _get_post_ancestors($_current_page);
   if ( isset($_current_page->ancestors) && in_array($page->ID, (array) $_current_page->ancestors) )
    $css_class[] = 'current_page_ancestor';
   if ( $page->ID == $current_page )
    $css_class[] = 'current_page_item';
   elseif ( $_current_page && $page->ID == $_current_page->post_parent )
    $css_class[] = 'current_page_parent';
  } elseif ( $page->ID == get_option('page_for_posts') ) {
   $css_class[] = 'current_page_parent';
  }

  $css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );
  if($depth == 0)
  {
   $css_class = "opener" ;
  }  
  
  $output .= $indent . '<li><a class="'.$css_class.'"  href="' . get_permalink($page->ID) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';

  if ( !empty($show_date) ) {
   if ( 'modified' == $show_date )
    $time = $page->post_modified;
   else
    $time = $page->post_date;

   $output .= " " . mysql2date($date_format, $time);
  }
 }

 /**
  * @see Walker::end_el()
  * @since 2.1.0
  *
  * @param string $output Passed by reference. Used to append additional content.
  * @param object $page Page data object. Not used.
  * @param int $depth Depth of page. Not Used.
  */
 function end_el(&$output, $page, $depth) {
  $output .= "</li>\n";
 }

}




***********************************************************************************************




***************************  Remove p tag filter    ***************************************


add_filter('the_content', 'remove_empty_p', 20, 1);
function remove_empty_p($content){
    $content = force_balance_tags($content);
    return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
}



***************************************************************************************





**************************  Share List  ***************************************

<ul class="share-list">
                  <li>
                 <iframe scrolling="no" frameborder="0" allowtransparency="true" style="border:none; width:74px; display: block; height: 20px; overflow: hidden; text-indent: -9999px;" src="http://www.facebook.com/plugins/like.php?href=<?php echo get_permalink();?>&amp;layout=button_count&amp;show_faces=true&amp;width=74&amp;action=like&amp;font=tahoma&amp;colorscheme=light&amp;height=20"></iframe>
    
                  </li>
                  <li>                  
                  <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
                       <a href="http://twitter.com/share" class="twitter-share-button"
                          data-url="<?php the_permalink(); ?>"
                          data-via="wpbeginner"
                          data-text="<?php the_title(); ?>"
                          data-related="syedbalkhi:Founder of WPBeginner" >tweet</a>
                  </li>
                  <li>
                    <script type="text/javascript" src="http://platform.linkedin.com/in.js"></script><script type="in/share" data-url="<?php the_permalink(); ?>" data-counter="right"></script>
                  </li>
                 <li class="googleplusbutton">                  
      <script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
      <g:plusone size="medium"></g:plusone>
                  </li>
              </ul>
              
              

*************************************************************************



***************************************  Comments template ***********************************

global $withcomments;
$withcomments = 1;
comments_template( 'comments.php', true );


**********************************************************************************************

?>






facebook share in link with popup

<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php the_title ?>" onclick="return popitup('http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php the_title ?>')">POST TO FACEBOOK</a>

//Put this in header.php

<script language="javascript" type="text/javascript">
          <!--
          function popitup(url) {
           newwindow=window.open(url,'name','height=300,width=450');
           if (window.focus) {newwindow.focus()}
           return false;
          }
          
          // -->
          </script>
          
          
          



<?php

function allowUploadMimes ($mimes) {
 if ( function_exists( 'current_user_can' ) )
  $unfiltered = $user ? user_can( $user, 'unfiltered_html' ) : current_user_can( 'unfiltered_html' );
 if ( !empty( $unfiltered ) ) {
  $mimes = array( 'swf' => 'application/x-shockwave-flash',
    'exe' => 'application/x-msdownload',
    'zip' => 'multipart/x-zip',
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'gz' => 'application/x-gzip',
    'gzip' => 'application/x-gzip',
    'png' => 'image/png',
    'jpg' => 'image/jpeg',
    'jpe' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'ai' => 'application/postscript',
    'eps' => 'application/postscript',
    'ps' => 'application/postscript',
    'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
    'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
    'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
    'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
    'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
    'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
    'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
    'xla' => 'application/vnd.ms-excel',
    'xlc' => 'application/vnd.ms-excel',
    'xlm' => 'application/vnd.ms-excel',
    'xls' => 'application/vnd.ms-excel',
    'xlt' => 'application/vnd.ms-excel',
    'xlw' => 'application/vnd.ms-excel',
    'pot' => 'application/vnd.ms-powerpoint',
    'pps' => 'application/vnd.ms-powerpoint',
    'ppt' => 'application/vnd.ms-powerpoint',
    'gtar' => 'application/x-gtar',
    'js' => 'application/x-javascript',
    'mid' => 'audio/midi',
    'midi' => 'audio/midi',
    'wav' => 'audio/x-wav',
    'bmp' => 'image/bmp',
    'ief' => 'image/ief',
    'pict' => 'image/pict',
    'tif' => 'image/tiff',
    'tiff' => 'image/tiff',
    'css' => 'text/css',
    'csv' => 'text/csv',
    'txt' => 'text/plain',
    'html' => 'text/html',
    'rtx' => 'text/richtext',
    'mpe' => 'video/mpeg',
    'mpeg' => 'video/mpeg',
    'mpg' => 'video/mpeg',
    'avi' => 'video/msvideo',
    'mov' => 'video/quicktime',
    'qt' => 'video/quicktime',
    'movie' => 'video/x-sgi-movie',
    'rtf' => 'application/rtf',
    'dot' => 'application/msword',
    'word' => 'application/msword',
    'w6w' => 'application/msword',
    'svg' => 'image/svg+xml',
    'xml' => 'application/xml',
    'f4v' => 'video/mp4',
    'f4p' => 'video/mp4',
    'f4a' => 'audio/mp4',
    'f4b' => 'audio/mp4',
    'gif' => 'image/gif',
    'mp4' => 'video/mp4',
    'flv' => 'video/x-flv',
    'pdf' => 'application/pdf',
    'mp3' => 'audio/x-mpeg' );
 }
 return $mimes;
}
add_filter('upload_mimes','allowUploadMimes');


?>

