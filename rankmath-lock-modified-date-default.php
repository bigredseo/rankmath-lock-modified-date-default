<?php
/**
 * Plugin Name: RankMath Lock Modified Date Default
 * Description: Defaults the RankMath "Lock Modified Date" toggle to ON in the WordPress block editor.
 * Author: Big Red SEO
 * Author URI: https://www.bigredseo.com
 * Version: 1.0.0
 *
 * NOTE: If adding to functions.php, remove the opening <?php line above
 * and the plugin header comment block.
 */

add_action( 'enqueue_block_editor_assets', 'brs_default_lock_rankmath_modified_date_js' );
function brs_default_lock_rankmath_modified_date_js() {
    if ( ! defined( 'RANK_MATH_VERSION' ) ) {
        return;
    }
    $screen = get_current_screen();
    if ( ! $screen || 'post' !== $screen->base ) {
        return;
    }
    ?>
    <script type="text/javascript">
    (function() {
        let hasRun = false;
        let observer = null;

        function lockRankMathModifiedDateOnce() {
            if (hasRun) {
                return;
            }
            const label = Array.from(
                document.querySelectorAll('.components-toggle-control__label')
            ).find(function(el) {
                return el.textContent.trim() === 'Lock Modified Date';
            });
            if (!label) {
                return;
            }
            const flex       = label.closest('.components-flex');
            const toggleSpan = flex ? flex.querySelector('.components-form-toggle') : null;
            const checkbox   = flex ? flex.querySelector('.components-form-toggle__input') : null;
            // Label exists but full toggle is not ready yet — keep observing.
            if (!toggleSpan || !checkbox) {
                return;
            }
            // Only click if currently unchecked.
            if (!toggleSpan.classList.contains('is-checked')) {
                checkbox.click();
            }
            // Stop after the first successful toggle check so it does not fight the user.
            hasRun = true;
            if (observer) {
                observer.disconnect();
            }
        }

        function startObserver() {
            if (!document.body) {
                return;
            }
            observer = new MutationObserver(lockRankMathModifiedDateOnce);
            observer.observe(document.body, {
                childList: true,
                subtree: true,
            });
            // In case the toggle is already in the DOM before the observer fires.
            lockRankMathModifiedDateOnce();
            // Safety cleanup if Rank Math never renders the toggle.
            setTimeout(function() {
                if (observer) {
                    observer.disconnect();
                }
            }, 10000);
        }

        if (document.body) {
            startObserver();
        } else {
            document.addEventListener('DOMContentLoaded', startObserver);
        }
    })();
    </script>
    <?php
}
