<?php
/**
 * Footer Template
 *
 * @package WordPress
 * @subpackage WPRDC
 */
?>
    </div>

    <!-- Footer -->
    <div id="footer">
        <div class="sub-footer">
            <div class="row">
                <div class="medium-12 columns">
                    <p class="footer-title">About</p>
                    <p><?php echo nl2br(esc_attr(get_option('wprdc_theme_setting_about'))); ?></p>
                </div>
            </div>
        </div>

        <div class="legal">
            <div class="row">
                <div class="small-12 columns">
                    <p class="clearfix">
                <span class="left">
                    <a href="<?php echo esc_url(home_url('/about/')); ?>">About</a> &nbsp; | &nbsp;
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a> &nbsp; | &nbsp;
                    <a href="<?php echo esc_url(home_url('/terms-of-use/')); ?>">Terms</a> &nbsp; | &nbsp;
                    <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy</a>
                </span>
                        <span class="right">Powered by <a href="http://ucsur.pitt.edu" target="_blank">UCSUR</a>.</span>
                    </p>
                    <p>&copy; <?php echo date('Y') . ' ' . get_bloginfo() ?>. &nbsp; All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Modal for Alerts -->
    <div id="alertModal" class="reveal-modal" data-reveal aria-labelledby="title" aria-hidden="true" role="dialog">
        <h2 id="ModalTitle"></h2>
        <p id="ModalLead" class="lead"></p>
        <p id="ModalText"></p>
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>

    <!-- Javascript -->
    <script type="text/javascript">
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', '<?php echo get_option('wprdc_theme_setting_google'); ?>', 'auto');
        ga('send', 'pageview');
    </script>

<?php wp_footer(); ?>