
jQuery(document).ready(function(){

	jQuery("#myForm").submit(function(e) {
		e.preventDefault();
		let data = {
			action: 'stored-value',
			name: jQuery("#name").val(),
			class: jQuery("#class").val(),
			age: jQuery("#age").val(),
		};

		jQuery.post(ajax_object.ajaxurl, data,
			function(response) {
				if (response.success) {
					let html = "<tr><th>"+response.id+"</th><td>"+jQuery("#name").val()+"</td><td>"+jQuery("#class").val()+"</td><td>"+jQuery("#age").val()+"</td></tr>";
					jQuery(".itemRow").append(html)
				}
			}
			);
	});




	jQuery("#teacherForm").submit(function(e) {
		e.preventDefault();
		let data = {
			action: 'stored-value-teacher',
			name: jQuery("#name").val(),
			class: jQuery("#department").val(),
			age: jQuery("#age").val(),
		};

		jQuery.post(ajax_object.ajaxurl, data,
			function(response) {
				if (response.success) {
					let html = "<tr><th>"+response.id+"</th><td>"+jQuery("#name").val()+"</td><td>"+jQuery("#department").val()+"</td><td>"+jQuery("#age").val()+"</td></tr>";
					jQuery(".tableRow").append(html)
				}
			}
			);
	})






	


});