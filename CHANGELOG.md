# Changelog

## [1.1.0] - 2026-06-29

### Fixed
- Replaced raw `<script>` tag output (echoed via `enqueue_block_editor_assets`) with `wp_add_inline_script()` attached to the `wp-edit-post` handle. The previous approach caused the browser to render the editor in Quirks Mode, resulting in excessive padding above and below blocks and blocks overlaying meta boxes.

### Changed
- Script logic is now returned from a separate function (`brs_get_lock_rankmath_modified_date_script()`) and passed to `wp_add_inline_script()` rather than being echoed directly into page output.

## [1.0.0] - 2026-06-28

### Added
- Initial release.
- Defaults Rank Math's "Lock Modified Date" toggle to ON when opening the WordPress block editor.
- Uses a `MutationObserver` to detect when the toggle renders, clicks it once if unchecked, then disconnects so users can still manually unlock it for a given save.
- Scoped to post edit screens only (`$screen->base === 'post'`).
- No-ops if RankMath is not active.
