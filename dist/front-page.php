<?php
/**
 * A Template for the WPRDC Theme
 *
 * @package WordPress
 * @subpackage WPRDC
 */
Twitter::getTweets();
get_header(); ?>

<!-- Header Image -->
<div class="interchange"
     data-interchange="
        [<?php echo get_template_directory_uri(); ?>/assets/img/header-large.png,(default)],
        [<?php echo get_template_directory_uri(); ?>/assets/img/header-xlarge.png,(xxlarge)]">
    <div class="text-center">
        <br>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/big-logo.png" alt="Large Logo" />
        <div class="row">
            <div class="large-12 columns">
                <form method="get" action="<?php echo esc_url( ckan_url('dataset' ) ); ?>">
                    <div class="row collapse">
                        <div class="small-10 columns">
                            <input type="text" name="q" placeholder="Search Datasets">
                        </div>
                        <div class="small-2 columns">
                            <input type="submit" class="button secondary postfix" value="Search" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Categories/Groups -->
<div id="data-categories" class="content-container white">
    <div class="row">
        <h3 class="text-center">Browse our most popular datasets</h3>
        <?php if($response = ckan_api_get("action/package_search")) : ?>
            <p class="text-center"><?php echo $response->count; ?> dataset<?php echo ($response->count > 1 ? 's' : ''); ?> and growing</p>
        <?php endif; ?>
        <div class="small-6 columns">
            <h4>Groups/Topics</h4>
            <ul class="large-block-grid-2 small-block-grid-1">
                <?php if($response = ckan_api_get("action/group_list?all_fields=true")) : ?>
                    <?php foreach($response as $group) : ?>
                        <li><a href="<?php echo esc_url( ckan_url('group/'.$group->name) ); ?>"><?php echo $group->display_name; ?></a></li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li><p>Nothing has been created</p></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="small-6 columns">
            <h4>Organizations</h4>
            <ul class="large-block-grid-2 small-block-grid-1">
                <?php if($response = ckan_api_get("action/organization_list?all_fields=true")) : ?>
                    <?php foreach($response as $res) : ?>
                        <li><a href="<?php echo esc_url( ckan_url('organization/'.$res->name) ); ?>"><?php echo $res->display_name; ?></a></li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li><p>Nothing has been created</p></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<div class="content-container smoke">
    <div class="row text-center">
        <div class="large-12 columns">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/newsletter.png" />
            <h3>Get Involved!</h3>
            <p>Share your email to stay on top of the latest Data Center news and activities.</p>
            <form class="newsletter" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>" data-abide="ajax" autocomplete="off">
                <?php wp_nonce_field('newsletter-register'); ?>
                <div class="row collapse">
                    <div class="small-9 columns">
                        <label for="email">
                            <input type="email" value="" name="email" placeholder="Your Email Address" required />
                        </label>
                        <small class="error">A valid email address is required.</small>
                    </div>
                    <div class="small-3 columns">
                        <input type="submit" class="button postfix" value="Sign Up" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Showcase Section -->
<div class="content-container white">
    <div class="row">
        <div class="large-12 columns">
            <h3>Data Center Showcase</h3>
            <p>See what others have created using our data. <a href="<?php echo esc_url(get_category_link(get_cat_ID('showcase'))); ?>">Click here</a> to view all showcase items.</p>
            <?php if ( $posts = wp_get_recent_posts(array('numberposts' => 10, 'category' => get_cat_ID('showcase')), OBJECT) ) : ?>
                <ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-5">
                    <?php foreach($posts as $post) : ?>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <li id="post-<?php echo $post-ID; ?>" class="showcase-item">
                                <a href="<?php echo get_permalink($post->ID); ?>">
                                    <div class="panel">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                        <p class="showcase-title"><?php echo $post->post_title; ?></p>
                                        <p class="showcase-desc"><?php echo wp_trim_words( $post->post_content, 12 ); ?></p>
                                    </div>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <div id="no-posts">
                    <p>Nothing has been posted yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- API Section -->
<div class="content-container light-blue">
    <div class="row valign-middle">
        <div class="medium-9 columns">
            <h3>Build something amazing with our data!</h3>
            <p>Using the Data Center's API, you have direct access to the published datasets to create applications.</p>
        </div>
        <div class="medium-3 columns text-center">
            <a href="http://ckan.readthedocs.org/en/ckan-2.4.0/api/index.html" target="_blank" class="button secondary no-margin">Learn More</a>
        </div>
    </div>
</div>


<!-- Recent Updates -->
<div class="content-container white">
    <h3 class="text-center">Most Viewed Datasets</h3>
    <div class="row">
        <?php if($response = ckan_api_get("action/package_search?sort=views_recent%20desc&rows=3")) : ?>
            <?php foreach($response->results as $res) : ?>
                <?php if(!$res->private) : ?>
                    <div class="medium-4 columns">
                        <h5><a href="<?php echo esc_url( ckan_url('dataset/'.$res->name) ); ?>"><?php echo $res->title; ?></a></h5>
                        <p><?php echo wp_trim_words($res->notes, 35); ?></p>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="medium-12 columns text-center">
                <p>Sorry, we couldn't fetch the most popular datasets at this time.</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="text-center">
        <small>(most viewed over the last two weeks)</small>
    </div>
</div>

<!-- Data Request -->
<div class="content-container smoke">
    <div class="row valign-middle">
        <div class="medium-9 columns">
            <h3>What dataset would you like to see?</h3>
            <p>Do you have an idea for a dataset that you would like to see?</p>
        </div>
        <div class="medium-3 columns text-center">
            <a href="<?php echo esc_url( ckan_url('datarequest') ); ?>" class="button no-margin">Request a Dataset</a>
        </div>
    </div>
</div>

<!-- Recent WP Posts -->
<div class="content-container white">
    <div class="row">
        <div class="large-12 columns">
            <h3>Latest Data Center News</h3>
            <?php if ( $posts = wp_get_recent_posts(array('numberposts' => 5, 'category__not_in' => get_cat_ID('showcase')), OBJECT) ) : ?>
                <?php foreach($posts as $post) : ?>
                    <div id="post-<?php echo $post-ID; ?>">
                        <h4><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h4>
                        <p><?php echo wp_trim_words( $post->post_content ); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div id="no-posts">
                    <p>Nothing has been posted yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Latest Tweet Carousel -->
<div id="latest-tweets">
    <div class="row">
        <div class="large-12 columns">
            <p class="twitter-info">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/twitter-32.png" alt="Small Twitter Badge"/>&nbsp;&nbsp;Our Latest Tweets:
            </p>
            <ul id="tweets-slider" data-orbit data-options="
                slide_number: false;
                timer: true;
                bullets: true;
                navigation_arrows: false;
                variable_height: true;
                timer_speed: 15000;
                pause_on_hover: true;
                resume_on_mouseout: true;">
                <?php if ( $tweets = wincache_ucache_get('tweets') ) : ?>
                    <?php foreach($tweets as $tweet) : ?>
                        <li><p><?php echo $tweet; ?></p></li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li><p>An issue has occurred retrieving the latest tweets.</p></li>
                <?php endif; ?>
            </ul>
            <div class="follow-info right">
                <p>
                    <a href="https://twitter.com/<?php echo get_option('wprdc_theme_setting_twitter','WPRDC'); ?>" target="_blank">
                        Follow <?php echo get_option('wprdc_theme_setting_twitter','WPRDC'); ?>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
</body>
</html>