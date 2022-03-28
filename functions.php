<?php
/**
 * opinionstage_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package opinionstage_theme
 */

//Exclude pages from WordPress Search
function wpb_search_filter($query) {
if ($query->is_search) {
$query->set('post_type', 'post');
}
return $query;
}
add_filter('pre_get_posts','wpb_search_filter');

add_action( 'after_setup_theme', 'os_theme_functions' );
function os_theme_functions() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
}

/**
 * Enqueue scripts and styles by page id
 */
function addingCssStyleByPage() {

	// default styles
	// from footer
	// wp_enqueue_style('bootstrap-custom', get_template_directory_uri() . '/css/bootstrap-custom.min.css', false);
	wp_enqueue_style('fontawesome-css', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css?display=swap', false);
	wp_enqueue_style('google-fonts-robot', '//fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7COpen+Sans%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&amp;ver=a50e31599efd400f56200c2144bc42d4&display=swap', false);

	// needed script
	wp_enqueue_script('bootstrap-min-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), false, true );

	if (is_front_page()) {
		wp_enqueue_style('reset-css', get_template_directory_uri() . '/css/reset.min.css', false);
		wp_enqueue_style('owl-carousel-css', get_template_directory_uri() . '/css/owl.carousel.css', false);
		wp_enqueue_style('owl-theme-css', get_template_directory_uri() . '/css/owl.theme.css', false);

		wp_enqueue_script('owl-carousel-js', get_template_directory_uri() . '/js/owl.carousel.js', array(), false, true );
	}


	$listStyleScriptListRender = get_post_meta(get_queried_object_id(), 'enqueued_scripts_style',true);
	$listScriptListRender = $listStyleScriptListRender['scripts'];
	$listStyleListRender  = $listStyleScriptListRender['styles'];

	foreach ($listScriptListRender as $script){
		$value = get_post_meta(get_queried_object_id(), $script['handle'].'_key',true);
		if($value == 'false' || $value == ''){
			
		}else{
			$scriptValue[] = $value;
		}
	}
	foreach ($listStyleListRender as $style){
		$value = get_post_meta(get_queried_object_id(), $style['handle'].'_key',true);
		if($value == 'false' || $value == ''){
			
		}else{
			$styleValue[] = $value;
		}
	}
	// Blog Page
	if(is_page(4744) || is_home()){
		wp_enqueue_style( 'custom-os-page',get_template_directory_uri() . '/css/blog.css' );
		wp_enqueue_style( 'plugin-page',get_template_directory_uri() . '/css/plugin.css' );
		foreach ($scriptValue as $scriptHandle){
			wp_dequeue_script( $scriptHandle );
    		wp_deregister_script( $scriptHandle );
		}
		foreach ($styleValue as $styleHandle){
			wp_dequeue_style( $styleHandle );
    		wp_deregister_style( $styleHandle );
		}
		return true;
	}
	if(is_category()){
		wp_enqueue_style( 'custom-os-page',get_template_directory_uri() . '/css/blog.css' );
		wp_enqueue_style( 'plugin-page',get_template_directory_uri() . '/css/plugin.css' );
		return true;
	}
	// Home Page
	if(is_page(16912) || is_front_page()) {
	    wp_enqueue_style( 'home-page',get_template_directory_uri() . '/css/home.css' );
	    wp_enqueue_style( 'plugin-page',get_template_directory_uri() . '/css/plugin.css' );
	    foreach ($scriptValue as $scriptHandle){
			wp_dequeue_script( $scriptHandle );
    		wp_deregister_script( $scriptHandle );
		}
		foreach ($styleValue as $styleHandle){
			wp_dequeue_style( $styleHandle );
    		wp_deregister_style( $styleHandle );
		}
	    return true; 
	}
	// About Page
	if(is_page(15844) || is_page( 'about' )) {		
		wp_enqueue_style( 'about-page',get_template_directory_uri() . '/css/about.css' );
		wp_enqueue_style( 'home-page',get_template_directory_uri() . '/css/plugin.css' );
		foreach ($scriptValue as $scriptHandle){
			wp_dequeue_script( $scriptHandle );
    		wp_deregister_script( $scriptHandle );
		}
		foreach ($styleValue as $styleHandle){
			wp_dequeue_style( $styleHandle );
    		wp_deregister_style( $styleHandle );
		}
	    return true;
	}
	// Landing Page
	$landing_page = get_page_template_slug( get_the_ID() );
	if( $landing_page == 'landing-page.php') {
		wp_enqueue_style( 'landing-plugin-page',get_template_directory_uri() . '/css/plugin.css' );		
		foreach ($scriptValue as $scriptHandle){
			wp_dequeue_script( $scriptHandle );
    		wp_deregister_script( $scriptHandle );
		}
		foreach ($styleValue as $styleHandle){
			wp_dequeue_style( $styleHandle );
    		wp_deregister_style( $styleHandle );
		}
	    return true;
	}	
	// Single Page
	if( is_single() ) {
		wp_enqueue_style( 'single-page',get_template_directory_uri() . '/css/blog.css' );
		wp_enqueue_style( 'Font-Family-PT-Serif', 'https://fonts.googleapis.com/css?family=PT+Serif&display=swap' );
		wp_enqueue_style( 'home-page',get_template_directory_uri() . '/css/plugin.css' );
		foreach ($scriptValue as $scriptHandle){
			wp_dequeue_script( $scriptHandle );
    		wp_deregister_script( $scriptHandle );
		}
		foreach ($styleValue as $styleHandle){
			wp_dequeue_style( $styleHandle );
    		wp_deregister_style( $styleHandle );
		}
		return true;
	}
	// Non-Landing pages css styles
	if( is_page() ) {		
		wp_enqueue_style( 'custom-os-page',get_template_directory_uri() . '/css/blog.css' );
		wp_enqueue_style( 'Font-Family-PT-Serif', 'https://fonts.googleapis.com/css?family=PT+Serif&display=swap' );
		wp_enqueue_style( 'home-page',get_template_directory_uri() . '/css/plugin.css' );
		foreach ($scriptValue as $scriptHandle){
			wp_dequeue_script( $scriptHandle );
    		wp_deregister_script( $scriptHandle );
		}
		foreach ($styleValue as $styleHandle){
			wp_dequeue_style( $styleHandle );
    		wp_deregister_style( $styleHandle );
		}
		return true;
	}
	// 404/Page not found css styles
	if( is_404() ){		
		wp_enqueue_style( '404-style', get_template_directory_uri().'/css/404-style.css' );
		wp_enqueue_style( 'home-page',get_template_directory_uri() . '/css/plugin.css' );
		foreach ($scriptValue as $scriptHandle){
			wp_dequeue_script( $scriptHandle );
    		wp_deregister_script( $scriptHandle );
		}
		foreach ($styleValue as $styleHandle){
			wp_dequeue_style( $styleHandle );
    		wp_deregister_style( $styleHandle );
		}
		return true;
	}
}

add_action( 'wp_enqueue_scripts', 'addingCssStyleByPage', 999 );

function addScriptForHeight(){
	// No conflict JS!
	/*?>
<script>
    var $j = jQuery.noConflict();
    var $ = jQuery.noConflict();
</script>
	<?php*/

	// LP specific JS!
	$landing_page = get_page_template_slug( get_the_ID() );
	if( $landing_page == 'landing-page.php') { ?>
		<script type="text/javascript">
		    jQuery(document).ready(function($){
		    // Get Document window size
		        var window_size = $(window).width();
		        if(window_size < 480){
		            
		        }else{
		            $('.fixed_container .two').each(function(){
		                var maxHeight = 0;
		                $('h3', $(this)).each(function(){
		                    var height = $(this).height();
		                    if(maxHeight < height){
		                        maxHeight = height;
		                    }
		                });
		                $('h3', $(this)).css('height', maxHeight+"px");
		            });
		        }
		    });
		</script>
	<?php } 
	}	
add_action('wp_footer','addScriptForHeight');

if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name' => 'Blog Post Head',
    'before_widget' => '<div class = "widgetizedArea">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  )
);
if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name' => 'Blog Post Sidebar Inner',
    'before_widget' => '<div class = "widgetizedArea">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  )
);
if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name' => 'Blog Post Sidebar',
    'before_widget' => '<div class = "box_right">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  )
);
add_action( 'wp_footer','list_style_script_list' );
function list_style_script_list(){
	$checkAuth = get_post_meta(get_queried_object_id(),'list_added',true);
	if($checkAuth == ''){
		update_post_meta(get_queried_object_id(),'enqueued_scripts_style',crunchify_print_scripts_styles());
		update_post_meta(get_queried_object_id(),'list_added','true');
	}
	$updateScriptStyleMeta = $_GET['updateScriptStyle'];
	if(isset($_GET['updateScriptStyle']) && $updateScriptStyleMeta == 'true'){
		delete_post_meta(get_queried_object_id(),'enqueued_scripts_style');
		delete_post_meta(get_queried_object_id(),'list_added');
	}
}

function wporg_add_custom_box()
{
    $screens = ['post', 'page'];
    foreach ($screens as $screen) {
        add_meta_box(
            'wporg_box_id',           // Unique ID
            'List of Script and Style',  // Box title
            'wporg_custom_box_html',  // Content callback, must be of type callable
            $screen,                   // Post type
            'normal',                  // $context
       		'high'                     // $priority
        );
        add_meta_box(
            'wporg_box_id_plugin',           // Unique ID
            'List of Plugins',  // Box title
            'wporg_custom_box_plugin',  // Content callback, must be of type callable
            $screen,                   // Post type
            'normal',                  // $context
       		'high'                     // $priority
        );
    }
    // Removing Meta Box
    remove_meta_box( 'ctcc_gallery_metabox', $screen, 'side' );
}
add_action('add_meta_boxes', 'wporg_add_custom_box');

function wporg_custom_box_html(){
	$listStyleScriptList = get_post_meta(get_the_ID(), 'enqueued_scripts_style',true);
	$listScriptList = $listStyleScriptList['scripts'];
	$listStyleList = $listStyleScriptList['styles'];
	
	if($listStyleList == '' && $listScriptList == '') { ?>
		<a href="javascript:void(0)" style="background: #007cba;border-color: #007cba;color: #fff;text-decoration: none;border-radius: 3px;padding: 10px;  overflow: hidden;margin-top: 10px;display: inline-block;font-size: 14px;letter-spacing: .3px;" onclick="jQuery('#refresh-indication').show(1000); window.open('<?php echo get_the_permalink().'?close_window=true'; ?>');">Generate Script & Style List</a>
		<span id="refresh-indication" style="display:none;position: absolute;top: -33px;left: 158px;font-size: 13px;color: #c45200;font-weight: bold;">( Refresh Page )</span>		
	<?php }else{ ?>			
		<div class="hide-if-not-needed">	
			<h2 style="font-size: 14px;padding: 10px 0 15px;margin: 0;line-height: 1.4;color: #007cba;"><b>Check the box to exclude the scripts from the page</b></h2>
			<div style="margin-left: 20px;">
				<?php foreach ($listScriptList as $scripts){
					$value = get_post_meta(get_the_ID(), $scripts['handle'].'_key',true);
					
					if($scripts['src'] != false){ ?>
						<input type="checkbox" id="<?php echo $scripts['handle']; ?>" name="<?php echo $scripts['handle']; ?>" value="<?php echo $scripts['handle']; ?>"
						 <?php if($value == 'false' || $value == ''){ }else{ echo 'checked="checked"'; } ?> />
						<label style ="vertical-align: text-bottom;" for="<?php echo $scripts['handle']; ?>"><?php echo $scripts['src']; ?></label><br/><br/>
			    <?php }
				} ?>
			</div>
			<h2 style="font-size: 14px;padding: 10px 0 15px;margin: 0;line-height: 1.4;color: #007cba;"><b>Check the box to exclude the style from the page</b></h2>
			<div style="margin-left: 20px;">
				<?php foreach ($listStyleList as $styles){
					$value = get_post_meta(get_the_ID(), $styles['handle'].'_key',true);

					if($styles['src'] != false){ ?>
						<input type="checkbox" id="<?php echo $styles['handle']; ?>" name="<?php echo $styles['handle']; ?>" value="<?php echo $styles['handle']; ?>"
						 <?php if($value == 'false' || $value == ''){ }else{ echo 'checked="checked"'; } ?> />
						<label style ="vertical-align: text-bottom;" for="<?php echo $styles['handle']; ?>"><?php echo $styles['src']; ?></label><br/><br/>
			    <?php }
				} ?>
			</div>
			<a href="javascript:void(0)" style="background: #007cba;border-color: #007cba;color: #fff;text-decoration: none;border-radius: 3px;padding: 10px;  overflow: hidden;margin-top: 10px;display: inline-block;font-size: 14px;letter-spacing: .3px;" onclick="jQuery('#refresh-indication-two').show(1000); jQuery('#refresh-indication-three').show(1000); window.open('<?php echo get_the_permalink().'?updateScriptStyle=true'; ?>');">Update Script & Style List</a>
			<span id="refresh-indication-two" style="display:none;position: absolute;top: -33px;left: 158px;font-size: 13px;color: #c45200;font-weight: bold;">( Refresh Page )</span>	
			<span id="refresh-indication-three" style="display: none;position: absolute;bottom: 25px;left: 200px;font-size: 13px;color: rgb(196, 82, 0);font-weight: bold;">( Refresh Page )</span>
		</div>
	<?php } 
	}

function wporg_save_postdata($post_id)
{
	if(array_key_exists('show-hide-script-content', $_POST) && array_key_exists('show-hide-script-content', $_POST) != false){
		update_post_meta($post_id,'show-hide-script-content',$_POST['show-hide-script-content']);
	}else{
		update_post_meta($post_id,'show-hide-script-content','false');
	}
	$listStyleScriptList = get_post_meta(get_the_ID(), 'enqueued_scripts_style',true);
	$listScriptList = $listStyleScriptList['scripts'];
	$listStyleList = $listStyleScriptList['styles'];
	foreach ($listScriptList as $scripts){
		if($scripts['src'] != false){
		    if (array_key_exists($scripts['handle'], $_POST) && array_key_exists($scripts['handle'], $_POST) != false) {
		        update_post_meta(
		            $post_id,
		            $scripts['handle'].'_key',
		            $_POST[$scripts['handle']]
		        );
		    }else{
		    	update_post_meta(
		            $post_id,
		            $scripts['handle'].'_key',
		            'false'
		        );
		    }
		}
	}
	foreach ($listStyleList as $styles){
		if($styles['src'] != false){
		    if (array_key_exists($styles['handle'], $_POST) && array_key_exists($styles['handle'], $_POST) != false) {
		        update_post_meta(
		            $post_id,
		            $styles['handle'].'_key',
		            $_POST[$styles['handle']]
		        );
		    }else{
		    	update_post_meta(
		            $post_id,
		            $styles['handle'].'_key',
		            'false'
		        );
		    }
		}
	}
}
add_action('save_post', 'wporg_save_postdata');

add_action('wp_footer','close_window_to_add_script',999);

function close_window_to_add_script(){ ?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			var getUrlParameter = function getUrlParameter(sParam) {
			    var sPageURL = window.location.search.substring(1),
			        sURLVariables = sPageURL.split('&'),
			        sParameterName,
			        i;

			    for (i = 0; i < sURLVariables.length; i++) {
			        sParameterName = sURLVariables[i].split('=');

			        if (sParameterName[0] === sParam) {
			            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			        }
			    }
			};
			var close = getUrlParameter('close_window');
			if(close == 'true'){
				window.open('','_self').close();
			}
			var update = getUrlParameter('updateScriptStyle');
			if(update == 'true'){
				window.location.href="<?php echo get_the_permalink(get_queried_object_id())."?close_window=true"; ?>";
			}
		});
	</script>
<?php }

add_action( 'init' , 'include_plugin');
function include_plugin(){
	require_once( 'plugin-exclude.php' );
}

add_action('admin_footer','closeMetaBoxDefault');
function closeMetaBoxDefault(){ ?>
	<script type="text/javascript">
		jQuery('div#wporg_box_id').addClass('closed');
	</script>
<?php }

function ossite__gtm_and_seo() {
    ?>
<script src="https://script.tapfiliate.com/tapfiliate.js" type="text/javascript" async></script>
<script type="text/javascript">
  (function(t,a,p){t.TapfiliateObject=a;t[a]=t[a]||function(){ (t[a].q=t[a].q||[]).push(arguments)}})(window,'tap');
  tap('create', '15367-865a26', { integration: "javascript" });
  tap('detect');
</script>
<script>window.dataLayer = window.dataLayer || [];</script>

<!-- Page hiding snippet (recommended)  -->
<style>.async-hide { opacity: 0 !important} </style>
<script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
})(window,document.documentElement,'async-hide','dataLayer',4000,
{'GTM-MZLKFK6':true});</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-10779839-3', { 'cookieDomain': 'auto', 'siteSpeedSampleRate': 100});
  ga('require', 'GTM-MZLKFK6');
</script> 
<?php 	
	if(is_page(16912) || is_front_page()){ ?>
		<script>
			var categoryData = { 
		    		'contentCategory1': 'wp',
		    	};
			categoryData.contentCategory2 =  'home'; 
			categoryData.contentCategory3 = '<?php echo get_post()->post_type; ?>';
		    dataLayer.push(categoryData);
		</script>
	<?php }else{
		$category = get_the_category();
		$firstCategory = $category[0]->cat_name;
		?>
		<script>
			var categoryData = { 
		    		'contentCategory1': 'wp',
		    	};
			categoryData.contentCategory2 = '<?php echo $firstCategory; ?>'; 
			categoryData.contentCategory3 = '<?php echo get_post()->post_type; ?>';
		    dataLayer.push(categoryData);
		</script>
	<?php } 
?>

<!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TCK4TJG');</script>
<!-- End Google Tag Manager --> 
    <?php
}
add_action('wp_head', 'ossite__gtm_and_seo');
function showCategoryInPage() {
    // Add category metabox to page
    register_taxonomy_for_object_type('category', 'page');  
}
add_action( 'init', 'showCategoryInPage' );
// To show the column header
function custom_column_header( $columns ){
  $columns['header_name'] = 'Show public'; 
  return $columns;
}

add_filter( "manage_edit-category_columns", 'custom_column_header', 10);

// To show the column value
function custom_column_content( $value, $column_name, $tax_id ){ 
	$show_hide = get_term_meta($tax_id,'show_hide',true);
	if($show_hide == 'Yes'){ ?>
		<label for="Yes">Yes</label>
		<input type="radio" id="Yes" onchange="sendAjax('<?php echo $tax_id; ?>','Yes');" checked  name="show-cat-public<?php echo $tax_id; ?>" value="Yes" style="margin-top: auto;" /> 
		<label for="No">No</label>
		<input type="radio" id="No"  onchange="sendAjax('<?php echo $tax_id; ?>','No');"  name="show-cat-public<?php echo $tax_id; ?>" value="No" style="margin-top: auto;" /> 
	<?php }else{ ?>
		<label for="Yes">Yes</label>
		<input type="radio" id="Yes" onchange="sendAjax('<?php echo $tax_id; ?>','Yes');"  name="show-cat-public<?php echo $tax_id; ?>" value="Yes" style="margin-top: auto;" /> 
		<label for="No">No</label>
		<input type="radio" id="No"  onchange="sendAjax('<?php echo $tax_id; ?>','No');" checked name="show-cat-public<?php echo $tax_id; ?>" value="No" style="margin-top: auto;" /> 
	<?php }
	?>

	<script type="text/javascript">
		function sendAjax(id,value) {
			var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			var data = {
		            action: 'select_cateory_show_hide',
		            catId: id,
		            show_hide: value 
		        };
		     console.log(data);
		    jQuery.post(ajaxurl, data, function(response) {
			});
		}
	</script>
<?php }
add_action( "manage_category_custom_column", 'custom_column_content', 10, 3);

add_action('init','addAjaxCode');
function addAjaxCode(){
    function select_cat_show_hide_callback_function() {
        // Implement ajax function here
        update_term_meta($_POST['catId'],'show_hide',$_POST['show_hide']);
        die();
    }
    add_action( 'wp_ajax_select_cateory_show_hide', 'select_cat_show_hide_callback_function' );    // If called from admin panel
    add_action( 'wp_ajax_nopriv_select_cateory_show_hide', 'select_cat_show_hide_callback_function' );    // If called from front end
}