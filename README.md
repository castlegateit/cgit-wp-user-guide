# Castlegate IT WP User Guide #

Castlegate IT WP User Guide adds a user guide to the WordPress admin panel. A basic user guide is included in the plugin. This plugin is compatible with the Admin Tweaks plugin and will hide some information in the default guide depending on the settings in that plugin.

## `Cgit\UserGuide` ##

You can edit the user guide using the `Cgit\UserGuide` object. You can access the object directly or use the `cgit_user_guide()` function. The following are equivalent:

    $guide = Cgit\UserGuide::getInstance();
    $guide = cgit_user_guide();

You can then change some basic settings:

    $guide->toc = false; // do not generate a table of contents
    $guide->idPrefix = 'foo_'; // prefix for section heading IDs
    $guide->title = 'User Guide'; // user guide page title
    $guide->separator = '<hr />'; // user guide section separator

## Adding sections ##

You can add sections to the guide using `$guide->addSection()`, which lets you control the heading, content, and sort order of your section:

    $guide->addSection('unique_key', [
        'heading' => 'Example section',
        'content' => 'Full HTML content ...',
        'order' => 20,
    ]);

The sort order is optional; the default sort order is 10.

## Removing sections ##

Sections can also be removed:

    $guide->removeSection('unique_key');

## HTML ##

Each section should only contain simple HTML content. The overall page heading is `<h2>` and section headings are `<h3>`, so the content of each section should not contain any headings larger than `<h4>`.

If you want to add images to your section, use the `<figure>` element:

    <figure>
        <img src="<?php echo plugin_dir_url(__FILE__); ?>/foo.png" alt="" />
        <figcaption>An example image caption.</figcaption>
    </figure>

## Editing the default content ##

The default sections are `dashboard`, `posts`, and `content`. These can be overwritten or removed using the add and remove methods described above.

## Backwards compatibility ##

Previous versions of this plugin used files within the theme directory or filters to add user guide content. These methods will still work, but are no longer the recommended ways of editing the user guide.
