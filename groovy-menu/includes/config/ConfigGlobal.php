<?php defined( 'ABSPATH' ) || die( 'This script cannot be accessed directly.' );

$default_post_types = array( 'page', 'post', 'product' );
global $gm_supported_module;
if ( ! empty( $gm_supported_module['post_types'] ) ) {
	foreach ( $gm_supported_module['post_types'] as $post_type => $post_name ) {
		if ( in_array( $post_type, $default_post_types, true ) ) {
			continue;
		}
		$default_post_types[] = $post_type;
	}
}

$groovy_menu_preset_class = new GroovyMenuPreset();

return array(
	'logo'       => array(
		'title'  => esc_html__( 'Logo', 'groovy-menu' ),
		'fields' => array(
			'logo_text'          => array(
				'title'       => esc_html__( 'Logo text', 'groovy-menu' ),
				'description' => esc_html__( 'Just plain text logo:)', 'groovy-menu' ),
				'type'        => 'text',
				'default'     => 'Logo',
			),
			'logo_url'           => array(
				'title'       => esc_html__( 'Logo URL', 'groovy-menu' ),
				'description' => esc_html__( 'If this field left blank - then the URL will point to homepage, set in Settings > Reading', 'groovy-menu' ),
				'type'        => 'text',
				'default'     => '',
			),
			'logo_url_open_type' => array(
				'title'   => esc_html__( 'Open logo URL in', 'groovy-menu' ),
				'type'    => 'select',
				'options' => array(
					'same'  => esc_html__( 'Same window', 'groovy-menu' ),
					'blank' => esc_html__( 'New window', 'groovy-menu' ),
				),
				'default' => 'same',
			),
			'logo_default'       => array(
				'type'        => 'media',
				'title'       => esc_html__( 'Default logo', 'groovy-menu' ),
				'description' => esc_html__( "The option sets logo by default which will be applied to each state if any other doesn't exists.", 'groovy-menu' ),
				'reset'       => false,
			),
			'logo_mobile'        => array(
				'type'        => 'media',
				'title'       => esc_html__( 'Mobile logo', 'groovy-menu' ),
				'description' => esc_html__( 'Mobile menu has less space to operate with. So you can adjust your logo smaller or simplified for that reason in mobile state menu.', 'groovy-menu' ),
				'reset'       => false,
			),
		),
	),
	'social'     => array(
		'title'  => esc_html__( 'Social', 'groovy-menu' ),
		'fields' => array(
			'social_set_nofollow' => array(
				'type'        => 'checkbox',
				'title'       => esc_html__( 'Set social links rel as [ nofollow noopener ]', 'groovy-menu' ),
				'description' => esc_html__( 'Rel "nofollow" is used by search engines, to specify that the Google search spider should not follow that link. Rel "noopener" requires that any browsing context created by following the hyperlink must not have an opener browsing context. Most people create external links as target="_blank" and don’t know one thing that the page get in this way will gain partial control over the page that links to it through the js window.opener property. Rel "noopener" prevents this behavior.', 'groovy-menu' ),
				'default'     => false,
			),
			'social_set_blank'    => array(
				'type'        => 'checkbox',
				'title'       => esc_html__( 'Set social links target as [ _blank ]', 'groovy-menu' ),
				'description' => esc_html__( 'Opens the linked social in a new window or tab.', 'groovy-menu' ),
				'default'     => false,
			),


			'social_twitter'        => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Twitter', 'groovy-menu' ),
				'default' => false,
			),
			'social_twitter_link'   => array(
				'type'      => 'text',
				'title'     => esc_html__( 'Twitter link', 'groovy-menu' ),
				'default'   => '',
				'condition' => array( 'social_twitter', '==', true ),
			),
			'social_twitter_text'   => array(
				'type'        => 'text',
				'title'       => esc_html__( 'Twitter link', 'groovy-menu' ) . ' ' . esc_html__( 'text', 'groovy-menu' ),
				'default'     => '',
				'description' => esc_html__( 'Leave blank to not display text', 'groovy-menu' ),
				'condition'   => array( 'social_twitter', '==', true ),
			),
			'social_twitter_icon'   => array(
				'type'      => 'icon',
				'title'     => esc_html__( 'Twitter icon', 'groovy-menu' ),
				'default'   => 'fa fa-twitter',
				'condition' => array( 'social_twitter', '==', true ),
			),
			'social_facebook'       => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Facebook', 'groovy-menu' ),
				'default' => false,
			),
			'social_facebook_link'  => array(
				'type'      => 'text',
				'title'     => esc_html__( 'Facebook link', 'groovy-menu' ),
				'default'   => '',
				'condition' => array( 'social_facebook', '==', true ),
			),
			'social_facebook_text'  => array(
				'type'        => 'text',
				'title'       => esc_html__( 'Facebook link', 'groovy-menu' ) . ' ' . esc_html__( 'text', 'groovy-menu' ),
				'default'     => '',
				'description' => esc_html__( 'Leave blank to not display text', 'groovy-menu' ),
				'condition'   => array( 'social_facebook', '==', true ),
			),
			'social_facebook_icon'  => array(
				'type'      => 'icon',
				'title'     => esc_html__( 'Facebook icon', 'groovy-menu' ),
				'default'   => 'fa fa-facebook',
				'condition' => array( 'social_facebook', '==', true ),
			),
			'social_google'         => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Google+', 'groovy-menu' ),
				'default' => false,
			),
			'social_google_link'    => array(
				'type'      => 'text',
				'title'     => esc_html__( 'Google+ link', 'groovy-menu' ),
				'default'   => '',
				'condition' => array( 'social_google', '==', true ),
			),
			'social_google_text'    => array(
				'type'        => 'text',
				'title'       => esc_html__( 'Google+ link', 'groovy-menu' ) . ' ' . esc_html__( 'text', 'groovy-menu' ),
				'default'     => '',
				'description' => esc_html__( 'Leave blank to not display text', 'groovy-menu' ),
				'condition'   => array( 'social_google', '==', true ),
			),
			'social_google_icon'    => array(
				'type'      => 'icon',
				'title'     => esc_html__( 'Google+ icon', 'groovy-menu' ),
				'default'   => 'fa fa-google',
				'condition' => array( 'social_google', '==', true ),
			),
			'social_vimeo'          => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Vimeo', 'groovy-menu' ),
				'default' => false,
			),
			'social_vimeo_link'     => array(
				'type'      => 'text',
				'title'     => esc_html__( 'Vimeo link', 'groovy-menu' ),
				'default'   => '',
				'condition' => array( 'social_vimeo', '==', true ),
			),
			'social_vimeo_text'     => array(
				'type'        => 'text',
				'title'       => esc_html__( 'Vimeo link', 'groovy-menu' ) . ' ' . esc_html__( 'text', 'groovy-menu' ),
				'default'     => '',
				'description' => esc_html__( 'Leave blank to not display text', 'groovy-menu' ),
				'condition'   => array( 'social_vimeo', '==', true ),
			),
			'social_vimeo_icon'     => array(
				'type'      => 'icon',
				'title'     => esc_html__( 'Vimeo icon', 'groovy-menu' ),
				'default'   => 'fa fa-vimeo',
				'condition' => array( 'social_google', '==', true ),
			),
			'social_dribbble'       => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Dribbble', 'groovy-menu' ),
				'default' => false,
			),
			'social_dribbble_link'  => array(
				'type'      => 'text',
				'title'     => esc_html__( 'Dribbble link', 'groovy-menu' ),
				'default'   => '',
				'condition' => array( 'social_dribbble', '==', true ),
			),
			'social_dribbble_text'  => array(
				'type'        => 'text',
				'title'       => esc_html__( 'Dribbble link', 'groovy-menu' ) . ' ' . esc_html__( 'text', 'groovy-menu' ),
				'default'     => '',
				'description' => esc_html__( 'Leave blank to not display text', 'groovy-menu' ),
				'condition'   => array( 'social_dribbble', '==', true ),
			),
			'social_dribbble_icon'  => array(
				'type'      => 'icon',
				'title'     => esc_html__( 'Dribbble icon', 'groovy-menu' ),
				'default'   => 'fa fa-dribbble',
				'condition' => array( 'social_dribbble', '==', true ),
			),
			'social_pinterest'      => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Pinterest', 'groovy-menu' ),
				'default' => false,
			),
			'social_pinterest_link' => array(
				'type'      => 'text',
				'title'     => esc_html__( 'Pinterest link', 'groovy-menu' ),
				'default'   => '',
				'condition' => array( 'social_pinterest', '==', true ),
			),
			'social_pinterest_text' => array(
				'type'        => 'text',
				'title'       => esc_html__( 'Pinterest link', 'groovy-menu' ) . ' ' . esc_html__( 'text', 'groovy-menu' ),
				'default'     => '',
				'description' => esc_html__( 'Leave blank to not display text', 'groovy-menu' ),
				'condition'   => array( 'social_pinterest', '==', true ),
			),
			'social_pinterest_icon' => array(
				'type'      => 'icon',
				'title'     => esc_html__( 'Pinterest icon', 'groovy-menu' ),
				'default'   => 'fa fa-pinterest',
				'condition' => array( 'social_pinterest', '==', true ),
			),
			'social_youtube'        => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Youtube', 'groovy-menu' ),
				'default' => false,
			),
			'social_youtube_link'   => array(
				'type'      => 'text',
				'title'     => esc_html__( 'Youtube link', 'groovy-menu' ),
				'default'   => '',
				'condition' => array( 'social_youtube', '==', true ),
			),
			'social_youtube_text'   => array(
				'type'        => 'text',
				'title'       => esc_html__( 'Youtube link', 'groovy-menu' ) . ' ' . esc_html__( 'text', 'groovy-menu' ),
				'default'     => '',
				'description' => esc_html__( 'Leave blank to not display text', 'groovy-menu' ),
				'condition'   => array( 'social_youtube', '==', true ),
			),
			'social_youtube_icon'   => array(
				'type'      => 'icon',
				'title'     => esc_html__( 'Youtube icon', 'groovy-menu' ),
				'default'   => 'fa fa-youtube',
				'condition' => array( 'social_youtube', '==', true ),
			),
			'social_linkedin'       => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Linkedin', 'groovy-menu' ),
				'default' => false,
			),
			'social_linkedin_link'  => array(
				'type'      => 'text',
				'title'     => esc_html__( 'Linkedin link', 'groovy-menu' ),
				'default'   => '',
				'condition' => array( 'social_linkedin', '==', true ),
			),
			'social_linkedin_text'  => array(
				'type'        => 'text',
				'title'       => esc_html__( 'Linkedin link', 'groovy-menu' ) . ' ' . esc_html__( 'text', 'groovy-menu' ),
				'default'     => '',
				'description' => esc_html__( 'Leave blank to not display text', 'groovy-menu' ),
				'condition'   => array( 'social_linkedin', '==', true ),
			),
			'social_linkedin_icon'  => array(
				'type'      => 'icon',
				'title'     => esc_html__( 'Linkedin icon', 'groovy-menu' ),
				'default'   => 'fa fa-linkedin',
				'condition' => array( 'social_linkedin', '==', true ),
			),
			'social_instagram'      => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Instagram', 'groovy-menu' ),
				'default' => false,
			),
			'social_instagram_link' => array(
				'type'      => 'text',
				'title'     => esc_html__( 'Instagram link', 'groovy-menu' ),
				'default'   => '',
				'condition' => array( 'social_instagram', '==', true ),
			),
			'social_instagram_text' => array(
				'type'        => 'text',
				'title'       => esc_html__( 'Instagram link', 'groovy-menu' ) . ' ' . esc_html__( 'text', 'groovy-menu' ),
				'default'     => '',
				'description' => esc_html__( 'Leave blank to not display text', 'groovy-menu' ),
				'condition'   => array( 'social_instagram', '==', true ),
			),
			'social_instagram_icon' => array(
				'type'      => 'icon',
				'title'     => esc_html__( 'Instagram icon', 'groovy-menu' ),
				'default'   => 'fa fa-instagram',
				'condition' => array( 'social_instagram', '==', true ),
			),
			'social_flickr'         => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Flickr', 'groovy-menu' ),
				'default' => false,
			),
			'social_flickr_link'    => array(
				'type'      => 'text',
				'title'     => esc_html__( 'Flickr link', 'groovy-menu' ),
				'default'   => '',
				'condition' => array( 'social_flickr', '==', true ),
			),
			'social_flickr_text'    => array(
				'type'        => 'text',
				'title'       => esc_html__( 'Flickr link', 'groovy-menu' ) . ' ' . esc_html__( 'text', 'groovy-menu' ),
				'default'     => '',
				'description' => esc_html__( 'Leave blank to not display text', 'groovy-menu' ),
				'condition'   => array( 'social_flickr', '==', true ),
			),
			'social_flickr_icon'    => array(
				'type'      => 'icon',
				'title'     => esc_html__( 'Flickr icon', 'groovy-menu' ),
				'default'   => 'fa fa-flickr',
				'condition' => array( 'social_flickr', '==', true ),
			),
			'social_vk'             => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'VK', 'groovy-menu' ),
				'default' => false,
			),
			'social_vk_link'        => array(
				'type'      => 'text',
				'title'     => esc_html__( 'VK link', 'groovy-menu' ),
				'default'   => '',
				'condition' => array( 'social_vk', '==', true ),
			),
			'social_vk_text'        => array(
				'type'        => 'text',
				'title'       => esc_html__( 'VK link', 'groovy-menu' ) . ' ' . esc_html__( 'text', 'groovy-menu' ),
				'default'     => '',
				'description' => esc_html__( 'Leave blank to not display text', 'groovy-menu' ),
				'condition'   => array( 'social_vk', '==', true ),
			),
			'social_vk_icon'        => array(
				'type'      => 'icon',
				'title'     => esc_html__( 'VK icon', 'groovy-menu' ),
				'default'   => 'fa fa-vk',
				'condition' => array( 'social_vk', '==', true ),
			),
		),
	),
	'toolbar'    => array(
		'title'  => esc_html__( 'Toolbar', 'groovy-menu' ),
		'fields' => array(
			'toolbar_email_icon'    => array(
				'type'    => 'icon',
				'title'   => esc_html__( 'E-mail icon', 'groovy-menu' ),
				'default' => '',
			),
			'toolbar_email'         => array(
				'type'    => 'text',
				'title'   => esc_html__( 'E-mail address', 'groovy-menu' ),
				'default' => '',
			),
			'toolbar_email_as_link' => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Show e-mail as link', 'groovy-menu' ),
				'default' => false,
			),
			'toolbar_phone_icon'    => array(
				'type'    => 'icon',
				'title'   => esc_html__( 'Phone icon', 'groovy-menu' ),
				'default' => '',
			),
			'toolbar_phone'         => array(
				'type'    => 'text',
				'title'   => esc_html__( 'Phone number', 'groovy-menu' ),
				'default' => '',
			),
			'toolbar_phone_as_link' => array(
				'type'    => 'checkbox',
				'title'   => esc_html__( 'Show phone number as link', 'groovy-menu' ),
				'default' => false,
			),
		),
	),
	'misc_icons' => array(
		'title'  => esc_html__( 'Misc icons', 'groovy-menu' ),
		'fields' => array(
			'search_icon'      => array(
				'type'    => 'icon',
				'title'   => esc_html__( 'Search icon', 'groovy-menu' ),
				'default' => 'gmi gmi-zoom-search',
			),
			'cart_icon'        => array(
				'type'    => 'icon',
				'title'   => esc_html__( 'Cart icon', 'groovy-menu' ),
				'default' => 'gmi gmi-bag',
			),
			'menu_icon'        => array(
				'type'    => 'icon',
				'title'   => esc_html__( 'Side icon', 'groovy-menu' ) . ' (' . esc_html__( 'Hamburger', 'groovy-menu' ) . ')',
				'default' => 'fa fa-bars',
			),
			'menu_button_text' => array(
				'title'       => esc_html__( 'Menu button text', 'groovy-menu' ),
				'description' => esc_html__( 'The string from this field can be translated into other languages using WPML', 'groovy-menu' ),
				'type'        => 'text',
				'default'     => 'Menu',
			),
			'close_icon'       => array(
				'type'    => 'icon',
				'title'   => esc_html__( 'Close icon', 'groovy-menu' ),
				'default' => 'fa fa-times',
			),
		),
	),
	'icons'      => array(
		'title'  => esc_html__( 'Icon packs', 'groovy-menu' ),
		'fields' => array(
			'icons' => array(
				'type'        => 'icons',
				'title'       => esc_html__( 'Icons', 'groovy-menu' ),
				'default'     => '',
				'description' => '',
			),
		),
	),
	'tools'      => array(
		'title'  => esc_html__( 'Tools', 'groovy-menu' ),
		'fields' => array(
			'wrapper_tag'                 => array(
				'title'   => esc_html__( 'Wrapper HTML tag for Groovy Menu', 'groovy-menu' ),
				'type'    => 'select',
				'options' => array(
					'header' => esc_html__( 'HEADER', 'groovy-menu' ),
					'div'    => esc_html__( 'DIV', 'groovy-menu' ),
				),
				'default' => 'header',
			),
			'admin_walker_priority'       => array(
				'type'        => 'checkbox',
				'title'       => esc_html__( 'Toggle visibility of Groovy menu settings at Appearance &gt; Menus', 'groovy-menu' ),
				'default'     => false,
				'description' => esc_html__( 'The theme or another plugin can override the visibility of the Groovy menu settings at Appearance &gt; Menus. To show up Groovy menus settings instead, use this option.', 'groovy-menu' ),
			),
			'frontend_init_alt'           => array(
				'type'        => 'checkbox',
				'title'       => esc_html__( 'Alternative JavaScript initialization', 'groovy-menu' ),
				'default'     => false,
				'description' => esc_html__( 'If enabled can help in cases where third party caching plugins have hard-coded JavaScript output.', 'groovy-menu' ),
			),
			'frontend_init_immediately'   => array(
				'type'        => 'checkbox',
				'title'       => esc_html__( 'Run JavaScript initialization as soon as possible', 'groovy-menu' ),
				'default'     => false,
				'description' => esc_html__( 'If disabled, then initialization occurs on the JavaScript event "DOMContentLoaded". If enabled, then initialization is performed immediately. It can help in cases where third-party caching plugins have combined all JavaScript into one file and load it after the "DOMContentLoaded" event.', 'groovy-menu' ),
			),
			'google_fonts_local'          => array(
				'type'        => 'checkbox',
				'title'       => esc_html__( 'Use local google fonts', 'groovy-menu' ),
				'default'     => false,
				'description' => esc_html__( 'For presets settings. When turning on, the Google fonts will be connected from local upload folder. Turning off option for use the Google CDN service.', 'groovy-menu' ),
			),
			'disable_local_font_awesome'  => array(
				'type'        => 'checkbox',
				'title'       => esc_html__( 'Disable Font Awesome', 'groovy-menu' ),
				'default'     => false,
				'description' => esc_html__( 'Disable loading Font Awesome from Groovy menu at the front-end side of the site', 'groovy-menu' ),
			),
			'disable_local_font_internal' => array(
				'type'        => 'checkbox',
				'title'       => esc_html__( 'Disable internal Font', 'groovy-menu' ),
				'default'     => false,
				'description' => esc_html__( 'Disable loading internal Font from Groovy menu (search, mini-cart icons) at the front-end side of the site', 'groovy-menu' ),
			),
			'allow_use_font_preloader'    => array(
				'type'        => 'checkbox',
				'title'       => esc_html__( 'Allow use preloader for internal fonts', 'groovy-menu' ),
				'default'     => true,
				'description' => esc_html__( 'Add preload link tag', 'groovy-menu' ),
			),
			'uninstall_data'              => array(
				'type'        => 'checkbox',
				'title'       => esc_html__( 'Remove All Data after uninstall', 'groovy-menu' ),
				'default'     => false,
				'description' => esc_html__( 'This tool will remove Groovy menu, Presets and other data when using the "Delete" link on the plugins screen.', 'groovy-menu' ),
				'title_class' => 'gm-delete-warn',
			),
		),
	),

);
