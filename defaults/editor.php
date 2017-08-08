<p>Adding new posts or pages, or editing existing ones, is done using the edit screen. At the top of the screen is a large text field for the post title. Below that is the permalink, the URL for the post. You should not change the permalink after a post has been published: you will break incoming links from other sites and search engines.</p>

<h4>Content Editor</h4>

<p>Below the title and permalink is the main content editor. This has a basic WYSIWYG interface that lets you mark text as bold or italic, enter bullet and numbered lists, and mark text as a heading. Please take care to use headings as headings, rather than using bold or other &ldquo;presentational&rdquo; formatting. Using the correct markup for a page makes your content more readable to Google and other search engines, as well as helping people with accessibility aids to navigate the content.</p>

<p>The button on the right of the content editor toolbar is labelled <b>Toolbar Toggle</b>. Use this to show more content formatting options. This also reveals a <b>Paste as text</b> button that allows you to paste formatted content from another application while stripping out any styles that would affect its appearance on your website. It is strongly recommended that you use this when pasting from a word processor, such as Microsoft Word.</p>

<p>The chain icon allows you to create links in the content editor. Highlight the text that you would like to link and then click this icon. It brings up a small input into which you can type (or better, paste) any URL, or you can simply start typing the name of any page or post on the site and a list will appear from which you can select a destination for the link.</p>

<p>You can also link to media in your Library from here: you will need to copy the URL from the "Attachment Details" screen in the library.</p>

<figure>
    <img src="<?= CGIT_USER_GUIDE_PLUGIN_URL ?>images/editor.png" alt="" />
    <figcaption>The content editor, showing the default toolbar.</figcaption>
</figure>

<p>Note that the content editor is not a word processor; it is a means of preparing HTML content for your website. The styles and formatting are controlled by a site-wide stylesheet and the content may be filtered before it is displayed on the front-end of the site. Do not attempt to use the content editor to style the content or to add white space to affect the layout—let the website do that for you!</p>

<h4>Categories and Tags</h4>

<p>Posts can be organized using categories and/or tags. These appear on the right side of the edit screen. Categories are required, so any posts that are not assigned to a category will be placed in the &ldquo;Uncategorized&rdquo; category. Tags are entirely optional.</p>

<figure>
    <img src="<?= CGIT_USER_GUIDE_PLUGIN_URL ?>images/taxonomies.png" alt="" />
    <figcaption>Categories and tags. All posts must be assigned to at least one category. Tags are entirely optional.</figcaption>
</figure>

<h4>Page Attributes</h4>

<p>The <b>Page Attributes</b> box on the right side of the edit screen lets you organize your pages. A page can act as a &ldquo;parent&rdquo; page, containing one or more &ldquo;child&rdquo; pages. Use the <b>Parent</b> dropdown in the Page Attributes box to assign the current page to a parent.</p>

<p>The Page Attributes box also includes a field for <b>Order</b>, which lets you specify the menu order of the pages. Lower numbered pages will appear at the top of menus; higher numbered pages will appear lower. This will not have an effect if you are using a custom menu, or if your theme generates a menu using a non-standard method.</p>

<figure>
    <img src="<?= CGIT_USER_GUIDE_PLUGIN_URL ?>images/attributes.png" alt="" />
    <figcaption>Page attributes, showing the Order field.</figcaption>
</figure>

<p>For news posts, the date will be shown on the right hand side in the 'Publish' box. This will automatically be set to the date that the news story was published, but you can change it by clicking 'Edit'. You can also hide content or view past revisions here.</p>