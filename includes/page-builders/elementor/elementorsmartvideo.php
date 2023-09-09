<?php

namespace Elementor;

class elementorsmartvideo extends \Elementor\Widget_Base {

	public function get_name() {
		return 'smartvideo';
	}

	public function get_title() {
		return esc_html__( 'SmartVideo', 'smartvideo-for-woocommerce' );
	}

	public function get_icon() {
		return 'smartvideo-icon';
	}

	public function get_categories() {
		return array( 'basic' );
	}

	public function get_keywords() {
		return array( 'video', 'player', 'embed', 'youtube', 'vimeo', 'smartvideo' );
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_video',
			array(
				'label' => __( 'Video', 'smartvideo-for-woocommerce' ),
			)
		);

		$this->add_control(
			'video_type',
			array(
				'label'   => __( 'Source', 'smartvideo-for-woocommerce' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'media_library',
				'options' => array(
					'media_library'  => __( 'Media library', 'smartvideo-for-woocommerce' ),
					'youtube'        => __( 'YouTube', 'smartvideo-for-woocommerce' ),
					'vimeo'          => __( 'Vimeo', 'smartvideo-for-woocommerce' ),
					'another_source' => __( 'Another source', 'smartvideo-for-woocommerce' ),
				),
			)
		);

		$this->add_control(
			'media_library',
			array(
				'label'      => __( 'Choose File', 'smartvideo-for-woocommerce' ),
				'type'       => Controls_Manager::MEDIA,
				'media_type' => 'video',
				'condition'  => array(
					'video_type' => 'media_library',
				),
				'dynamic'    => array(
					'active' => true,
				),
				'default'    => array(
					'id'  => '',
					'url' => 'https://swarmify.com/wp-content/uploads/SmartVideoIntroMain.mp4',
				),
			)
		);

		$this->add_control(
			'youtube',
			array(
				'label'       => __( 'Link', 'smartvideo-for-woocommerce' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'YouTube URL', 'smartvideo-for-woocommerce' ) . ' (YouTube)',
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true,
				'condition'   => array(
					'video_type' => 'youtube',
				),
			)
		);

		$this->add_control(
			'vimeo',
			array(
				'label'       => __( 'Link', 'smartvideo-for-woocommerce' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Vimeo URL', 'smartvideo-for-woocommerce' ) . ' (Vimeo)',
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => 'https://vimeo.com/235215203',
				'label_block' => true,
				'condition'   => array(
					'video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'another_source',
			array(
				'label'         => __( 'URL', 'smartvideo-for-woocommerce' ),
				'type'          => Controls_Manager::URL,
				'autocomplete'  => false,
				'show_external' => false,
				'label_block'   => true,
				'show_label'    => false,
				'media_type'    => 'video',
				'placeholder'   => __( 'Enter your URL', 'smartvideo-for-woocommerce' ),
				'dynamic'       => array(
					'active' => true,
				),
				'condition'     => array(
					'video_type' => 'another_source',
				),
			)
		);

		// Poster options
		$this->add_control(
			'poster_options',
			array(
				'label'     => __( 'Poster', 'smartvideo-for-woocommerce' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'poster',
			array(
				'label'   => __( 'Source', 'smartvideo-for-woocommerce' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => array(
					'media_library'  => __( 'Media library', 'smartvideo-for-woocommerce' ),
					'another_source' => __( 'Another source', 'smartvideo-for-woocommerce' ),
					'none'           => __( 'None', 'smartvideo-for-woocommerce' ),
				),
			)
		);

		$this->add_control(
			'poster_media_library',
			array(
				'label'      => __( 'Choose Poster Image', 'smartvideo-for-woocommerce' ),
				'type'       => Controls_Manager::MEDIA,
				'media_type' => 'image',
				'condition'  => array(
					'poster' => 'media_library',
				),
				'dynamic'    => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'poster_another_src',
			array(
				'label'         => __( 'Poster URL', 'smartvideo-for-woocommerce' ),
				'type'          => Controls_Manager::URL,
				'autocomplete'  => false,
				'show_external' => false,
				'label_block'   => true,
				'show_label'    => false,
				'media_type'    => 'image',
				'placeholder'   => __( 'Enter Poster URL', 'smartvideo-for-woocommerce' ),
				'condition'     => array(
					'poster' => 'another_source',
				),
				'dynamic'       => array(
					'active' => true,
				),
			)
		);

		// height & width
		$this->add_control(
			'video_height',
			array(
				'label'   => __( 'Height', 'smartvideo-for-woocommerce' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '720',
			)
		);

		$this->add_control(
			'video_width',
			array(
				'label'   => __( 'Width', 'smartvideo-for-woocommerce' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '1280',
			)
		);

		$this->end_controls_section();

		// basic settings
		$this->start_controls_section(
			'Basic_setting',
			array(
				'label' => __( 'Basic options', 'smartvideo-for-woocommerce' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => __( 'Autoplay:', 'smartvideo-for-woocommerce' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'smartvideo-for-woocommerce' ),
				'label_off'    => __( 'No', 'smartvideo-for-woocommerce' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'muted',
			array(
				'label'        => __( 'Muted:', 'smartvideo-for-woocommerce' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'smartvideo-for-woocommerce' ),
				'label_off'    => __( 'No', 'smartvideo-for-woocommerce' ),
				'return_value' => 'yes',
				'default'      => 'no',

			)
		);
		$this->add_control(
			'loop',
			array(
				'label'        => __( 'Loop:', 'smartvideo-for-woocommerce' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'smartvideo-for-woocommerce' ),
				'label_off'    => __( 'No', 'smartvideo-for-woocommerce' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->end_controls_section();

		// Advance options
		$this->start_controls_section(
			'advance_setting',
			array(
				'label' => __( 'Advanced options', 'smartvideo-for-woocommerce' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'controls',
			array(
				'label'        => __( 'Controls:', 'smartvideo-for-woocommerce' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'smartvideo-for-woocommerce' ),
				'label_off'    => __( 'No', 'smartvideo-for-woocommerce' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'playsinline',
			array(
				'label'        => __( 'Play video inline:', 'smartvideo-for-woocommerce' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'smartvideo-for-woocommerce' ),
				'label_off'    => __( 'No', 'smartvideo-for-woocommerce' ),
				'return_value' => 'yes',
				'default'      => 'no',

			)
		);
		$this->add_control(
			'responsive',
			array(
				'label'        => __( 'Responsive:', 'smartvideo-for-woocommerce' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'smartvideo-for-woocommerce' ),
				'label_off'    => __( 'No', 'smartvideo-for-woocommerce' ),
				'return_value' => 'yes',
				'default'      => 'yes',

			)
		);
		$this->end_controls_section();
	}
	/*
	 * End style section
	 * */
	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( $settings['media_library'] ) {
			$swarmify_url = $settings['media_library']['url'];
		} elseif ( $settings['youtube'] ) {
			$swarmify_url = Embed::get_embed_url( $settings['youtube'] );
		} elseif ( $settings['vimeo'] ) {
			$swarmify_url = Embed::get_embed_url( $settings['vimeo'] );
		} elseif ( $settings['another_source'] ) {
			$swarmify_url = $settings['another_source']['url'];
		}

		if ( empty( $swarmify_url ) ) {
			return;
		}

		$height     = $settings['video_height'];
		$width      = $settings['video_width'];
		$responsive = 'yes' === $settings['responsive'] ? 'class="swarm-fluid"' : '';
		$poster_url = $settings['poster_media_library'] ? $settings['poster_media_library']['url'] : ( $settings['poster_another_src'] ? $settings['poster_another_src']['url'] : null );
		$poster     = ! empty( $poster_url ) ? sprintf( 'poster="%s"', $poster_url ) : '';

		$autoplay    = 'yes' === $settings['autoplay'] ? 'autoplay' : '';
		$muted       = 'yes' === $settings['muted'] ? 'muted' : '';
		$loop        = 'yes' === $settings['loop'] ? 'loop' : '';
		$controls    = 'yes' === $settings['controls'] ? 'controls' : '';
		$playsinline = 'yes' === $settings['playsinline'] ? 'playsinline' : '';

		printf( 
			'<smartvideo src="%s" width="%s" height="%s" %s %s %s %s %s %s %s></smartvideo>', 
			esc_attr( $swarmify_url ), 
			esc_attr( $width ), 
			esc_attr( $height ), 
			esc_attr( $poster ), 
			esc_attr( $responsive ), 
			esc_attr( $autoplay ), 
			esc_attr( $muted ), 
			esc_attr( $loop ), 
			esc_attr( $controls ), 
			esc_attr( $playsinline )
		);
	}

}
