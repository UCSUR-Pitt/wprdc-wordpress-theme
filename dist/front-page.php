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
            <h4>Topics/Groups</h4>
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


<!-- Recent Updates -->
<div class="content-container smoke">
    <h3 class="text-center">Recently Updated Datasets</h3>
    <div class="row">
        <?php if($response = ckan_api_get("action/current_package_list_with_resources?limit=3")) : ?>
            <?php foreach($response as $res) : ?>
                <?php if(!$res->private) : ?>
                    <div class="medium-4 columns">
                        <h5><a href="<?php echo esc_url( ckan_url('dataset/'.$res->name) ); ?>"><?php echo $res->title; ?></a></h5>
                        <p><?php echo wp_trim_words($res->notes, 50); ?></p>
                        <?php foreach($res->resources as $resource) : ?>
                            <?php if($resource->format) : ?>
                                <a href="<?php echo esc_url( ckan_url('dataset/'.$res->name) ); ?>"><span class="label"><?php echo $resource->format; ?></span></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="medium-4 columns">
                <p>No datasets are currently available.</p>
            </div>
        <?php endif; ?>
    </div>
</div>


<!-- Recent WP Posts -->
<div class="content-container white">
    <div class="row">
        <div class="large-12 columns">
            <h3>Latest WPRDC News</h3>
            <?php if ( $posts = wp_get_recent_posts(array('numberposts' => 5), OBJECT) ) : ?>
                <?php foreach($posts as $post) : ?>
                    <div id="post-<?php echo $post-ID; ?>">
                        <h4><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h4>
                        <p><?php echo $post->post_content; ?></p>
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

<!-- API Section -->
<div class="content-container smoke">
    <div class="row text-center">
        <h3>Build something amazing with our data!</h3>
        <p>Using CKAN and the WPRDC's API, you have direct access to the datasets published to create applications and extend data.</p>
        <a href="http://docs.ckan.org/en/ckan-2.3/api/index.html" class="button">Learn More</a>
    </div>
</div>


<!-- Partners Section -->
<div class="content-container white">
    <div class="row">
        <div class="large-12 columns">
            <h3 class="text-center">Project Partners</h3>
            <ul class="large-block-grid-3 medium-block-grid-2 small-block-grid-1">
                <li><a target="_blank" href="http://foundationcenter.org/grantmaker/rkmellon/">Richard King Mellon Foundation</a></li>
                <li><a target="_blank" href="http://www.pitt.edu/">University of Pittsburgh</a></li>
                <li><a target="_blank" href="http://www.alleghenycounty.us/">Allegheny County</a></li>
                <li><a target="_blank" href="http://pittsburghpa.gov/">The City of Pittsburgh</a></li>
                <li><a target="_blank" href="http://www.cmu.edu/">Carnegie Mellon University</a></li>
            </ul>
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