<?php
/**
 * A Template for the WPRDC Theme
 *
 * @package WordPress
 * @subpackage WPRDC
 */
get_header(); ?>

<!-- Posts/Categories/Archive -->
<div class="content-container">
    <div class="row">
        <div class="large-12 columns">
            <?php if (have_posts()) : ?>
                <h1><?php echo single_cat_title('', false); ?></h1>
                <hr>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="category-item clearfix">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?><a/></h3>
                            <hr>
                            <div class="clearfix">
                                <p class="left">
                                    by <?php the_author(); ?>

                                </p>
                                <p class="right">
                                    <?php the_date(); ?>
                                </p>
                            </div>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail-wrapper left thumbnail">
                                    <?php echo get_the_post_thumbnail(get_the_ID(), array(125, 125)); ?>
                                </div>
                            <?php endif; ?>
                            <div class="entry-content">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
                <?php foundation_pagination(); ?>
            <?php else : ?>
                <div class="entry-content">
                    <h1>Nothing Found!</h1>
                    <hr>
                    <p>Sorry, but nothing has been posted for <?php echo single_cat_title('', false); ?> yet. Try
                        checking back later to see if anything has been posted.</p>
                    <br>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
</body>
</html>
