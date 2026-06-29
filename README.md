# Rank Math Lock Modified Date — Default ON

By default, Rank Math's **Lock Modified Date** toggle in the WordPress block editor is OFF. Rank Math does not currently provide a built-in setting to change this default.

This snippet sets the toggle to ON each time the editor loads, then disconnects immediately so the user can still manually unlock it for that save if needed.

## Requirements

* WordPress block editor
* Rank Math SEO plugin

## Installation

### Option A — functions.php

Add the contents of `rankmath-lock-modified-date-default.php` to your theme's `functions.php` file or a site-specific plugin.

### Option B — WPCode or Code Snippets Plugin

Copy the contents of `rankmath-lock-modified-date-default.php` and paste it as a new PHP snippet.

## Behavior

* Runs on post edit screens, including posts, pages, and custom post types.
* Does nothing if Rank Math is not active.
* Fires once per editor load.
* Disconnects as soon as the toggle is found and checked.
* Leaves the toggle alone if it is already checked.
* Does not interfere with the user manually unlocking the date for a given save.

## Notes

This works by observing the editor DOM for Rank Math's **Lock Modified Date** toggle, then clicking it if unchecked.

This is not a Rank Math API integration. If Rank Math or WordPress changes the block editor markup in a future release, this snippet may need to be updated.

## License

GPL-2.0-or-later
