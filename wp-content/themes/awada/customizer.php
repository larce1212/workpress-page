<?php
function awada_customizer_preview_js()
{
    wp_enqueue_script('custom_css_preview', get_template_directory_uri() . '/js/customize-preview.js', array('customize-preview', 'jquery'));
}
add_action('customize_preview_init', 'awada_customizer_preview_js');

if(!function_exists('awada_get_post_select')):
	function awada_get_post_select() {
	$all_posts = wp_count_posts('post')->publish;
	$latest = new WP_Query( array(
	'post_type'   => 'post',
	'post_per_page'=>$all_posts,
	'post_status' => 'publish',
	'orderby'     => 'date',
	'order'       => 'DESC'
	));
	  $results;
	  if(!empty($latest)):
		  $results['default'] = __('Select Post','awada');
		  while( $latest->have_posts() ) { $latest->the_post();
			$results[get_the_id()] = get_the_title();
			
		  }
	  endif;
	  
	  return $results;
	}
endif;
/* Add Customizer Panel */
$awada_theme_options = awada_theme_options();
Kirki::add_config('awada_theme', array(
    'capability'  => 'edit_theme_options',
    'option_type' => 'option',
    'option_name' => 'awada_theme_options',
));
Kirki::add_panel('awada_option_panel', array(
    'priority'    => 10,
    'title'       => __('Awada Options', 'awada'),
    'description' => __('Here you can customize all your site contents', 'awada'),
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'header_topbar_bg_color',
    'label'             => __('Header Top Bar Background Color', 'awada'),
    'description'       => __('Change Top bar Background Color', 'awada'),
    'section'           => 'colors',
    'type'              => 'color',
    'priority'          => 9,
    'default'           => '#f8504b',
    'sanitize_callback' => 'awada_sanitize_color',
    'output'            => array(
        array(
            'element'  => '#sitetopbar',
            'property' => 'background',
        ),
        array(
            'element'  => '#sitetopbar',
            'property' => 'border-bottom',
        ),
    ),
    'transport'         => 'auto',
));

Kirki::add_field('awada_theme', array(
    'settings'          => 'header_topbar_color',
    'label'             => __('Header Top Bar Text Color', 'awada'),
    'description'       => __('Change Top bar Font/Content Color', 'awada'),
    'section'           => 'colors',
    'type'              => 'color',
    'priority'          => 9,
    'default'           => '#fff',
    'sanitize_callback' => 'awada_sanitize_color',
    'output'            => array(
        array(
            'element'  => '#sitetopbar, #sitetopbar a',
            'property' => 'color',
        ),
    ),
    'transport'         => 'auto',
));

Kirki::add_field('awada_theme', array(
    'settings'          => 'header_background_color',
    'label'             => __('Header Background Color', 'awada'),
    'description'       => __('Change Header Background Color', 'awada'),
    'section'           => 'colors',
    'type'              => 'color',
    'priority'          => 9,
    'default'           => '#fff',
    'sanitize_callback' => 'awada_sanitize_color',
    'output'            => array(
        array(
            'element'  => '#awada-header, #awada-header .navbar',
            'property' => 'background',
        ),
		array(
            'element'  => '.arrow-up',
            'property' => 'border-bottom',
        ),
    ),
    'transport'         => 'auto',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'header_textcolor',
    'label'             => __('Header Text Color', 'awada'),
    'description'       => __('Change Header Text Color', 'awada'),
    'section'           => 'colors',
    'type'              => 'color',
    'priority'          => 9,
    'default'           => '#222222',
    'sanitize_callback' => 'awada_sanitize_color',
    'output'            => array(
        array(
            'element'  => '.navbar-default .navbar-brand, #awada-header .navbar-nav > li > a, .dropdown-menu > li > a',
            'property' => 'color',
        ),
    ),
    'transport'         => 'auto',
));

Kirki::add_section('general_sec', array(
    'title'       => __('General Options', 'awada'),
    'description' => __('Here you can change basic settings of your site', 'awada'),
    'panel'       => 'awada_option_panel',
    'priority'    => 160,
    'capability'  => 'edit_theme_options',
));

Kirki::add_field('awada_theme', array(
    'settings'          => 'logo_top_spacing',
    'label'             => __('Logo Top Spacing', 'awada'),
    'section'           => 'general_sec',
    'type'              => 'slider',
    'priority'          => 10,
    'default'           => 0,
    'choices'           => array(
        'max'  => 50,
        'min'  => -50,
        'step' => 1,
    ),
    'transport'         => 'auto',
    'output'            => array(
        array(
            'element'  => '#awada-header .dropmenu img',
            'property' => 'margin-top',
            'units'    => 'px',
        ),
		array(
            'element'  => '#awada-header .navbar-brand',
            'property' => 'margin-top',
            'units'    => 'px',
        ),
    ),
    'sanitize_callback' => 'awada_sanitize_number',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'logo_bottom_spacing',
    'label'             => __('Logo Bottom Spacing', 'awada'),
    'section'           => 'general_sec',
    'type'              => 'slider',
    'priority'          => 10,
    'default'           => 0,
    'choices'           => array(
        'max'  => 50,
        'min'  => -50,
        'step' => 1,
    ),
    'transport'         => 'auto',
    'output'            => array(
        array(
            'element'  => '#awada-header .dropmenu img',
            'property' => 'margin-bottom',
            'units'    => 'px',
        ),
		array(
            'element'  => '#awada-header .navbar-brand',
            'property' => 'margin-bottom',
            'units'    => 'px',
        ),
    ),
    'sanitize_callback' => 'awada_sanitize_number',
));
Kirki::add_field('awada_theme', array(
    'type'                 => 'textarea',
    'settings'             => 'custom_css',
    'label'                => __('Custom CSS', 'awada'),
    'description'          => __('Put your custom css here', 'awada'),
    'section'              => 'general_sec',
    'default'              => '',
    'priority'             => 10,
    'sanitize_callback'    => 'wp_filter_nohtml_kses',
    'sanitize_js_callback' => 'wp_filter_nohtml_kses',
));

/* Typography */
Kirki::add_section('typography_sec', array(
    'title'       => __('Typography Section', 'awada'),
    'description' => __('Here you can change Font Style of your site', 'awada'),
    'panel'       => 'awada_option_panel',
    'priority'    => 160,
    'capability'  => 'edit_theme_options',
));

Kirki::add_field('awada_theme', array(
    'type'        => 'typography',
    'settings'    => 'logo_font',
    'label'       => __('Logo Font Style', 'awada'),
    'description' => __('Change logo font family and font style.', 'awada'),
    'section'     => 'typography_sec',
    'default'     => array(
        'font-style'  => array('bold', 'italic'),
        'font-family' => 'Courgette',
    ),
    'priority'    => 10,
    'choices'     => array(
        'font-style'  => true,
        'font-family' => true,
        'font-size'   => true,
        'line-height' => true,
        'font-weight' => true,
    ),
    'output'      => array(
        array(
            'element' => '#awada-header .navbar-brand p',
        ),
    ),
));
Kirki::add_field('awada_theme', array(
    'type'        => 'typography',
    'settings'    => 'menu_font',
    'label'       => __('Menu Font Style', 'awada'),
    'description' => __('Change Primary Menu font family and font style.', 'awada'),
    'section'     => 'typography_sec',
    'default'     => array(
        'font-style'  => array('bold', 'italic'),
        'font-family' => "Merriweather","Georgia", "serif",

    ),
    'priority'    => 10,
    'choices'     => array(
        'font-style'  => true,
        'font-family' => true,
        'font-size'   => true,
        'line-height' => true,
        'font-weight' => true,
    ),
    'output'      => array(
        array(
            'element' => '#awada-header .navbar-nav > li > a',
        ),
    ),
));

/* Full body typography */
Kirki::add_field('awada_theme', array(
    'type'        => 'typography',
    'settings'    => 'site_font',
    'label'       => __('Site Font Style', 'awada'),
    'description' => __('Change whole site font family and font style.', 'awada'),
    'section'     => 'typography_sec',
    'default'     => array(
        'font-style'  => array('bold', 'italic'),
        'font-family' => "Merriweather","Georgia", "serif",
    ),
    'priority'    => 10,
    'choices'     => array(
        'font-style'  => true,
        'font-family' => true,
    ),
    'output'      => array(
        array(
            'element' => 'body, h1, h2, h3, h4, h5, h6, p, em, blockquote',
        ),
    ),
));
/* Home title typography */
Kirki::add_field('awada_theme', array(
    'type'        => 'typography',
    'settings'    => 'site_title_font',
    'label'       => __('Home Sections Title Font', 'awada'),
    'description' => __('Change font style of home service, home portfolio, home blog', 'awada'),
    'section'     => 'typography_sec',
    'default'     => array(
        'font-style'  => array('bold', 'italic'),
        'font-family' => "Merriweather","Georgia", "serif",
    ),
    'priority'    => 10,
    'choices'     => array(
        'font-style'  => true,
        'font-family' => true,
        'font-size'   => true,
        'line-height' => true,
        'font-weight' => true,
    ),
    'output'      => array(
        array(
            'element' => '.main_title h2',
        ),
    ),
));
/* Layout section */
Kirki::add_section('layout_sec', array(
    'title'       => __('Layout Options', 'awada'),
    'description' => __('Here you can change Layout and basic design of your site', 'awada'),
    'panel'       => 'awada_option_panel',
    'priority'    => 160,
    'capability'  => 'edit_theme_options',
    'transport'   => 'postMessage',
));
Kirki::add_field('awada_theme', array(
    'type'              => 'toggle',
    'settings'          => 'headersticky',
    'label'             => __('Fixed Header', 'awada'),
    'description'       => __('Switch between fixed and static header', 'awada'),
    'section'           => 'layout_sec',
    'default'           => $awada_theme_options['headersticky'],
    'priority'          => 10,
    'sanitize_callback' => 'awada_sanitize_checkbox',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'site_layout',
    'label'             => __('Site Layout', 'awada'),
    'description'       => __('Change your site layout to full width or boxed size.', 'awada'),
    'section'           => 'layout_sec',
    'type'              => 'radio-image',
    'priority'          => 10,
    'default'           => '',
    'sanitize_callback' => 'awada_sanitize_text',
    'choices'           => array(
        ''           => get_template_directory_uri() . '/images/layout/1c.png',
        'boxed' => get_template_directory_uri() . '/images/layout/3cm.png',
    ),

));
Kirki::add_field('awada_theme', array(
    'settings'          => 'footer_layout',
    'label'             => __('Footer Layout', 'awada'),
    'description'       => __('Change footer into 2, 3 or 4 column', 'awada'),
    'section'           => 'layout_sec',
    'type'              => 'radio-image',
    'priority'          => 10,
    'default'           => $awada_theme_options['footer_layout'],
    'transport'         => 'postMessage',
    'choices'           => array(
        2 => get_template_directory_uri() . '/images/layout/footer-widgets-2.png',
        3 => get_template_directory_uri() . '/images/layout/footer-widgets-3.png',
        4 => get_template_directory_uri() . '/images/layout/footer-widgets-4.png',
    ),
    'sanitize_callback' => 'awada_sanitize_number',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'blog_layout',
    'label'             => __('Blog Post Layout', 'awada'),
    'description'       => __('Select Blog Layout', 'awada'),
    'help'              => __('With this option you can select blog left sidebar,right sidebar and full width', 'awada'),
    'section'           => 'layout_sec',
    'type'              => 'radio-image',
    'priority'          => 10,
    'default'           => $awada_theme_options['blog_layout'],
    'choices'           => array(
        'rightsidebar' => get_template_directory_uri() . '/images/layout/2cr.png',
        'leftsidebar'  => get_template_directory_uri() . '/images/layout/2cl.png',
        'fullwidth'  => get_template_directory_uri() . '/images/layout/1c.png',
    ),
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'post_layout',
    'label'             => __('Single Post Layout', 'awada'),
    'description'       => __('Select Post Layout', 'awada'),
    'help'              => __('With this option you can select single post with left sidebar,right sidebar and full width', 'awada'),
    'section'           => 'layout_sec',
    'type'              => 'radio-image',
    'priority'          => 10,
    'default'           => $awada_theme_options['post_layout'],
    'choices'           => array(
        'leftsidebar' => get_template_directory_uri() . '/images/layout/2cl.png',
        'rightsidebar' => get_template_directory_uri() . '/images/layout/2cr.png',
        'fullwidth' => get_template_directory_uri() . '/images/layout/1c.png',
    ),
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'page_layout',
    'label'             => __('Page Layout', 'awada'),
    'description'       => __('Select Page Layout', 'awada'),
    'help'              => __('With this option you can select page with left sidebar,right sidebar and full width', 'awada'),
    'section'           => 'layout_sec',
    'type'              => 'radio-image',
    'priority'          => 10,
    'default'           => $awada_theme_options['page_layout'],
    'choices'           => array(
        'leftsidebar' => get_template_directory_uri() . '/images/layout/2cl.png',
        'rightsidebar' => get_template_directory_uri() . '/images/layout/2cr.png',
        'fullwidth' => get_template_directory_uri() . '/images/layout/1c.png',
    ),
    'sanitize_callback' => 'awada_sanitize_text',
));
/* Slider */
Kirki::add_section('slider_sec', array(
    'title'       => __('Slider Options', 'awada'),
    'description' => __('Change slider text(s) and images', 'awada'),
    'panel'       => 'awada_option_panel',
    'priority'    => 160,
    'capability'  => 'edit_theme_options',
));

Kirki::add_field('awada_theme', array(
    'settings'          => 'home_slider_enabled',
    'label'             => __('Enable Home Slider', 'awada'),
    'section'           => 'slider_sec',
    'type'              => 'switch',
    'priority'          => 10,
    'default'           => 1,
	'transport'         => 'postMessage',
    'sanitize_callback' => 'awada_sanitize_checkbox',
));
$args = array(
    'posts_per_page'   => -1,
    'offset'           => 0,
    'orderby'          => 'date',
    'order'            => 'DESC',
    'post_type'        => 'post',
    'post_status'      => 'publish',
    'post__not_in'     => get_option('sticky_posts'),
    'suppress_filters' => true,
);
$posts_list = get_posts($args);
foreach ($posts_list as $post) {
    $posts[$post->ID] = $post->post_title;
}
Kirki::add_field('awada_theme', array(
    'type'              => 'select',
    'settings'          => 'home_slider_posts',
    'label'             => __('Select Posts to be Shown in Slider', 'awada'),
    'help'              => __('You can also be able to drag-n-drop the selected options and rearrange their order for maximum flexibility', 'awada'),
    'section'           => 'slider_sec',
    'priority'          => 10,
    'default'           => 0,
    'choices'           => $posts,
    'multiple'          => 4,
    'sanitize_callback' => 'awada_sanitize_selected',
));

/* Service Options */
Kirki::add_section('service_sec', array(
    'title'      => __('Service Options', 'awada'),
    'panel'      => 'awada_option_panel',
    'priority'   => 160,
    'capability' => 'edit_theme_options',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'home_service_title',
    'label'             => __('Home Service Heading', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['home_service_title'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'home_service_description',
    'label'             => __('Home Service Description', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'textarea',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['home_service_description'],
    'sanitize_callback' => 'awada_sanitize_textarea',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'home_service_column',
    'label'             => __('Home Service Column', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'select',
    'priority'          => 10,
    'default'           => 4,
    'choices'           => array(
        2 => __('Two Column', 'awada'),
        3 => __('Three Column', 'awada'),
        4 => __('Four Column', 'awada'),
    ),
    'sanitize_callback' => 'awada_sanitize_number',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_icon_1',
    'label'             => __('Service One Icon', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_icon_1'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_title_1',
    'label'             => __('Service One Title', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_title_1'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_text_1',
    'label'             => __('Service One Description', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'textarea',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_text_1'],
    'sanitize_callback' => 'awada_sanitize_textarea',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_link_1',
    'label'             => __('Service One URL', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_link_1'],
    'sanitize_callback' => 'esc_url',
));
/* Service 2 */
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_icon_2',
    'label'             => __('Service Two Icon', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_icon_2'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_title_2',
    'label'             => __('Service Two Title', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_title_2'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_text_2',
    'label'             => __('Service Two Description', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'textarea',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_text_2'],
    'sanitize_callback' => 'awada_sanitize_textarea',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_link_2',
    'label'             => __('Service Two URL', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'url',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_link_2'],
    'sanitize_callback' => 'esc_url',
));
/* Service 3 */
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_icon_3',
    'label'             => __('Service Three Icon', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_icon_3'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_title_3',
    'label'             => __('Service Three Title', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_title_3'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_text_3',
    'label'             => __('Service Three Description', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'textarea',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_text_3'],
    'sanitize_callback' => 'awada_sanitize_textarea',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_link_3',
    'label'             => __('Service Three URL', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'url',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_link_3'],
    'sanitize_callback' => 'esc_url',
));
/* Service 4 */
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_icon_4',
    'label'             => __('Service Four Icon', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_icon_4'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_title_4',
    'label'             => __('Service Four Title', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_title_4'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_text_4',
    'label'             => __('Service Four Description', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'textarea',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_text_4'],
    'sanitize_callback' => 'awada_sanitize_textarea',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'service_link_4',
    'label'             => __('Service Four URL', 'awada'),
    'section'           => 'service_sec',
    'type'              => 'url',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['service_link_4'],
    'sanitize_callback' => 'esc_url',
));
/* Portfolio */
Kirki::add_section('portfolio_sec', array(
    'title'      => __('Portfolio Options', 'awada'),
    'panel'      => 'awada_option_panel',
    'priority'   => 160,
    'capability' => 'edit_theme_options',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'portfolio_post',
    'label'             => __('Select a post', 'awada'),
    'description'       => __('Select the post in which you have put shortcode.', 'awada'),
    'section'           => 'portfolio_sec',
    'type'              => 'select',
    'priority'          => 10,
    'choices'           => awada_get_post_select(),
    'sanitize_callback' => 'awada_sanitize_number',
));
/* Blog Options */
Kirki::add_section('blog_sec', array(
    'title'      => __('Blog Options', 'awada'),
    'panel'      => 'awada_option_panel',
    'priority'   => 160,
    'capability' => 'edit_theme_options',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'home_blog_title',
    'label'             => __('Home Blog Title', 'awada'),
    'section'           => 'blog_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['home_blog_title'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'home_blog_description',
    'label'             => __('Home Blog Description', 'awada'),
    'section'           => 'blog_sec',
    'type'              => 'textarea',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['home_blog_description'],
    'sanitize_callback' => 'awada_sanitize_textarea',
));
$categories = get_categories( array(
	'orderby' => 'name',
	'order'   => 'ASC'
) );
foreach( $categories as $category ) {
	$cats[$category->term_id] = $category->name;
}
$count_posts = wp_count_posts();
$published_posts = $count_posts->publish;
Kirki::add_field('awada_theme', array(
    'settings'          => 'blog_post_count',
    'label'             => __('Blog Load More Posts', 'awada'),
    'description'       => __('Show Posts On Blog Home', 'awada'),
    'help'              => __('With this option you can show blog posts according your requirement', 'awada'),
    'section'           => 'blog_sec',
    'type'              => 'select',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => 3,
    'choices'           => array(
        3                => 3,
        6                => 6,
        9                => 9,
        12               => 12,
        15               => 15,
        $published_posts => 'Show All Posts',
    ),
    'sanitize_callback' => 'awada_sanitize_number',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'home_post_cat',
    'label'             => __('Category', 'awada'),
    'description'       => __('Show Posts On Blog Home According to Selected Categories', 'awada'),
    'help'              => __('With this option you can show blog posts according your requirement', 'awada'),
    'section'           => 'blog_sec',
    'type'              => 'select',
	'transport'         => 'postMessage',
    'priority'          => 10,
    'default'           => 0,
	'multiple'          => 10,
    'choices'           => $cats,
    'sanitize_callback' => 'awada_sanitize_number',
));
/* Footer Callout */
Kirki::add_section('callout_sec', array(
    'title'      => __('Callout Options', 'awada'),
    'panel'      => 'awada_option_panel',
    'priority'   => 160,
    'capability' => 'edit_theme_options',
));

Kirki::add_field('awada_theme', array(
    'settings'          => 'home_callout_title',
    'label'             => __('Callout Title', 'awada'),
    'section'           => 'callout_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['home_callout_title'],
    'sanitize_callback' => 'awada_sanitize_text',
));

Kirki::add_field('awada_theme', array(
    'settings'          => 'home_callout_description',
    'label'             => __('Show Footer Callout', 'awada'),
    'section'           => 'callout_sec',
    'type'              => 'textarea',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['home_callout_description'],
    'sanitize_callback' => 'awada_sanitize_textarea',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'callout_btn_text',
    'label'             => __('Callout Button Text', 'awada'),
    'section'           => 'callout_sec',
    'type'              => 'text',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['callout_btn_text'],
    'sanitize_callback' => 'awada_sanitize_text',
));

Kirki::add_field('awada_theme', array(
    'settings'          => 'callout_btn_link',
    'label'             => __('Callout Button URL', 'awada'),
    'section'           => 'callout_sec',
    'type'              => 'url',
    'priority'          => 10,
    'transport'         => 'postMessage',
    'default'           => $awada_theme_options['callout_btn_link'],
    'sanitize_callback' => 'esc_url',
));
/* Social Options */
Kirki::add_section('social_sec', array(
    'title'      => __('Contact and Social Options', 'awada'),
    'panel'      => 'awada_option_panel',
    'priority'   => 160,
    'capability' => 'edit_theme_options',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'contact_info_header',
    'label'             => __('Header Contact Info', 'awada'),
    'description'       => __('Show/Hide contact info bar in header', 'awada'),
    'section'           => 'social_sec',
    'type'              => 'switch',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['contact_info_header'],
    'sanitize_callback' => 'awada_sanitize_checkbox',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'contact_email',
    'label'             => __('Contact Email Address', 'awada'),
    'section'           => 'social_sec',
    'type'              => 'text',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['contact_email'],
    'sanitize_callback' => 'sanitize_email',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'contact_phone',
    'label'             => __('Phone Number', 'awada'),
    'section'           => 'social_sec',
    'type'              => 'text',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['contact_phone'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'social_media_header',
    'label'             => __('Enable Social Icon', 'awada'),
    'description'       => __('Show/Hide social icons in header', 'awada'),
    'section'           => 'social_sec',
    'type'              => 'switch',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['social_media_header'],
    'sanitize_callback' => 'awada_sanitize_checkbox',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'social_facebook_link',
    'label'             => __('Facebook Profile URL', 'awada'),
    'section'           => 'social_sec',
    'type'              => 'url',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['social_facebook_link'],
    'sanitize_callback' => 'esc_url',
));

Kirki::add_field('awada_theme', array(
    'settings'          => 'social_twitter_link',
    'label'             => __('Twitter Profile URL', 'awada'),
    'section'           => 'social_sec',
    'type'              => 'url',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['social_twitter_link'],
    'sanitize_callback' => 'esc_url',
));

Kirki::add_field('awada_theme', array(
    'settings'          => 'social_google_plus_link',
    'label'             => __('Google+ Profile URL', 'awada'),
    'section'           => 'social_sec',
    'type'              => 'url',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['social_google_plus_link'],
    'sanitize_callback' => 'esc_url',
));

Kirki::add_field('awada_theme', array(
    'settings'          => 'social_skype_link',
    'label'             => __('Skype ID', 'awada'),
    'section'           => 'social_sec',
    'type'              => 'text',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['social_skype_link'],
    'sanitize_callback' => 'awada_sanitize_text',
));

Kirki::add_field('awada_theme', array(
    'settings'          => 'social_youtube_link',
    'label'             => __('YouTube URL', 'awada'),
    'section'           => 'social_sec',
    'type'              => 'url',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['social_youtube_link'],
    'sanitize_callback' => 'esc_url',
));

Kirki::add_field('awada_theme', array(
    'settings'          => 'social_dribbble_link',
    'label'             => __('Dribbble URL', 'awada'),
    'section'           => 'social_sec',
    'type'              => 'url',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['social_dribbble_link'],
    'sanitize_callback' => 'esc_url',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'social_linkedin_link',
    'label'             => __('Linkedin URL', 'awada'),
    'section'           => 'social_sec',
    'type'              => 'url',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['social_linkedin_link'],
    'sanitize_callback' => 'esc_url',
));
/* footer options */
Kirki::add_section('footer_sec', array(
    'title'      => __('Footer Options', 'awada'),
    'panel'      => 'awada_option_panel',
    'priority'   => 160,
    'capability' => 'edit_theme_options',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'footer_background_color',
    'label'             => __('Footer Background Color', 'awada'),
    'description'       => __('Change Footer Background Color', 'awada'),
    'section'           => 'footer_sec',
    'type'              => 'color',
    'priority'          => 9,
    'default'           => '#121214',
    'sanitize_callback' => 'awada_sanitize_color',
    'output'            => array(
        array(
            'element'  => '#awada_footer_area',
            'property' => 'background',
        ),
    ),
    'transport'         => 'auto',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'footer_text_color',
    'label'             => __('Footer Text Color', 'awada'),
    'description'       => __('Change Footer Text Color', 'awada'),
    'section'           => 'footer_sec',
    'type'              => 'color',
    'priority'          => 9,
    'default'           => '#f8504b',
    'sanitize_callback' => 'awada_sanitize_color',
    'output'            => array(
        array(
            'element'  => '#awada_footer_area li a, #awada_footer_area a',
            'property' => 'color',
        ),
    ),
    'transport'         => 'auto',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'copyright_section_bg_color',
    'label'             => __('Copyright Section Background Color', 'awada'),
    'description'       => __('Change Copyright Section Background Color', 'awada'),
    'section'           => 'footer_sec',
    'type'              => 'color',
    'priority'          => 9,
    'default'           => '#f8504b',
    'sanitize_callback' => 'awada_sanitize_color',
    'output'            => array(
        array(
            'element'  => '#copyrights',
            'property' => 'background',
        ),
    ),
    'transport'         => 'auto',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'copyright_section_text_color',
    'label'             => __('Copyright Section Text Color', 'awada'),
    'description'       => __('Change Copyright Section Text Color', 'awada'),
    'section'           => 'footer_sec',
    'type'              => 'color',
    'priority'          => 9,
    'default'           => '#fff',
    'sanitize_callback' => 'awada_sanitize_color',
    'output'            => array(
        array(
            'element'  => '#copyrights, .footer-area-menu li a',
            'property' => 'color',
        ),
    ),
    'transport'         => 'auto',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'footer_copyright',
    'label'             => __('Copyright Text', 'awada'),
    'section'           => 'footer_sec',
    'type'              => 'text',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['footer_copyright'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'developed_by_text',
    'label'             => __('Developed by Text', 'awada'),
    'section'           => 'footer_sec',
    'type'              => 'text',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['developed_by_text'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'developed_by_link_text',
    'label'             => __('Link Text', 'awada'),
    'section'           => 'footer_sec',
    'type'              => 'text',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['developed_by_link_text'],
    'sanitize_callback' => 'awada_sanitize_text',
));
Kirki::add_field('awada_theme', array(
    'settings'          => 'developed_by_link',
    'label'             => __('Developed by Link', 'awada'),
    'section'           => 'footer_sec',
    'type'              => 'url',
    'priority'          => 10,
	'transport'         => 'postMessage',
    'default'           => $awada_theme_options['developed_by_link'],
    'sanitize_callback' => 'esc_url',
));

/* Home Page Customizer */
Kirki::add_section('home_customize_section', array(
    'title'      => __('Home Page Reorder Sections', 'awada'),
    'panel'      => 'awada_option_panel',
    'priority'   => 160,
    'capability' => 'edit_theme_options',
));
Kirki::add_field( 'awada_theme', array(
    'type'        => 'sortable',
    'settings'    => 'home_sections',
    'label'       => __( 'Here You can reorder your homepage section', 'awada' ),
    'section'     => 'home_customize_section',
    'default'     => array(
        'service',
        'portfolio',
        'blog',
        'callout'
    ),
    'choices'     => array(
        'service' => esc_attr__( 'Service Section', 'awada' ),
        'portfolio' => esc_attr__( 'Portfolio Section', 'awada' ),
        'blog' => esc_attr__( 'Blog Section', 'awada' ),
        'callout' => esc_attr__( 'Callout Section', 'awada' ),
    ),
    'priority'    => 10,
) );
function awada_sanitize_text($input)
{
    return wp_kses_post(force_balance_tags($input));
}

function awada_sanitize_checkbox($checked)
{
    return ((isset($checked) && (true == $checked || 'on' == $checked)) ? true : false);
}

/**
 * Sanitize number options
 */
function awada_sanitize_number($value)
{
    if (is_array($value)) {
        foreach ($value as $key => $val) {
            $v[$key] = is_numeric($val) ? $val : intval($val);
        }
        return $v;
    } else {
        return (is_numeric($value)) ? $value : intval($value);
    }
}
function awada_sanitize_selected($value)
{
    if ($value[0] == '') {
        return $value = '';
    } else {
        return wp_kses_post($value);
    }
}
function awada_sanitize_color($color)
{

    if ($color == "transparent") {
        return $color;
    }

    $named = json_decode('{"transparent":"transparent", "aliceblue":"#f0f8ff","antiquewhite":"#faebd7","aqua":"#00ffff","aquamarine":"#7fffd4","azure":"#f0ffff", "beige":"#f5f5dc","bisque":"#ffe4c4","black":"#000000","blanchedalmond":"#ffebcd","blue":"#0000ff","blueviolet":"#8a2be2","brown":"#a52a2a","burlywood":"#deb887", "cadetblue":"#5f9ea0","chartreuse":"#7fff00","chocolate":"#d2691e","coral":"#ff7f50","cornflowerblue":"#6495ed","cornsilk":"#fff8dc","crimson":"#dc143c","cyan":"#00ffff", "darkblue":"#00008b","darkcyan":"#008b8b","darkgoldenrod":"#b8860b","darkgray":"#a9a9a9","darkgreen":"#006400","darkkhaki":"#bdb76b","darkmagenta":"#8b008b","darkolivegreen":"#556b2f", "darkorange":"#ff8c00","darkorchid":"#9932cc","darkred":"#8b0000","darksalmon":"#e9967a","darkseagreen":"#8fbc8f","darkslateblue":"#483d8b","darkslategray":"#2f4f4f","darkturquoise":"#00ced1", "darkviolet":"#9400d3","deeppink":"#ff1493","deepskyblue":"#00bfff","dimgray":"#696969","dodgerblue":"#1e90ff", "firebrick":"#b22222","floralwhite":"#fffaf0","forestgreen":"#228b22","fuchsia":"#ff00ff", "gainsboro":"#dcdcdc","ghostwhite":"#f8f8ff","gold":"#ffd700","goldenrod":"#daa520","gray":"#808080","green":"#008000","greenyellow":"#adff2f", "honeydew":"#f0fff0","hotpink":"#ff69b4", "indianred ":"#cd5c5c","indigo ":"#4b0082","ivory":"#fffff0","khaki":"#f0e68c", "lavender":"#e6e6fa","lavenderblush":"#fff0f5","lawngreen":"#7cfc00","lemonchiffon":"#fffacd","lightblue":"#add8e6","lightcoral":"#f08080","lightcyan":"#e0ffff","lightgoldenrodyellow":"#fafad2", "lightgrey":"#d3d3d3","lightgreen":"#90ee90","lightpink":"#ffb6c1","lightsalmon":"#ffa07a","lightseagreen":"#20b2aa","lightskyblue":"#87cefa","lightslategray":"#778899","lightsteelblue":"#b0c4de", "lightyellow":"#ffffe0","lime":"#00ff00","limegreen":"#32cd32","linen":"#faf0e6", "magenta":"#ff00ff","maroon":"#800000","mediumaquamarine":"#66cdaa","mediumblue":"#0000cd","mediumorchid":"#ba55d3","mediumpurple":"#9370d8","mediumseagreen":"#3cb371","mediumslateblue":"#7b68ee", "mediumspringgreen":"#00fa9a","mediumturquoise":"#48d1cc","mediumvioletred":"#c71585","midnightblue":"#191970","mintcream":"#f5fffa","mistyrose":"#ffe4e1","moccasin":"#ffe4b5", "navajowhite":"#ffdead","navy":"#000080", "oldlace":"#fdf5e6","olive":"#808000","olivedrab":"#6b8e23","orange":"#ffa500","orangered":"#ff4500","orchid":"#da70d6", "palegoldenrod":"#eee8aa","palegreen":"#98fb98","paleturquoise":"#afeeee","palevioletred":"#d87093","papayawhip":"#ffefd5","peachpuff":"#ffdab9","peru":"#cd853f","pink":"#ffc0cb","plum":"#dda0dd","powderblue":"#b0e0e6","purple":"#800080", "red":"#ff0000","rosybrown":"#bc8f8f","royalblue":"#4169e1", "saddlebrown":"#8b4513","salmon":"#fa8072","sandybrown":"#f4a460","seagreen":"#2e8b57","seashell":"#fff5ee","sienna":"#a0522d","silver":"#c0c0c0","skyblue":"#87ceeb","slateblue":"#6a5acd","slategray":"#708090","snow":"#fffafa","springgreen":"#00ff7f","steelblue":"#4682b4", "tan":"#d2b48c","teal":"#008080","thistle":"#d8bfd8","tomato":"#ff6347","turquoise":"#40e0d0", "violet":"#ee82ee", "wheat":"#f5deb3","white":"#ffffff","whitesmoke":"#f5f5f5", "yellow":"#ffff00","yellowgreen":"#9acd32"}', true);

    if (isset($named[strtolower($color)])) {
        /* A color name was entered instead of a Hex Value, convert and send back */
        return $named[strtolower($color)];
    }

    $color = str_replace('#', '', $color);
    if (strlen($color) == 3) {
        $color = $color . $color;
    }
    if (preg_match('/^[a-f0-9]{6}$/i', $color)) {
        return '#' . $color;
    }
    //$this->error = $this->field;
    return false;
}

function awada_sanitize_textarea($value)
{
    return wp_kses_post(force_balance_tags($value));
}

function awada_customize_register_active( $wp_customize ) {
	$awada_theme_options = awada_theme_options();
	if ($awada_theme_options['site_layout'] != 'boxed') {
		$wp_customize->remove_section('background_image');
	}
	$wp_customize->remove_control('header_textcolor');
}
add_action( 'customize_register', 'awada_customize_register_active' );
?>