# Castlegate IT WP User Guide #

Castlegate IT WP User Guide adds a user guide to the WordPress admin panel. A basic user guide is included in the plugin. This plugin is compatible with the Admin Tweaks plugin and will hide some information in the default guide depending on the settings in that plugin.

## Adding sections ##

You can add sections to the guide using the `cgit_user_guide_sections` filter. Functions passed to this filter should have a single argument, which is an array of sections.

    add_filter('cgit_user_guide_sections', function($sections) {
        $sections['unique_key'] = [
            'heading' => 'Section heading',
            'content' => 'Full HTML content ...',
            'order' => 20,
        ];

        return $sections;
    });

The sort order is optional; the default sort order is 10.

## HTML ##

Each section should only contain simple HTML content. The overall page heading is `<h2>` and section headings are `<h3>`, so the content of each section should not contain any headings larger than `<h4>`.

If you want to add images to your section, use the `<figure>` element:

    <figure>
        <img src="<?php echo plugin_dir_url(__FILE__); ?>/foo.png" alt="" />
        <figcaption>An example image caption.</figcaption>
    </figure>

## Editing the default content ##

The default sections are `dashboard`, `posts`, and `content`. These can be overwritten or removed using the filter described above. The default user guide sections are added with a priority of 5, so you may need to set a higher priority for the filter when you are overwriting sections:

    add_filter('cgit_user_guide_sections', function($sections) {
        $sections['dashboard'] = [ ... ];
        return $sections;
    }, 20); // priority 20

## Backwards compatibility ##

Previous versions of this plugin used files within the theme directory to add user guide content. This methods will still work, but it is no longer the recommended way of editing the user guide.
