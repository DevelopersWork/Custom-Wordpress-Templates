<?php if(!function_exists('newsbit_frontpage_editor_post_section')):

/**
*
* @since Newsbit
*
*
*/
  function newsbit_frontpage_editor_post_section()
    {

          if(is_front_page() || is_home())
        {
        $newsbit_post_two = array(get_theme_mod('newsbit_post_two'));
        

        $slider_query = new WP_Query( array( 'post__in' => $newsbit_post_two, 'ignore_sticky_posts' => 1));
                if( $slider_query->have_posts() ){                
                    while( $slider_query->have_posts() ){
                    $slider_query->the_post();

        global $post;
        $foodup_url = newsup_get_freatured_image_url($post->ID);
        ?>
        <div class="col-md-3 col-sm-6">
                        <div class="mg-blog-post lg back-img" style="background-image: url('<?php echo esc_url($foodup_url); ?>');">
                                        <a class="link-div" href="<?php echo the_permalink(); ?>"> </a>
                        <article class="bottom">
                            <span class="post-form"><i class="fa fa-camera"></i></span>
                                <div class="mg-blog-category"> <?php newsup_post_categories(); ?> </div>
                                <h4 class="title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <?php newsup_post_meta(); ?>
                </article>
                        </div>     
                    </div>

        
       <?php } } 
        else
        {
            $slider_query = new WP_Query( array( 'ignore_sticky_posts' => 1, "posts_per_page" => 1));
            if( $slider_query->have_posts() ){                
                    while( $slider_query->have_posts() ){
                    $slider_query->the_post();

        global $post;
        $newsbit_url = newsup_get_freatured_image_url($post->ID);
        ?>
        <div class="col-md-3 col-sm-6">
                        <div class="mg-blog-post lg back-img" style="background-image: url('<?php echo esc_url($newsbit_url); ?>');">
                                        <a class="link-div" href="<?php echo the_permalink(); ?>"> </a>
                        <article class="bottom">
                            <span class="post-form"><i class="fa fa-camera"></i></span>
                                <div class="mg-blog-category"> <?php newsup_post_categories(); ?> </div>
                                <h4 class="title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <?php newsup_post_meta(); ?>
                </article>
                        </div>     
                    </div>

     <?php   } }
        }
    }
    }

endif;

add_action('newsbit_action_front_page_editor_section', 'newsbit_frontpage_editor_post_section', 30);

//Front Page Banner
if (!function_exists('newsbit_front_page_banner_section')) :
    /**
     *
     * @since Newsbit
     *
     */
    function newsbit_front_page_banner_section()
    {
        if (is_front_page() || is_home()) {
        $newsup_enable_main_slider = newsup_get_option('show_main_news_section');
        $select_vertical_slider_news_category = newsup_get_option('select_vertical_slider_news_category');
        $vertical_slider_number_of_slides = newsup_get_option('vertical_slider_number_of_slides');
        $all_posts_vertical = newsup_get_posts($vertical_slider_number_of_slides, $select_vertical_slider_news_category);
        if ($newsup_enable_main_slider):  

            $main_banner_section_background_image = newsup_get_option('main_banner_section_background_image');
            $main_banner_section_background_image_url = wp_get_attachment_image_src($main_banner_section_background_image, 'full');
        if(!empty($main_banner_section_background_image)){ ?>
             <section class="mg-fea-area over" style="background-image:url('<?php echo esc_url($main_banner_section_background_image_url[0]); ?>');">
        <?php }else{ ?>
            <section class="mg-fea-area">
        <?php  } ?>
            <div class="overlay">
                <div class="container-fluid">
                    <div class="row">
                        
                        <div class="col-md-6 col-sm-6">
                            <div id="homemain"class="homemain owl-carousel mr-bot60 pd-r-10"> 
                                <?php newsup_get_block('list', 'banner'); ?>
                            </div>
                        </div> 
                        <?php do_action('newsbit_action_banner_tabbed_posts');?>
                        <?php do_action('newsbit_action_front_page_editor_section');?>
                    </div>
                </div>
            </div>
        </section>
        <!--==/ Home Slider ==-->
        <?php endif; ?>
        <!-- end slider-section -->
        <?php }
    }
endif;
add_action('newsbit_action_front_page_main_section_1', 'newsbit_front_page_banner_section', 40);



//Banner Tabed Section
if (!function_exists('newsbit_banner_tabbed_posts')):
    /**
     *
     * @since Newsbit 1.0.0
     *
     */
    function newsbit_banner_tabbed_posts()
    {
        
            if(is_front_page() || is_home())
        {
        $newsbit_post_one = array(get_theme_mod('newsbit_post_one'));
        

        $slider_query = new WP_Query( array( 'post__in' => $newsbit_post_one, 'ignore_sticky_posts' => 1));
                if( $slider_query->have_posts() ){                
                    while( $slider_query->have_posts() ){
                    $slider_query->the_post();

        global $post;
        $foodup_url = newsup_get_freatured_image_url($post->ID);
        ?>
        <div class="col-md-3 col-sm-6">
                        <div class="mg-blog-post lg back-img" style="background-image: url('<?php echo esc_url($foodup_url); ?>');">
                                        <a class="link-div" href="<?php echo the_permalink(); ?>"> </a>
                        <article class="bottom">
                            <span class="post-form"><i class="fa fa-camera"></i></span>
                                <div class="mg-blog-category"> <?php newsup_post_categories(); ?> </div>
                                <h4 class="title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <?php newsup_post_meta(); ?>
                </article>
                        </div>     
                    </div>

        
       <?php } } 
        else
        {
            $slider_query = new WP_Query( array( 'ignore_sticky_posts' => 1, "posts_per_page" => 1));
            if( $slider_query->have_posts() ){                
                    while( $slider_query->have_posts() ){
                    $slider_query->the_post();

        global $post;
        $newsbit_url = newsup_get_freatured_image_url($post->ID);
        ?>
        <div class="col-md-3 col-sm-6">
                        <div class="mg-blog-post lg back-img" style="background-image: url('<?php echo esc_url($newsbit_url); ?>');">
                                        <a class="link-div" href="<?php echo the_permalink(); ?>"> </a>
                        <article class="bottom">
                            <span class="post-form"><i class="fa fa-camera"></i></span>
                                <div class="mg-blog-category"> <?php newsup_post_categories(); ?> </div>
                                <h4 class="title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <?php newsup_post_meta(); ?>
                </article>
                        </div>     
                    </div>

     <?php   } }
        }
    } }

endif;

add_action('newsbit_action_banner_tabbed_posts', 'newsbit_banner_tabbed_posts', 10);