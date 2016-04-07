<?php
/**
 * A Template for the WPRDC Theme
 *
 * @package WordPress
 * @subpackage WPRDC
 */
Twitter::getTweets();
get_header(); ?>

<!-- Header  -->
<div class="map-header">
    <div class="floating-text">
        <h3><a href="https://data.wprdc.org/dataset/real-estate-sales">Get the Data!</a></h3>
        <h3><a target="_blank" href="https://wprdc.cartodb.com/viz/24397410-dccd-11e5-82a8-0ea31932ec1d/public_map">See
                the Map!</a></h3>
    </div>
    <div id="map-box" style="height: 280px; width: 100%;">
    </div>
</div>


<div id="main-title" class="content-container">
    <div class="row collapse">
        <div>
            <h1 id="main-title">Western Pennsylvania Regional Data Center</h1>
        </div>
        <div class="medium-4 medium-centered columns">
            <hr>
        </div>

        <h3 class="text-center">Find the data you need!</h3>
        <?php if ($response = ckan_api_get("action/package_search")) : ?>
            <p class="text-center"><?php echo $response->count; ?>
                dataset<?php echo($response->count > 1 ? 's' : ''); ?> andgrowing</p>
        <?php endif; ?>
        <div class="medium-6 medium-centered columns">
            <form method="get" action="https://data.wprdc.org/dataset">
                <div class="row collapse">
                    <div class="small-9 columns">
                        <label for="data-search">
                            <input type="text" name="q" placeholder="Search Datasets"/>
                        </label>
                    </div>
                    <div class="small-3 columns">
                        <input type="submit" class="button postfix" value="Search"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Selection Section -->
<div class="content-container">
    <div class="row">
        <ul class="small-block-grid-2 medium-block-grid-2 large-block-grid-4">
            <li id="menu-groups">
                <a class="main-menu-item" href="#data-categories">
                    <div class="panel main-menu">
                        <i class="material-icons menu-icon">explore</i>
                        <h3 class="menu-item-title">Explore</h3>
                    </div>
                </a>
            </li>
            <li id="menu-involved">
                <a class="main-menu-item" href="#get-involved">
                    <div class="panel main-menu">
                        <i class="material-icons menu-icon">hot_tub</i>
                        <h3 class="menu-item-title">Get Involved</h3>
                    </div>
                </a>
            </li>
            <li id="menu-groups">
                <a class="main-menu-item" href="#showcase">
                    <div class="panel main-menu">
                        <i class="material-icons menu-icon">assessment</i>
                        <h3 class="menu-item-title">Showcase</h3>
                    </div>
                </a>
            </li>
            <li id="menu-groups">
                <a class="main-menu-item" href="#api-section">
                    <div class="panel main-menu">
                        <i class="material-icons menu-icon">developer_mode</i>
                        <h3 class="menu-item-title">Build Stuff</h3>
                    </div>
                </a>
            </li>
            <li id="menu-groups">
                <a class="main-menu-item" href="#popular-datasets">
                    <div class="panel main-menu">
                        <i class="material-icons menu-icon">whatshot</i>
                        <h3 class="menu-item-title">Hot Datasets</h3>
                    </div>
                </a>
            </li>
            <li id="menu-groups">
                <a class="main-menu-item" href="#data-requests">
                    <div class="panel main-menu">
                        <i class="material-icons menu-icon">question_answer</i>
                        <h3 class="menu-item-title">Requests</h3>
                    </div>
                </a>
            </li>
            <li id="menu-groups">
                <a class="main-menu-item" href="#recent-blog-posts">
                    <div class="panel main-menu">
                        <i class="material-icons menu-icon">subject</i>
                        <h3 class="menu-item-title">News</h3>
                    </div>
                </a>
            </li>
            <li id="menu-groups">
                <a class="main-menu-item" href="#latest-tweets">
                    <div class="panel main-menu">
                        <i class="fa fa-twitter menu-icon"></i>
                        <h3 class="menu-item-title">Tweets!</h3>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Categories/Groups -->
<div id="data-categories" class="offset content-container">

    <div class="row">
        <h3 class="text-center">Explore</h3>
    </div>
    <div class="row">
        <div class="small-12 columns">

            <h4>Groups/Topics</h4>
            <ul class="large-block-grid-4 small-block-grid-1">
                <?php if ($response = ckan_api_get("action/group_list?all_fields=true")) : ?>
                    <?php foreach ($response as $group) : ?>
                        <li>
                            <a href="<?php echo esc_url(ckan_url('group/' . $group->name)); ?>"><?php echo $group->display_name; ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li><p>Nothing has been created</p></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="small-12 columns">
            <h4>Organizations</h4>
            <ul class="large-block-grid-4 small-block-grid-1">
                <?php if ($response = ckan_api_get("action/organization_list?all_fields=true")) : ?>
                    <?php foreach ($response as $res) : ?>
                        <li>
                            <a href="<?php echo esc_url(ckan_url('organization/' . $res->name)); ?>"><?php echo $res->display_name; ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li><p>Nothing has been created</p></li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</div>

<!-- Newsletter Section -->
<div id="get-involved" class="offset content-container dark">
    <div class="row text-center animateme"
         data-when="span"
         data-from="0"
         data-to="1"
         data-opacity="0"
    >
        <div class="large-12 columns">
            <h3>Get Involved!</h3>
            <p>Share your email to stay on top of the latest Data Center news and activities.</p>
            <form class="newsletter" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>" data-abide="ajax"
                  autocomplete="off">
                <?php wp_nonce_field('newsletter-register'); ?>
                <div class="row collapse">
                    <div class="medium-6 medium-centered columns">
                        <div class="row collapse">
                            <div class="small-9 columns error">
                                <label for="email">
                                    <input type="email" value="" name="email" placeholder="Your Email Address"
                                           required/>
                                </label>
                                <small class="error">A valid email address is required.</small>
                            </div>
                            <div class="small-3 columns">
                                <input type="submit" class="button postfix" value="Sign Up"/>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row collapse">
                <div class="small-12 columns">
                    <br>
                    <p>Be part of our research by signing up for our registry.</p>
                </div>
            </div>
            <div class="row collapse">
                <div class="medium-2 medium-centered columns">
                    <a href="https://sbs.ucsur.pitt.edu/reg/?s=dc" target="_blank" class="button small postfix">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Showcase Section -->
<div id="showcase" class="offset content-container white scrollme">
    <div class="row">
        <div class="large-12 columns">
            <h3>Data Center Showcase</h3>
            <p>See what others have created using our data. <a
                    href="<?php echo esc_url(get_category_link(get_cat_ID('showcase'))); ?>">Click here</a> to view all
                showcase items.</p>
            <?php if ($posts = wp_get_recent_posts(array('numberposts' => 10, 'category' => get_cat_ID('showcase')), OBJECT)) : ?>
                <ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-5">
                    <?php foreach ($posts as $post) : ?>
                        <?php if (has_post_thumbnail()) : ?>
                            <li id="post-<?php echo $post - ID; ?>" class="showcase-item"
                                data-bottom-top="opacity: 0; transform: translateY(200px);"
                                data-center-top="opacity: 1; transform: translateY(0px);">
                                <a href="<?php echo get_permalink($post->ID); ?>">
                                    <div class="panel">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                        <p class="showcase-title"><?php echo $post->post_title; ?></p>
                                        <p class="showcase-desc"><?php echo wp_trim_words($post->post_content, 12); ?></p>
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
<div id="api-section" class="content-container light-blue">
    <div class="row valign-middle">
        <div class="medium-9 columns">
            <h3>Build something amazing with our data!</h3>
            <p>Using the Data Center's API, you have direct access to the published datasets to create applications.</p>
        </div>
        <div class="medium-3 columns text-center">
            <a href="http://ckan.readthedocs.org/en/ckan-2.4.0/api/index.html" target="_blank"
               class="button secondary no-margin">Learn More</a>
        </div>
    </div>
</div>


<!-- Recent Updates -->
<div id="popular-datasets" class="content-container white">
    <h3 class="text-center">Most Viewed Datasets</h3>
    <div class="row">
        <?php if ($response = ckan_api_get("action/package_search?sort=views_recent%20desc&rows=3")) : ?>
            <?php foreach ($response->results as $res) : ?>
                <?php if (!$res->private) : ?>
                    <div class="medium-4 columns">
                        <h5>
                            <a href="<?php echo esc_url(ckan_url('dataset/' . $res->name)); ?>"><?php echo $res->title; ?></a>
                        </h5>
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
<div id="data-requests" class="content-container dark">
    <div class="row valign-middle">
        <div class="medium-9 columns">
            <h3>What dataset would you like to see?</h3>
            <p>Do you have an idea for a dataset that you would like to see?</p>
        </div>
        <div class="medium-3 columns text-center">
            <a href="<?php echo esc_url(ckan_url('datarequest')); ?>" class="button no-margin">Request a Dataset</a>
        </div>
    </div>
</div>

<!-- Recent WP Posts -->
<div id="recent-blog-posts" class="content-container white">
    <div class="row">
        <div class="large-12 columns">
            <h3>Latest Data Center News</h3>
            <?php if ($posts = wp_get_recent_posts(array('numberposts' => 5, 'category__not_in' => get_cat_ID('showcase')), OBJECT)) : ?>
                <?php foreach ($posts as $post) : ?>
                    <div id="post-<?php echo $post - ID; ?>">
                        <h4><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h4>
                        <p><?php echo wp_trim_words($post->post_content); ?></p>
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
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/twitter-32.png"
                     alt="Small Twitter Badge"/>&nbsp;&nbsp;Our Latest Tweets:
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
                <?php if ($tweets = wincache_ucache_get('tweets')) : ?>
                    <?php foreach ($tweets as $tweet) : ?>
                        <li><p><?php echo $tweet; ?></p></li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li><p>An issue has occurred retrieving the latest tweets.</p></li>
                <?php endif; ?>
            </ul>
            <div class="follow-info right">
                <p>
                    <a href="https://twitter.com/<?php echo get_option('wprdc_theme_setting_twitter', 'WPRDC'); ?>"
                       target="_blank">
                        Follow <?php echo get_option('wprdc_theme_setting_twitter', 'WPRDC'); ?>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/skrollr.min.js"></script>
<script>
    var s = skrollr.init({
        beforerender: function (data) {
            return data.curTop > data.lastTop;
        }
    });
</script>

<!--CartoDB Stuff-->
<script src="http://libs.cartocdn.com/cartodb.js/v3/3.15/cartodb.js"></script>
<script>
    window.onload = function () {
        var url = 'https://wprdc.cartodb.com/api/v2/viz/24397410-dccd-11e5-82a8-0ea31932ec1d/viz.json';
        cartodb.createVis('map-box',
            url,
            {zoomControl: false}
        );
    }
</script>

<script>
    var scrolling = false;
    $(".main-menu-item").on('click', function () {
        var destination = $(this).attr('href');
        scrolling = true;
        $("html, body").animate({scrollTop: $(destination).offset().top - 54}, 800);
    });
    $(document).ready(function () {
        $(".scroll-to-top").hide();
        //Check to see if the window is top if not then display button
        $(window).scroll(function () {
            if ($(this).scrollTop() > $('#main-title').offset().top - 54) {
                $(".scroll-to-top").fadeIn();
            } else {
                $(".scroll-to-top").fadeOut();
            }
        });

        //Click event to scroll to top
        $(".scroll-to-top").click(function () {
            $("html, body").animate({scrollTop: $('#main-title').offset().top - 54}, 800);
            scrolling = true;
        });
    });
</script>

</body>
</html>