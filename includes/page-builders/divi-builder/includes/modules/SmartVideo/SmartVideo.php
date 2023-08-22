<?php

class SMARTVIDEO_widget extends ET_Builder_Module {

	public $slug       = 'smartvideo_divi_module';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'Swarmify',
		'author_uri' => 'https://swarmify.idevaffiliate.com/idevaffiliate.php?id=10275&url=48',
	);

	public function init() {
		$this->name = esc_html__( 'SmartVideo', 'smartvideo-for-woocommerce' );
	}

	public function get_advanced_fields_config() {
		return array(
			'background'   => array(
				'css'                  => array(
					'important' => false,
				),
				'use_background_video' => false,
			),
			'button'       => false,
			'fonts'        => false,
			'link_options' => false,
			'text'         => false,
			'text_shadow'  => false,
		);
	}

	public function get_fields() {
		return array(
			'video_src'       => array(
				'label'            => esc_html__( 'Video source', 'smartvideo-for-woocommerce' ),
				'description'      => esc_html__( 'Select `Another source` if your video is hosted somewhere else (like Amazon S3, Google Drive, Dropbox, etc.), paste the URL ending in ".mp4"', 'smartvideo-for-woocommerce' ),
				'type'             => 'select',
				'options'          => array(
					'media_library'  => esc_html__( 'Media Library', 'smartvideo-for-woocommerce' ),
					'youtube'        => esc_html__( 'Youtube', 'smartvideo-for-woocommerce' ),
					'vimeo'          => esc_html__( 'Vimeo', 'smartvideo-for-woocommerce' ),
					'another_source' => esc_html__( 'Another source', 'smartvideo-for-woocommerce' ),
				),
				'default'          => 'media_library',
				'default_on_front' => 'media_library',
				'toggle_slug'      => 'smartvideo',
				'sub_toggle'       => 'source',
			),

			'media_library'   => array(
				'label'              => esc_html__( 'Video File', 'smartvideo-for-woocommerce' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'data_type'          => 'video',
				'upload_button_text' => esc_attr__( 'Upload a video', 'smartvideo-for-woocommerce' ),
				'choose_text'        => esc_attr__( 'Choose a Video File', 'smartvideo-for-woocommerce' ),
				'update_text'        => esc_attr__( 'Set As Video', 'smartvideo-for-woocommerce' ),
				'description'        => esc_html__( 'Upload the .WEBM version of your video here. All uploaded videos should be in both .MP4 .WEBM formats to ensure maximum compatibility in all browsers.', 'smartvideo-for-woocommerce' ),
				'default'            => 'https://swarmify.com/wp-content/uploads/SmartVideoIntroMain.mp4',
				'computed_affects'   => array(
					'__video',
				),
				'show_if'            => array(
					'video_src' => 'media_library',
				),
				'toggle_slug'        => 'smartvideo',
				'sub_toggle'         => 'source',
			),

			'youtube'         => array(
				'label'           => esc_html__( 'Youtube link', 'smartvideo-for-woocommerce' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'show_if'         => array(
					'video_src' => 'youtube',
				),
				'toggle_slug'     => 'smartvideo',
				'sub_toggle'      => 'source',
			),

			'vimeo'           => array(
				'label'           => esc_html__( 'Vimeo link', 'smartvideo-for-woocommerce' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'show_if'         => array(
					'video_src' => 'vimeo',
				),
				'toggle_slug'     => 'smartvideo',
				'sub_toggle'      => 'source',
			),

			'another_source'  => array(
				'label'           => esc_html__( 'Video URL', 'smartvideo-for-woocommerce' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the destination URL for your video.', 'smartvideo-for-woocommerce' ),
				'show_if'         => array(
					'video_src' => 'another_source',
				),
				'toggle_slug'     => 'smartvideo',
				'sub_toggle'      => 'source',
			),

			'poster_src'      => array(
				'label'            => esc_html__( 'Poster source', 'smartvideo-for-woocommerce' ),
				'type'             => 'select',
				'options'          => array(
					'media_library'  => esc_html__( 'Media Library', 'smartvideo-for-woocommerce' ),
					'another_source' => esc_html__( 'Another source', 'smartvideo-for-woocommerce' ),
					'none'           => esc_html__( 'None', 'smartvideo-for-woocommerce' ),
				),
				'default'          => 'none',
				'default_on_front' => 'none',
				'toggle_slug'      => 'smartvideo',
				'sub_toggle'       => 'source',
			),

			'internal_poster' => array(
				'label'              => esc_html__( 'Poster image', 'smartvideo-for-woocommerce' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'data_type'          => 'image',
				'upload_button_text' => esc_attr__( 'Upload an image', 'smartvideo-for-woocommerce' ),
				'choose_text'        => esc_attr__( 'Choose an image file', 'smartvideo-for-woocommerce' ),
				'update_text'        => esc_attr__( 'Set as poster image', 'smartvideo-for-woocommerce' ),
				'show_if'            => array(
					'poster_src' => 'media_library',
				),
				'toggle_slug'        => 'smartvideo',
				'sub_toggle'         => 'source',
			),

			'external_poster' => array(
				'label'           => esc_html__( 'Poster link', 'smartvideo-for-woocommerce' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'show_if'         => array(
					'poster_src' => 'another_source',
				),
				'toggle_slug'     => 'smartvideo',
				'sub_toggle'      => 'source',
			),

			// basic options
			'video_height'    => array(
				'label'           => esc_html__( 'Height', 'smartvideo-for-woocommerce' ),
				'type'            => 'range',
				'default'         => '720',
				'unitless'        => true,
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '900',
					'step' => '1',
				),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'smartvideo',
				'sub_toggle'      => 'basic',
			),

			'video_width'     => array(
				'label'           => esc_html__( 'Width', 'smartvideo-for-woocommerce' ),
				'type'            => 'range',
				'default'         => '1280',
				'unitless'        => true,
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '1920',
					'step' => '1',
				),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'smartvideo',
				'sub_toggle'      => 'basic',
			),
			'autoplay'        => array(
				'label'            => esc_html__( 'Autoplay', 'smartvideo-for-woocommerce' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'off' => esc_html__( 'No', 'smartvideo-for-woocommerce' ),
					'on'  => esc_html__( 'Yes', 'smartvideo-for-woocommerce' ),
				),
				'default_on_front' => 'off',
				'depends_show_if'  => 'on',
				'toggle_slug'      => 'smartvideo',
				'sub_toggle'       => 'basic',
			),
			'muted'           => array(
				'label'            => esc_html__( 'Muted', 'smartvideo-for-woocommerce' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'off' => esc_html__( 'No', 'smartvideo-for-woocommerce' ),
					'on'  => esc_html__( 'Yes', 'smartvideo-for-woocommerce' ),
				),
				'default_on_front' => 'off',
				'depends_show_if'  => 'on',
				'toggle_slug'      => 'smartvideo',
				'sub_toggle'       => 'basic',
			),
			'loop'            => array(
				'label'            => esc_html__( 'Loop', 'smartvideo-for-woocommerce' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'off' => esc_html__( 'No', 'smartvideo-for-woocommerce' ),
					'on'  => esc_html__( 'Yes', 'smartvideo-for-woocommerce' ),
				),
				'default_on_front' => 'off',
				'depends_show_if'  => 'on',
				'toggle_slug'      => 'smartvideo',
				'sub_toggle'       => 'basic',
			),

			// advanced options
			'controls'        => array(
				'label'            => esc_html__( 'Controls', 'smartvideo-for-woocommerce' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'off' => esc_html__( 'No', 'smartvideo-for-woocommerce' ),
					'on'  => esc_html__( 'Yes', 'smartvideo-for-woocommerce' ),
				),
				'default_on_front' => 'on',
				'depends_show_if'  => 'on',
				'toggle_slug'      => 'smartvideo',
				'sub_toggle'       => 'advanced',
			),
			'playsinline'     => array(
				'label'            => esc_html__( 'Play inline', 'smartvideo-for-woocommerce' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'off' => esc_html__( 'No', 'smartvideo-for-woocommerce' ),
					'on'  => esc_html__( 'Yes', 'smartvideo-for-woocommerce' ),
				),
				'default_on_front' => 'off',
				'depends_show_if'  => 'on',
				'toggle_slug'      => 'smartvideo',
				'sub_toggle'       => 'advanced',
			),
			'responsive'      => array(
				'label'            => esc_html__( 'Responsive', 'smartvideo-for-woocommerce' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'off' => esc_html__( 'No', 'smartvideo-for-woocommerce' ),
					'on'  => esc_html__( 'Yes', 'smartvideo-for-woocommerce' ),
				),
				'default_on_front' => 'on',
				'depends_show_if'  => 'on',
				'toggle_slug'      => 'smartvideo',
				'sub_toggle'       => 'advanced',
			),
		);
	}

	public function get_settings_modal_toggles() {
		return array(
			'advanced' => array(
				'toggles' => array(
					'smartvideo' => array(
						'priority'          => 24,
						'sub_toggles'       => array(
							'source'   => array(
								'name' => __( 'Source', 'smartvideo-for-woocommerce' ),
							),
							'basic'    => array(
								'name' => __( 'Basic', 'smartvideo-for-woocommerce' ),
							),
							'advanced' => array(
								'name' => __( 'Advanced', 'smartvideo-for-woocommerce' ),
							),
						),
						'tabbed_subtoggles' => true,
						'title'             => __( 'SmartVideo settings', 'smartvideo-for-woocommerce' ),
					),
				),
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug = null ) {
		// extract youtube id for use
		if ( 'media_library' === $this->props['video_src'] && $this->props['media_library'] ) {
			$swarmify_url = $this->props['media_library'];
		} elseif ( 'youtube' === $this->props['video_src'] && $this->props['youtube'] ) {
			preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->props['youtube'], $youtubeId );
			$swarmify_url = sprintf( 'https://www.youtube.com/embed/%s', $youtubeId[1] );
		} elseif ( 'vimeo' === $this->props['video_src'] && $this->props['vimeo'] ) {
			$swarmify_url = $this->props['vimeo'];
		} elseif ( 'another_source' === $this->props['video_src'] && $this->props['another_source'] ) {
			$swarmify_url = $this->props['another_source'];
		}

		if ( empty( $swarmify_url ) ) {
			return;
		}

		$poster_url  = $this->props['external_poster'] ? $this->props['external_poster'] : $this->props['internal_poster'];
		$poster      = 'none' !== $this->props['poster_src'] ? sprintf( 'poster=%s', $poster_url ) : '';
		$autoplay    = 'on' === $this->props['autoplay'] ? 'autoplay' : '';
		$muted       = 'on' === $this->props['muted'] ? 'muted' : '';
		$loop        = 'on' === $this->props['loop'] ? 'loop' : '';
		$controls    = 'on' === $this->props['controls'] ? 'controls' : '';
		$playsinline = 'on' === $this->props['playsinline'] ? 'playsinline' : '';
		$responsive  = ( 'on' === $this->props['responsive'] ) ? 'class="swarm-fluid"' : '';

		return sprintf( '<smartvideo src="%s" width="%s" height="%s" %s %s %s %s %s %s %s></smartvideo>', $swarmify_url, $this->props['video_width'], $this->props['video_height'], $poster, $responsive, $autoplay, $muted, $loop, $controls, $playsinline );
	}
}

new SMARTVIDEO_widget();
