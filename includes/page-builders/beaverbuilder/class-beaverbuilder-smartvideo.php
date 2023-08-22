<?php

class SmartVideo extends FLBuilderModule {
	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'SmartVideo', 'smartvideo-for-woocommerce' ),
				'description'     => __( 'Effortless, unlimited video player', 'smartvideo-for-woocommerce' ),
				// 'group'           => __( 'SmartVideo', 'smartvideo-for-woocommerce' ),
				'category'        => __( 'Basic', 'smartvideo-for-woocommerce' ),
				// 'icon'            => 'format-video.svg',
				'editor_export'   => true, // Defaults to true and can be omitted.
				'enabled'         => true, // Defaults to true and can be omitted.
				'partial_refresh' => false, // Defaults to false and can be omitted.
			)
		);
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module(
	'SmartVideo',
	array(
		'general'       => array(
			'title'    => __( 'General', 'smartvideo-for-woocommerce' ),
			'sections' => array(
				'general' => array(
					'title'  => '',
					'fields' => array(
						'video_type'      => array(
							'type'    => 'select',
							'label'   => __( 'Video source', 'smartvideo-for-woocommerce' ),
							'default' => 'media_library',
							'options' => array(
								'media_library' => __( 'Media library', 'smartvideo-for-woocommerce' ),
								'youtube'       => __( 'YouTube', 'smartvideo-for-woocommerce' ),
								'vimeo'         => __( 'Vimeo', 'smartvideo-for-woocommerce' ),
								'other_source'  => __( 'Other source', 'smartvideo-for-woocommerce' ),
							),
							'toggle'  => array(
								'media_library' => array(
									'fields' => array( 'video' ),
								),
								'youtube'       => array(
									'fields' => array( 'youtube' ),
								),
								'vimeo'         => array(
									'fields' => array( 'vimeo' ),
								),
								'other_source'  => array(
									'fields' => array( 'other_source' ),
								),
							),
						),
						'video'           => array(
							'type'        => 'video',
							'label'       => __( 'Video (MP4)', 'smartvideo-for-woocommerce' ),
							'help'        => __( 'A video in the MP4 format. Most modern browsers support this format.', 'smartvideo-for-woocommerce' ),
							'show_remove' => true,
						),
						'youtube'         => array(
							'type'          => 'link',
							'label'         => 'YouTube link',
							'show_target'   => false,
							'show_nofollow' => false,
						),
						'vimeo'           => array(
							'type'          => 'link',
							'label'         => 'Vimeo link',
							'show_target'   => false,
							'show_nofollow' => false,
						),
						'other_source'    => array(
							'type'          => 'link',
							'label'         => 'Video link',
							'show_target'   => false,
							'show_nofollow' => false,
						),
						'poster'          => array(
							'type'    => 'select',
							'label'   => __( 'Add a poster', 'smartvideo-for-woocommerce' ),
							'options' => array(
								'media_library' => __( 'Media library', 'smartvideo-for-woocommerce' ),
								'other_source'  => __( 'Other source', 'smartvideo-for-woocommerce' ),
								'none'          => __( 'None', 'smartvideo-for-woocommerce' ),
							),
							'default' => 'none',
							'toggle'  => array(
								'media_library' => array(
									'fields' => array( 'poster_internal' ),
								),
								'other_source'  => array(
									'fields' => array( 'poster_external' ),
								),
							),
						),
						'poster_internal' => array(
							'type'        => 'photo',
							'show_remove' => true,
							'label'       => _x( 'Poster', 'Video preview/fallback image.', 'smartvideo-for-woocommerce' ),
						),
						'poster_external' => array(
							'type'          => 'link',
							'label'         => 'Poster link',
							'show_target'   => false,
							'show_nofollow' => false,
						),
					),
				),

			),
		),
		'basic_options' => array(
			'title'    => 'Basic options',
			'sections' => array(
				'basic_options' => array(
					'fields' => array(
						'height'     => array(
							'type'    => 'text',
							'label'   => __( 'Height', 'smartvideo-for-woocommerce' ),
							'default' => '720',
							'class'   => 'height',
						),
						'width'      => array(
							'type'    => 'text',
							'label'   => __( 'Width', 'smartvideo-for-woocommerce' ),
							'default' => '1280',
							'class'   => 'width',
						),
						'autoplay'   => array(
							'type'    => 'select',
							'label'   => __( 'Autoplay', 'smartvideo-for-woocommerce' ),
							'default' => '0',
							'options' => array(
								'0' => __( 'No', 'smartvideo-for-woocommerce' ),
								'1' => __( 'Yes', 'smartvideo-for-woocommerce' ),
							),
							'preview' => array(
								'type' => 'none',
							),
						),
						'muted'      => array(
							'type'    => 'select',
							'label'   => __( 'Muted', 'smartvideo-for-woocommerce' ),
							'default' => '0',
							'options' => array(
								'0' => __( 'No', 'smartvideo-for-woocommerce' ),
								'1' => __( 'Yes', 'smartvideo-for-woocommerce' ),
							),
							'preview' => array(
								'type' => 'none',
							),
						),
						'loop'       => array(
							'type'    => 'select',
							'label'   => __( 'Loop', 'smartvideo-for-woocommerce' ),
							'default' => '0',
							'options' => array(
								'0' => __( 'No', 'smartvideo-for-woocommerce' ),
								'1' => __( 'Yes', 'smartvideo-for-woocommerce' ),
							),
							'preview' => array(
								'type' => 'none',
							),
						),
						'controls'   => array(
							'type'    => 'select',
							'label'   => __( 'Controls', 'smartvideo-for-woocommerce' ),
							'default' => '1',
							'options' => array(
								'0' => __( 'No', 'smartvideo-for-woocommerce' ),
								'1' => __( 'Yes', 'smartvideo-for-woocommerce' ),
							),
							'preview' => array(
								'type' => 'none',
							),
						),
						'inline'     => array(
							'type'    => 'select',
							'label'   => __( 'Play video inline', 'smartvideo-for-woocommerce' ),
							'default' => '0',
							'options' => array(
								'0' => __( 'No', 'smartvideo-for-woocommerce' ),
								'1' => __( 'Yes', 'smartvideo-for-woocommerce' ),
							),
							'preview' => array(
								'type' => 'none',
							),
						),
						'responsive' => array(
							'type'    => 'select',
							'label'   => __( 'Responsive', 'smartvideo-for-woocommerce' ),
							'default' => '1',
							'options' => array(
								'0' => __( 'No', 'smartvideo-for-woocommerce' ),
								'1' => __( 'Yes', 'smartvideo-for-woocommerce' ),
							),
							'preview' => array(
								'type' => 'none',
							),
						),
					),
				),
			),
		),
	)
);
