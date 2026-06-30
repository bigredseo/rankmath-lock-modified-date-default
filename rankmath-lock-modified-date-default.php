<?php
/**
 * Plugin Name: Rank Math Lock Modified Date Default
 * Description: Defaults the Rank Math "Lock Modified Date" toggle to ON in the WordPress block editor.
 * Author: Big Red SEO
 * Author URI: https://www.bigredseo.com
 * Version: 1.0.0
 * GitHub URI: https://github.com/bigredseo/rankmath-lock-modified-date-default
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

    wp_add_inline_script(
        'wp-edit-post',
        brs_get_lock_rankmath_modified_date_script()
    );
}

function brs_get_lock_rankmath_modified_date_script() {
    return <<<JS
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
            if (!toggleSpan || !checkbox) {
                return;
            }
            if (!toggleSpan.classList.contains('is-checked')) {
                checkbox.click();
            }
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
            lockRankMathModifiedDateOnce();
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
    JS;
}
