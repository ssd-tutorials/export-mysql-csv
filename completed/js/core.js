var formObject = {
	idContainer : 'columns',
	fetchColumns : function(obj) {
		var v = obj.val();
		if (v !== '') {
			jQuery.getJSON('/mod/columns.php?table='+v, function(data) {
				if (!data.error) {
					$('#' + formObject.idContainer).html(data.list);
				} else {
					$('#' + formObject.idContainer).html('');
				}
			});
		} else {
			$('#' + formObject.idContainer).html('');
		}
	}
};
$(function() {
	
	$('#table').live('change', function() {
		formObject.fetchColumns($(this));
	});
	
});











