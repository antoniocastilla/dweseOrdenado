<?php
/*
Plugin Name: 3D tag cloud
Plugin URI: http://www.vinojcardoza.com/blog/cardoza-3d-tagcloud/
Description: 3D tag cloud displays your tags in 3D by placing them on a rotating text.
Version: 3.6
Author: Vinoj Cardoza
Author URI: http://www.vinojcardoza.com
License: GPL2
*/

add_action('admin_init', 'tagcloud_enq_scripts');
add_action("admin_menu", "cardoza_3d_tag_cloud_options");
add_action('wp_enqueue_scripts', 'tagcloud_enq_scripts');
add_action("plugins_loaded", "cardoza_3d_tagcloud_init");

function tagcloud_enq_scripts(){
	wp_enqueue_style('my-style', plugin_dir_url(__FILE__). '/public/css/cardoza3dtagcloud.css');
	wp_enqueue_script('jquery');
	wp_enqueue_script('tag_handle', plugins_url('/jquery.tagcanvas.min.js', __FILE__), array('jquery'));
	if (isset($_GET['page']) && ($_GET['page'] == 'wp_3d_tag_cloud_slug'))
	{
		if(is_admin()){
			wp_enqueue_style('tag-3d-cloud-bootstrap', plugin_dir_url(__FILE__). '/public/css/bootstrap.css');
			wp_enqueue_style('tag-3d-cloud-font-awesome', plugin_dir_url(__FILE__). '/public/fonts/font-awesome/css/font-awesome.css');
		}
		if(is_admin()){
			wp_enqueue_script('tag-3d-cloud-bootstrap-js', plugins_url('/public/js/bootstrap.js', __FILE__), array('jquery'));
			wp_enqueue_script('tag-3d-cloud-validate-form', plugins_url('/public/js/jquery.form.validator.min.js', __FILE__), array('jquery'), '', true);
			wp_enqueue_script('tag-3d-cloud-js', plugins_url('/public/js/cardoza3dtagcloud.js', __FILE__), array('jquery'), '', true);
		}
	}
}

//The following function will retrieve all the avaialable 
//options from the wordpress database
function retrieve_options(){
	$opt_val = array(
			'title' => stripslashes(get_option('c3tdc_title')),
			'no_of_tags' => stripslashes(get_option('c3tdc_noof_tags')),
			'width' => stripslashes(get_option('c3tdc_width')),
			'height' => stripslashes(get_option('c3tdc_height')),
			'bg_color' => stripslashes(get_option('c3dtc_bg_color')),
			'txt_color' => stripslashes(get_option('c3dtc_txt_color')),
			'hlt_txt_color' => stripslashes(get_option('c3dtc_hlt_txt_color')),
			'font_name' => stripslashes(get_option('c3dtc_font_name')),
			'max_font_size' => stripslashes(get_option('c3dtc_max_font_size')),
			'min_font_size' => stripslashes(get_option('c3dtc_min_font_size'))
	); 
	return $opt_val;
}

add_action('wp_head','tagcloud_js_init');

function tagcloud_js_init(){
	$option_value = retrieve_options(); 
	if(!empty($option_value['txt_color'])) $canvas_txtcolor = $option_value['txt_color'];
	else $canvas_txtcolor = "333333";
	if(!empty($option_value['bg_color'])) $canvas_outlinecolor = $option_value['bg_color'];
	else $canvas_outlinecolor = "FFFFFF";
	?>
	<script type="text/javascript">
		$j = jQuery.noConflict();
		$j(document).ready(function() {
			if(!$j('#myCanvas').tagcanvas({
				textColour: '#<?php echo $canvas_txtcolor;?>',
				outlineColour: '#<?php echo $canvas_outlinecolor;?>',
				reverse: true,
				depth: 0.8,
				textFont: null,
				weight: true,
				maxSpeed: 0.05
			},'tags')) {
				$j('#myCanvasContainer').hide();
			}
		});
	</script>
	<?php
}

function cardoza_3d_tag_cloud_options(){
	add_options_page(
		__('3D Tag Cloud'),
		__('3D Tag Cloud'),
		'manage_options',
		'wp_3d_tag_cloud_slug',
		'cardoza_3D_tc_options_page');
}

function cardoza_3D_tc_options_page(){
	require_once 'cardoza_3D_tag_cloud_options.php';
}

function widget_cardoza_3d_tagcloud($args){
	$option_value = retrieve_options();
	extract($args);
	echo $before_widget;
	echo $before_title;
	echo $option_value['title'];
	echo $after_title;
	global $wpdb;
	$tags_list = get_terms(
		'post_tag',
		array(
			'orderby' => 'count',
			'order' => 'DESC',
			'hide_empty' => 0
		)
	);
	if(sizeof($tags_list) != 0) {
		$max_count = 0;
		if (!empty($option_value['height'])) $canvas_height = $option_value['height'];
		else $canvas_height = "250";
		if (!empty($option_value['width'])) $canvas_width = $option_value['width'];
		else $canvas_width = "250";
		if (!empty($option_value['bg_color'])) $canvas_bgcolor = $option_value['bg_color'];
		else $canvas_bgcolor = "FFFFFF";

		$li_font = "";
		if (!empty($option_value['font_name'])) {
			if($option_value['font_name'] != 'Default')
				$li_font = "font-family:'".$option_value['font_name']."';";
		}

		foreach ($tags_list as $tag):
			if ($tag->count > $max_count) $max_count = $tag->count;
		endforeach;
		?>
		<div id="myCanvasContainer" style="background-color:#<?php echo $canvas_bgcolor; ?>;">
			<canvas width="<?php echo $canvas_width; ?>" height="<?php echo $canvas_height; ?>" id="myCanvas">
				<p>Anything in here will be replaced on browsers that support the canvas element</p>
			</canvas>
		</div>
		<div id="tags">
			<ul style="display:none;width:<?php print $canvas_width;?>px;height:<?php print $canvas_height;?>px;<?php print $li_font;?>">
				<?php
				if (empty($option_value['no_of_tags'])) $option_value['no_of_tags'] = 30;
				if (empty($option_value['max_font_size'])) $option_value['max_font_size'] = 36;
				if (empty($option_value['min_font_size'])) $option_value['max_font_size'] = 3;
				$i = 1;
				foreach ($tags_list as $tag):
					if ($i <= $option_value['no_of_tags']):
						$font_size = $option_value['max_font_size'] - (($max_count - $tag->count) * 2);
						if ($font_size < $option_value['min_font_size']) $font_size = $option_value['min_font_size'];
						?>
						<li>
							<a href="<?php print get_tag_link($tag->term_id);?>" style="font-size:<?php print $font_size;?>px;"><?php print $tag->name;?></a>
						</li>
						<?php
						$i++;
					endif;
				endforeach;
				?>
			</ul>
		</div>
		<?php
	}
	else echo "No tags found";
	echo $after_widget;
}

function cardoza_3d_tagcloud_init(){
	load_plugin_textdomain('cardozatagcloud', false, dirname( plugin_basename(__FILE__)).'/languages');
	wp_register_sidebar_widget('3d_tag_cloud', __('3D Tag Cloud'), 'widget_cardoza_3d_tagcloud');
}
?>