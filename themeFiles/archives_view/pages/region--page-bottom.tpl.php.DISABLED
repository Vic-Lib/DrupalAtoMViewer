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

<!-- set up top info box (green area besides the top image) -->
<script type="text/javascript">
var selector = 'h1, .breadcrumb a:contains("Fonds")';
var title = jQuery(selector).text();
//console.log(text.trim());
jQuery('#banner').after('<div id="top_info_box"><p>' + title + '</p></div>');
</script>

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
</style>

<?php endif; ?>
