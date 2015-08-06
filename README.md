# Castlegate IT WP User Guide #

Castlegate IT WP User Guide adds a user guide to the WordPress admin panel. A basic user guide is included in the plugin. This plugin is compatible with the Admin Tweaks plugin and will hide some information in the default guide depending on the settings in that plugin.

## Adding sections ##

You can add sections to the guide using the `cgit_user_guide_sections` filter. Functions passed to this filter should have a single argument, which is an array of sections.

    function foo_user_guide($sections) {
        $sections[] = '<p>User guide section content.</p>';
        return $sections;
    }

    add_filter('cgit_user_guide_sections', 'foo_user_guide', 20);

The default user guide is added with the priority 1 (the default priority is 10). You can use priorities to affect the order in which the sections appear in the guide.

## HTML ##

Each section should only contain simple HTML content. The overall page heading is `<h2>`, so the content of each section should not contain any headings larger than `<h3>`.

## Editing the default content ##

The default user guide content is simply an item in the array of sections with the key `default`. To edit the content, add a filter that alters this item. To overwrite the content, add a filter that replaces the item. To remove the content, add a filter that removes the item. The priority of the filter should be higher than 1 for these changes to be effective.

The page title and section separator can be edited using the `cgit_user_guide_title` and `cgit_user_guide_separator` filters respectively.

## Backwards compatibility ##

Previous versions of this plugin simply checked for the existence of a file called `user-guide.php` in the active theme directory. For compatibility with older sites and themes, the plugin still checks for this file. However, this is no longer the recommended way of editing the user guide.
