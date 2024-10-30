<?php
/*
Plugin Name: Jeba Cute Portfolio
Plugin URI: http://prowpexpert.com/jeba-cute-portfolio/
Description: This is Jeba cute wordpress portfolio plugin really looking awesome lightbox. Everyone can use the cute plugin easily like other wordpress plugin. Here everyone can show portfolio items image from post, page or other custom post. Also can use slide from every category. By using [jeba_portfolio] shortcode use the iteam every where post, page and template.
Author: Md Jahed
Version: 1.0
Author URI: http://prowpexpert.com/
*/
function portfolio_jeba_wp_latest_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'portfolio_jeba_wp_latest_jquery');

function portfolio_plugin_function_jeba() {
    wp_enqueue_script( 'jeba-portfolio-js', plugins_url( '/js/least.min.js', __FILE__ ), true);
    wp_enqueue_style( 'jeba-portfolio-css', plugins_url( '/js/least.min.css', __FILE__ ));
}
add_action('init','portfolio_plugin_function_jeba');
function portfolio_jeba_shortcode($atts){
	extract( shortcode_atts( array(
		'category' => '',
		'post_type' => 'jeba-pitems',
		'count' => '-1',
	), $atts) );
	
    $q = new WP_Query(
        array('posts_per_page' => $count, 'post_type' => $post_type, 'category_name' => $category)
        );		
		
		$plugins_url = plugins_url();
		
	$list = '
		<section id="least">
            
            <!-- Least Gallery: Fullscreen Preview -->
            <div class="least-preview"></div>
            
            <!-- Least Gallery: Thumbnails -->
            <ul class="least_gallery">
	';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$jeba_img_portfolio_large = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large_img' );
		$jeba_img_portfolio_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumb_img' );
		
		$list .= '
			
			<li>
				<a href="'.$jeba_img_portfolio_large[0].'" title="'.get_the_title().'" data-subtitle="'.get_the_excerpt().'" data-caption="'.get_the_excerpt().'">
					<img src="'.$jeba_img_portfolio_thumb[0].'" alt="" />
				</a>
			</li>
		';        
	endwhile;
	$list.= '
		
            </ul>

        </section>
	';
	wp_reset_query();
	return $list;
}
add_shortcode('jeba_portfolio', 'portfolio_jeba_shortcode');
add_action( 'init', 'portfolio_jeba_custom_post' );
function portfolio_jeba_custom_post() {

	register_post_type( 'jeba-pitems',
		array(
			'labels' => array(
				'name' => __( 'JebaPortfolios' ),
				'singular_name' => __( 'JebaPortfolio' )
			),
			'public' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'jeba-portfolio'),
			'taxonomies' => array('category', 'post_tag') 
		)
	);	
	}
function portfolio_jeba_plugin_function () {?>
        <script type="text/javascript">
                 jQuery(document).ready(function(){
                jQuery('.least_gallery').least();
            }); 
        </script>
<?php
}
add_action('wp_footer','portfolio_jeba_plugin_function');
function  portfolio_jeba_add_mce_button() {
if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
return;
}
if ( 'true' == get_user_option( 'rich_editing' ) ) {
add_filter( 'mce_external_plugins', 'portfolio_jeba_add_tinymce_plugin' );
add_filter( 'mce_buttons', 'portfolio_jeba_register_mce_button' );
}
}
add_action('admin_head', 'portfolio_jeba_add_mce_button');

function  portfolio_jeba_add_tinymce_plugin( $plugin_array ) {
$plugin_array['portfolio_jeba_slider_button'] = plugins_url('/js/tinymce-button.js', __FILE__ );
return $plugin_array;
}
function portfolio_jeba_register_mce_button( $buttons ) {
array_push( $buttons, 'portfolio_jeba_slider_button' );
return $buttons;
}
add_theme_support( 'post-thumbnails', array( 'post', 'jeba-pitems' ) );

add_image_size( 'large_img', 950, 600, true );
add_image_size( 'thumb_img', 250, 150, true );
?>