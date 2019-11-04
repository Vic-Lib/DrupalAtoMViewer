//if(!jQuery('.views-table tr td:first-child span').hasClass('file_details')){
  //jQuery('.views-table tr td:first-child').prepend('<span class="file_details"></span>');
//}

jQuery('.file_details').click(function () {

  var current_row = jQuery(this).closest('tr');

  if (current_row.hasClass('expanded')) {
    current_row.removeClass('expanded');
    jQuery(this).closest('tr').next().remove();
  } else {
    current_row.addClass('expanded');	
    //var identifier = jQuery(this).parent().text().trim();
	var identifier = jQuery(this).attr('data-identifier');
    var current_row = jQuery(this).closest('tr');

    jQuery.ajax({
      url: "/sites/all/themes/pratt_green/archives_view/file_descriptions/file_description.php?identifier=" + identifier,	  
	  //url: "file_description.php?identifier=" + identifier,	  
    }).done(function (data) {
		//console.log(data);
		current_row.after('<tr class="file_description"><td colspan="4">' + data + '</td></tr>');
    });
  }

});


