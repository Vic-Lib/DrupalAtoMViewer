<?php
/**
 * @file
 * Zen theme's implementation to display a region.
 *
 * Available variables:
 * - $content: The content for this region, typically blocks.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - region: The current template type, i.e., "theming hook".
 *   - region-[name]: The name of the region with underscores replaced with
 *     dashes. For example, the page_top region would have a region-page-top class.
 * - $region: The name of the region variable as defined in the theme's .info file.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 *
 * @see template_preprocess()
 * @see template_preprocess_region()
 * @see zen_preprocess_region()
 * @see template_process()
 * 
 * TODO
 * What is this for?
 * 
 */
?>
<?php if ($content): ?>
  <div class="<?php print $classes; ?>">
    <?php print $content; ?>
  </div><!-- /.region -->
<?php endif; ?>

<?php
//for Finding Aids section only
//$current_path = current_path();
//if(strpos($current_path, 'atomdrupalconnector') !== false):
$views_page = views_get_page_view();
if(is_object($views_page) && $views_page->name == 'atomdrupalconnector'):
?>

<style type="text/css">
#banner {
	background-color: #999;
	float: left;
	height: 350px;
	width: 620px;
}

#top_info_box {
	/* background-color: #184f63; */
	background-color: #00514a;
	float: left;
	height: 350px;
	width: 340px;
}

#top_info_box p {
	color: #fff;
	display: table-cell;
	font-family: 'BellGothicStdBold', Verdana, Arial, Helvetica, sans-serif;
	font-size: 2.8em;
	height: 245px;
	line-height: 1.1em;
	padding-left: 30px;
	padding-right: 45px;
	text-transform: uppercase;
	vertical-align: middle;
}

/* breadcrumb */
.breadcrumb {
    overflow: hidden;
	white-space: nowrap;
}

.breadcrumb .selected {	
	vertical-align: bottom;	
}

.breadcrumb a {
	padding: 0;
	display: inline-block;
	vertical-align: bottom;
    max-width: 100px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;	
}

.breadcrumb a:hover {
	max-width: none;
}

/* sidebar */
.region-sidebar-first {
	margin-top: 20px;
}

.region-sidebar-first .block-title {	
	margin-left: 20px;
	margin-bottom: 7px;
	width: auto;
}

.sc_sidebar_header {
	border-bottom: 0;
	padding-left: 20px;
	padding-bottom: 0;
}

.sc_sidebar_header a {
	font-family: Verdana,Arial,Helvetica,sans-serif;
	font-size: 13px;
	text-transform: none;
}

.sc_sidebar_header a.active {
	font-weight: bold;
}

.archives_subseries_heading {	
	list-style-type: none;
	padding-left: 38px;
}

/* Show All Subseries checkbox */
.show_all_subseries_container {
	padding: 0;
	padding-top: 7px;
	padding-left: 20px;
	padding-bottom: 20px;
}

.show_all_subseries_container input[type="checkbox"] {
	margin-left: 0;
	margin-right: 7px;
}

.show_all_subseries_container input[type="checkbox"],
.show_all_subseries_container label
{	

	display: inline-block;
	color: #444;
	font-family: Verdana,Arial,Helvetica,sans-serif;
	font-weight: normal;
	font-size: 13px;
	vertical-align: middle;
}

/* make sure the contextual menu/gear icon displays properly */
.region-content {
	padding-left: 20px;
	overflow: hidden;
}

/* content area */
.view-atomdrupalconnector .item-list ul {	
	margin-left: -20px;
}

</style>

<?php endif; ?>
