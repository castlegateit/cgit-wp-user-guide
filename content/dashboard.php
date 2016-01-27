<p>The main WordPress admin screen is the Dashboard. At the top of the screen is the admin bar, which contains quick links to the front end of the site and to your user profile. It also includes a &ldquo;New&rdquo; link, which provides a quick way of writing a new post or page.<?php if (!get_option('cgit_admin_hide_toolbar')): ?> The admin bar will also be displayed on the front end of the site while you are logged in.<?php endif; ?></p>

<p>On the left side of the Dashboard is the main menu, which will contain the following items by default:</p>

<ul>
    <li>Dashboard: the main WordPress admin screen</li>
    <?php if (!get_option('cgit_admin_hide_menu_posts')): ?><li>Posts: date-based news or blog posts, with optional categories and tags</li><?php endif; ?>
    <?php if (!get_option('cgit_admin_hide_menu_media')): ?><li>Media: images and other files uploaded to the website</li><?php endif; ?>
    <?php if (!get_option('cgit_admin_hide_menu_pages')): ?><li>Pages: static content pages</li><?php endif; ?>
    <?php if (!get_option('cgit_admin_hide_menu_comments')): ?><li>Comments: comments submitted to posts and pages</li><?php endif; ?>
</ul>

<figure>
    <img src="<?= CGIT_USER_GUIDE_PLUGIN_URL ?>static/images/dashboard.png" alt="" />
    <figcaption>A typical WordPress Dashboard, showing the admin bar at the top and the main menu on the left.</figcaption>
</figure>

<p>A customized WordPress installation may add others items to this list for other types of content more relevant to your site. When you click on these items, you might see a sub-menu. For example, the Posts menu can contain sub-menu items for Categories and Tags.</p>
