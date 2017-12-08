# Castlegate IT WP User Guide #

Castlegate IT WP User Guide adds a user guide to the WordPress admin panel. A basic user guide is included in the plugin. This plugin is compatible with the Admin Tweaks plugin and will hide some information in the default guide depending on the settings in that plugin.

## Adding sections ##

You can add sections to the guide using the `cgit_user_guide_sections` filter. Functions passed to this filter should have a single argument, which is an array of sections.

~~~ php
add_filter('cgit_user_guide_sections', function($sections) {
    $sections['unique_key'] = [
        'heading' => 'Section heading',
        'content' => 'Full HTML content ...',
        'order' => 20,
    ];

    return $sections;
});
~~~

The sort order is optional; the default sort order is 10.

## HTML ##

Each section should only contain simple HTML content. The overall page heading is `<h2>` and section headings are `<h3>`, so the content of each section should not contain any headings larger than `<h4>`.

If you want to add images to your section, use the `<figure>` element:

~~~ php
<figure>
    <img src="<?= $dir ?>/foo.png" alt="" />
    <figcaption>An example image caption.</figcaption>
</figure>
~~~

## Content parser ##

You can use the `Cgit\UserGuide\Content` class to parse content in PHP or Markdown format. File formats are determined from file name extensions; unknown file formats are assumed to be HTML and are not parsed or modified by the class.

~~~ php
add_filter('cgit_user_guide_sections', function ($sections) {
    $sections['foo'] = [
        'heading' => 'Foo',
        'content' => \Cgit\UserGuide\Content::load('foo.md'),
        'order' => 10,
    ];

    return $sections;
});
~~~

## Editing the menu page ##

You can use WordPress filters to edit the default menu label, user capability required to view the page, and icon:

~~~ php
add_filter('cgit_user_guide_admin_menu_title', 'foo');
add_filter('cgit_user_guide_admin_menu_cap', 'foo');
add_filter('cgit_user_guide_admin_menu_icon', 'foo');
~~~

The capability function should return a valid WordPress user capability. The icon function should return the name of a [Dashicons icon](https://developer.wordpress.org/resource/dashicons/).

You can also use filters to edit the title displayed on the user guide page and whether or not the page should include a table of contents.

~~~ php
add_filter('cgit_user_guide_page_title', 'foo');
add_filter('cgit_user_guide_has_index', 'foo');
~~~

The title function should return a string; the index (table of contents) function should return a boolean.

Finally, the complete HTML of the user guide page can be edited using the `cgit_usre_guide` filter. Remember: with great power comes great responsibility.

## Editing the default content ##

The default sections are `dashboard`, `posts`, and `editor`. These can be overwritten or removed using the filter described above. The default user guide sections are added with a priority of 5, so you may need to set a higher priority for the filter when you are overwriting sections:

~~~ php
add_filter('cgit_user_guide_sections', function($sections) {
    $sections['dashboard'] = [ ... ];
    return $sections;
}, 20); // priority 20
~~~

## Backwards compatibility ##

Previous versions of this plugin used files within the theme directory to add user guide content. This methods will still work, but it is no longer the recommended way of editing the user guide and may cease to work in future versions.

## Video User Manuals ##

If the [Video User Manuals](https://www.videousermanuals.com/) plugin is installed, the guide will be added as a sub-page of the __Manual__ menu.
