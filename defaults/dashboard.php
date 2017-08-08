<p>The main WordPress admin screen is the Dashboard. At the top of the screen is the admin bar, which contains quick links to the front end of the site and to your user profile. It also includes a <b>New</b> link, which provides a quick way of writing a new post or page.<?= get_option('cgit_admin_hide_toolbar') ? '' : ' The admin bar will also be displayed on the front end of the site while you are logged in.' ?></p>

<p>On the left side of the Dashboard is the main menu, which will contain the following items by default:</p>

<ul>
    <li><b>Dashboard:</b> the main WordPress admin screen</li>

    <?php

    $items = [
        'cgit_admin_hide_menu_posts' => '<b>Posts:</b> date-based news or blog posts, with optional categories and tags',
        'cgit_admin_hide_menu_media' => '<b>Media:</b> images and other files uploaded to the website',
        'cgit_admin_hide_menu_pages' => '<b>Pages:</b> static content pages',
        'cgit_admin_hide_menu_comments' => '<b>Comments:</b> comments submitted to posts and pages',
    ];

    foreach ($items as $key => $text) {
        if (get_option($key)) {
            continue;
        }

        echo '<li>' . $text . '</li>' . PHP_EOL;
    }

    ?>
</ul>

<figure>
    <img src="<?= CGIT_USER_GUIDE_PLUGIN_URL ?>images/dashboard.png" alt="" />
    <figcaption>A typical WordPress Dashboard, showing the admin bar at the top and the main menu on the left.</figcaption>
</figure>

<p>A customized WordPress installation may add others items to this list for other types of content more relevant to your site. When you click on these items, you might see a sub-menu. For example, the <b>Posts</b> menu can contain sub-menu items for <b>Categories</b> and <b>Tags</b>.</p>
