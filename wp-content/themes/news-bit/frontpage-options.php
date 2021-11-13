<?php

/**
 * Option Panel
 *
 * @package Newsbit
 */


function newsbit_customize_register($wp_customize) {

$newsup_default = newsbit_get_default_theme_options();


/* Option list of all post */  
    $options_posts = array();
    $options_posts_obj = get_posts('posts_per_page=-1');
    $options_posts[''] = __( 'Choose Post','news-bit' );
    foreach ( $options_posts_obj as $posts ) {
        $options_posts[$posts->ID] = $posts->post_title;
    }

//section title
$wp_customize->add_setting('one_post_section',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    new newsup_Section_Title(
        $wp_customize,
        'one_post_section',
        array(
            'label'             => esc_html__( 'Latest Post', 'news-bit' ),
            'section'           => 'frontpage_main_banner_section_settings',
            'priority'          => 100,
            'active_callback' => 'newsup_main_banner_section_status'
        )
    )
);



 //Select Post One
  $wp_customize->add_setting('newsbit_post_one',array(
                'capability'=>'edit_theme_options',
                'sanitize_callback' => 'newsup_sanitize_select',
            ));
            
   $wp_customize->add_control('newsbit_post_one',array(
                'label' => __('Select Post','news-bit'),
                'section'=>'frontpage_main_banner_section_settings',
                'type'=>'select',
                'priority'          => 110,
                'choices'=>$options_posts,
            ));



//section title
$wp_customize->add_setting('two_post_section',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    new newsup_Section_Title(
        $wp_customize,
        'two_post_section',
        array(
            'label'             => esc_html__( 'Latest Post', 'news-bit' ),
            'section'           => 'frontpage_main_banner_section_settings',
            'priority'          => 120,
            'active_callback' => 'newsup_main_banner_section_status'
        )
    )
);



 //Select Post two
  $wp_customize->add_setting('newsbit_post_two',array(
                'capability'=>'edit_theme_options',
                'sanitize_callback' => 'newsup_sanitize_select',
            ));
            
   $wp_customize->add_control('newsbit_post_two',array(
                'label' => __('Select Post','news-bit'),
                'section'=>'frontpage_main_banner_section_settings',
                'type'=>'select',
                'priority'          => 130,
                'choices'=>$options_posts,
            ));


}
add_action('customize_register', 'newsbit_customize_register');
