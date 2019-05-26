(function( $ ) {
	'use strict';

	$(document).on('click', '#endpoint-for-select', function(event) {
		event.preventDefault();
		selectText('endpoint-for-select');
	});

	function selectText(containerid) {
	  if (document.selection) { // IE
	      var range = document.body.createTextRange();
	      range.moveToElementText(document.getElementById(containerid));
	      range.select();
	  } else if (window.getSelection) {
	      var range = document.createRange();
	      range.selectNode(document.getElementById(containerid));
	      window.getSelection().removeAllRanges();
	      window.getSelection().addRange(range);
	  }
	}

})( jQuery );