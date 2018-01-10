<?php
/**
 * HEX Color sanitization callback.
 *
 * - Sanitization: hex_color
 * - Control: text, WP_Customize_Color_Control
 *
 * Note: sanitize_hex_color_no_hash() can also be used here, depending on whether
 * or not the hash prefix should be stored/retrieved with the hex color value.
 *
 * @see sanitize_hex_color() https://developer.wordpress.org/reference/functions/sanitize_hex_color/
 * @link sanitize_hex_color_no_hash() https://developer.wordpress.org/reference/functions/sanitize_hex_color_no_hash/
 *
 * @param string               $hex_color HEX color to sanitize.
 * @param WP_Customize_Setting $setting   Setting instance.
 * @return string The sanitized hex color if not null; otherwise, the setting default.
 */
function sk_sanitize_hex_color( $hex_color, $setting ) {
	// Sanitize $input as a hex value.
	$hex_color = sanitize_hex_color( $hex_color );

	// If $input is a valid hex value, return it; otherwise, return the default.
	return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * Image sanitization callback.
 *
 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
 * send back the filename, otherwise, return the setting default.
 *
 * - Sanitization: image file extension
 * - Control: text, WP_Customize_Image_Control
 *
 * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
 *
 * @param string               $image   Image filename.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string The image filename if the extension is allowed; otherwise, the setting default.
 */
function sk_sanitize_image( $image, $setting ) {

	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif'          => 'image/gif',
		'png'          => 'image/png',
		'bmp'          => 'image/bmp',
		'tif|tiff'     => 'image/tiff',
		'ico'          => 'image/x-icon'
	);

	// Return an array with file extension and mime_type.
	$file = wp_check_filetype( $image, $mimes );

	// If $image has a valid mime_type, return it; otherwise, return the default.
	return ( $file['ext'] ? $image : $setting->default );
}

/**
 * Checkbox sanitization callback.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function sk_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}


/**
 * Customizer: Add Sections
 *
 * This code adds a Section with multiple Settings and Controls to the Customizer
 *
 * @package   code-examples
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 */


/**
 * Theme Options Customizer Implementation.
 *
 * Implement the Theme Customizer for Theme Settings.
 *
 * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 *
 * @param WP_Customize_Manager $wp_customize Object that holds the customizer data.
 */
function sk_register_theme_customizer( $wp_customize ) {

	/*
	 * Failsafe is safe
	 */
	if ( ! isset( $wp_customize ) ) {
		return;
	}


	/**
	 * Add Header Section for General Options.
	 *
	 * @uses $wp_customize->add_section() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
	 * @link $wp_customize->add_section() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section
	 */
	$wp_customize->add_section(
		// $id
		'sk_section_header',
		// $args
		array(
			'title'			=> __( 'Header Background', 'theme-slug' ),
			'description'	=> __( 'Set background color and/or background image for the header', 'theme-slug' ),
			'priority'		=> 9
		)
	);


	/**
	 * Header Background Color setting.
	 *
	 * - Setting: Header Background Color
	 * - Control: WP_Customize_Color_Control
	 * - Sanitization: hex_color
	 *
	 * Uses a color wheel to configure the Header Background Color setting.
	 *
	 * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
	 */
	$wp_customize->add_setting(
		// $id
		'header_background_color_setting',
		// $args
		array(
			'sanitize_callback'	=> 'sk_sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);


	/**
	 * Header Background Image setting.
	 *
	 * - Setting: Header Background Image
	 * - Control: WP_Customize_Image_Control
	 * - Sanitization: image
	 *
	 * Uses the media manager to upload and select an image to be used as the header background image.
	 *
	 * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
	 */
	$wp_customize->add_setting(
		// $id
		'header_background_image_setting',
		// $args
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'sk_sanitize_image',
			'transport'			=> 'postMessage'
		)
	);


	/**
	 * Display Header Backgroud Image Repeat setting.
	 *
	 * - Setting: Display Header Backgroud Image Repeat
	 * - Control: checkbox
	 * - Sanitization: checkbox
	 *
	 * Uses a checkbox to configure the display of the header background image repeat checkbox.
	 *
	 * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
	 */
	$wp_customize->add_setting(
		// $id
		'header_background_image_repeat_setting',
		// $args
		array(
			'default'			=> true,
			'sanitize_callback'	=> 'sk_sanitize_checkbox',
			'transport'			=> 'postMessage'
		)
	);

	/**
	 * Display Header Backgroud Image Size setting.
	 *
	 * - Setting: Display Header Backgroud Image Size
	 * - Control: checkbox
	 * - Sanitization: checkbox
	 *
	 * Uses a checkbox to configure the display of the header background image repeat checkbox.
	 *
	 * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
	 */
	$wp_customize->add_setting(
		// $id
		'header_background_image_size_setting',
		// $args
		array(
			'default'			=> false,
			'sanitize_callback'	=> 'sk_sanitize_checkbox',
			'transport'			=> 'postMessage'
		)
	);

	/**
	 * Core Color control.
	 *
	 * - Control: Color
	 * - Setting: Header Background Color
	 * - Sanitization: hex_color
	 *
	 * Register "WP_Customize_Color_Control" to be used to configure the Header Background Color setting.
	 *
	 * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
	 *
	 * @uses WP_Customize_Color_Control() https://developer.wordpress.org/reference/classes/wp_customize_color_control/
	 * @link WP_Customize_Color_Control() https://codex.wordpress.org/Class_Reference/WP_Customize_Color_Control
	 */
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			// $wp_customize object
			$wp_customize,
			// $id
			'header_background_color',
			// $args
			array(
				'settings'		=> 'header_background_color_setting',
				'section'		=> 'sk_section_header',
				'label'			=> __( 'Header Background Color', 'theme-slug' ),
				'description'	=> __( 'Select the background color for header.', 'theme-slug' ),
			)
		)
	);


	/**
	 * Image Upload control.
	 *
	 * Control: Image Upload
	 * Setting: Header Background Image
	 * Sanitization: image
	 *
	 * Register "WP_Customize_Image_Control" to be used to configure the Header Background Image setting.
	 *
	 * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
	 *
	 * @uses WP_Customize_Image_Control() https://developer.wordpress.org/reference/classes/wp_customize_image_control/
	 * @link WP_Customize_Image_Control() https://codex.wordpress.org/Class_Reference/WP_Customize_Image_Control
	 */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			// $wp_customize object
			$wp_customize,
			// $id
			'header_background_image',
			// $args
			array(
				'settings'		=> 'header_background_image_setting',
				'section'		=> 'sk_section_header',
				'label'			=> __( 'Header Background Image', 'theme-slug' ),
				'description'	=> __( 'Select the background image for header.', 'theme-slug' )
			)
		)
	);

	/**
	 * Basic Checkbox control.
	 *
	 * - Control: Basic: Checkbox
	 * - Setting: Display Header Backgroud Image Repeat
	 * - Sanitization: checkbox
	 *
	 * Register the core "checkbox" control to be used to configure the Display Header Backgroud Image Repeat setting.
	 *
	 * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
	 */
	$wp_customize->add_control(
		// $id
		'header_background_image_repeat',
		// $args
		array(
			'settings'		=> 'header_background_image_repeat_setting',
			'section'		=> 'sk_section_header',
			'type'			=> 'checkbox',
			'label'			=> __( 'Background Repeat', 'theme-slug' ),
			'description'	=> __( 'Should the header background image repeat?', 'theme-slug' ),
		)
	);

	/**
	 * Basic Checkbox control.
	 *
	 * - Control: Basic: Checkbox
	 * - Setting: Display Header Backgroud Image Size
	 * - Sanitization: checkbox
	 *
	 * Register the core "checkbox" control to be used to configure the Display Header Backgroud Image Size setting.
	 *
	 * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
	 */
	$wp_customize->add_control(
		// $id
		'header_background_image_size',
		// $args
		array(
			'settings'		=> 'header_background_image_size_setting',
			'section'		=> 'sk_section_header',
			'type'			=> 'checkbox',
			'label'			=> __( 'Background Stretch', 'theme-slug' ),
			'description'	=> __( 'Should the header background image stretch in full?', 'theme-slug' ),
		)
	);


}

// Settings API options initilization and validation.
add_action( 'customize_register', 'sk_register_theme_customizer' );


/**
 * Registers the Theme Customizer Preview with WordPress.
 *
 * @package    sk
 * @since      0.3.0
 * @version    0.3.0
 */
function sk_customizer_live_preview() {
	wp_enqueue_script(
		'sk-theme-customizer',
		get_stylesheet_directory_uri() . '/js/theme-customizer.js',
		array( 'customize-preview' ),
		'0.1.0',
		true
	);
} // end sk_customizer_live_preview
add_action( 'customize_preview_init', 'sk_customizer_live_preview' );


/**
 * Writes the Header Background related controls' values out to the 'head' element of the document
 * by reading the value(s) from the theme mod value in the options table.
 */
function sk_customizer_css() {
	if ( ! get_theme_mod( 'header_background_color_setting' ) && '' === get_theme_mod( 'header_background_image_setting' ) && false === get_theme_mod( 'header_background_image_repeat_setting' ) && false === get_theme_mod( 'header_background_image_size_setting' ) ) {
		return;
	}
?>
	<style type="text/css">
		.site-header {
			<?php if ( get_theme_mod( 'header_background_color_setting' ) ) { ?>
			background-color: <?php echo get_theme_mod( 'header_background_color_setting' ); ?>;
			<?php } ?>
			<?php if ( get_theme_mod( 'header_background_image_setting' ) != '' ) { ?>
				background-image: url(<?php echo get_theme_mod( 'header_background_image_setting' ); ?>);
			<?php } ?>
			<?php if ( true === get_theme_mod( 'header_background_image_repeat_setting' ) ) { ?>
				background-repeat: repeat;
			<?php } ?>
			<?php if ( true === get_theme_mod( 'header_background_image_size_setting' ) ) { ?>
				background-size: cover;
			<?php } ?>
		}
	</style>
<?php
} // end sk_customizer_css
add_action( 'wp_head', 'sk_customizer_css');
