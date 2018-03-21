(function ($) {
	'use strict';

	function getParameterByName(name, url) {
	    if (!url) url = window.location.href;
	    name = name.replace(/[\[\]]/g, "\\$&");
	    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	        results = regex.exec(url);
	    if (!results) return null;
	    if (!results[2]) return '';
	    return decodeURIComponent(results[2].replace(/\+/g, " "));
	}

	$('.pw_select_tagger').each(function () {
		$(this).select2({
			allowClear: true,
			tags: true
		});
	});

	$.fn.extend({
		select2_sortable: function () {
			var select = $(this);
			$(select).select2({
				tags: true,
				createTag:function(params){
					var term = $.trim(params.term);
					
					return {
				      id: term,
				      text: term,
				      newTag: true
				    }
				},
				insertTag:function(data, tag){
					data.push(tag);
				}
			});
			var ul = $(select).next('.select2-container').first('ul.select2-selection__rendered');
			ul.sortable({
				containment: 'parent',
				items      : 'li:not(.select2-search--inline)',
				tolerance  : 'pointer',
				stop       : function () {
					$($(ul).find('.select2-selection__choice').get().reverse()).each(function () {
						var id = $(this).data('data').id;
						var option = select.find('option[value="' + id + '"]')[0];
						$(select).prepend(option);
					});
				}
			});
		}
	});

	$('.pw_multitagselect').each(function () {
		$(this).select2_sortable();
	});
	
	$('.pw_multitagselect').on('select2:select', function (evt) {		
		
	
		var $this = $(this);
		console.log(evt);
		console.log($this);
		if((evt.params.data.newTag === true) && (evt.params.data.text = evt.params.data.id)){
			var data = Object();
			data.taxonomy 	= $this.attr('taxonomy');
			data.post		= getParameterByName('post');
			data.action 	= 'add_people_term';
			data.text		=  evt.params.data.text;
					
			$.ajax({
			    type: "POST",
			    url: "/wp-admin/admin-ajax.php",
			    data: data,
			    error: function(jqXHR, textStatus, errorThrown){                                        
			        console.error("The following error occured: " + textStatus, errorThrown);                                                       
			    },
			    success: function(result) {
			        var term_id = result,
			        	newOption = new Option(data.text, term_id, true, true);
			        $this.find('option[value="'+data.text+'"]').remove();
			        
					$this.append(newOption).trigger('change');
			    }                              
			});
		} 
	});
	
	$('.pw_multitagselect').on('select2:unselect', function (evt) {		
		var data = evt.params.data,
			$this = $(this),
			senddata = Object();
			
		console.log(evt);
		
		if(data.selected === false) {
			senddata.term_id	= data.id;
			senddata.taxonomy 	= $this.attr('taxonomy');
			senddata.post		= getParameterByName('post');
			senddata.action 	= 'remove_people_term_from_post';
			$.ajax({
			    type: "POST",
			    url: "/wp-admin/admin-ajax.php",
			    data: senddata,
			    error: function(jqXHR, textStatus, errorThrown){                                        
			        console.error("The following error occured: " + textStatus, errorThrown);                                                       
			    },
			    success: function(result) {
			        console.log(result);
			    }                              
			});
		}
	});
	

	// Before a new group row is added, destroy Select2. We'll reinitialise after the row is added
	$('.cmb-repeatable-group').on('cmb2_add_group_row_start', function (event, instance) {
		var $table = $(document.getElementById($(instance).data('selector')));
		var $oldRow = $table.find('.cmb-repeatable-grouping').last();

		$oldRow.find('.pw_select2').each(function () {
			$(this).select2('destroy');
		});
	});

	// When a new group row is added, clear selection and initialise Select2
	$('.cmb-repeatable-group').on('cmb2_add_row', function (event, newRow) {
		$(newRow).find('.pw_select_tagger').each(function () {
			$('option:selected', this).removeAttr("selected");
			$(this).select2({
				allowClear: true,
				tags: true
			});
		});

		$(newRow).find('.pw_multitagselect').each(function () {
			$('option:selected', this).removeAttr("selected");
			$(this).select2_sortable({tags: true});
		});

		// Reinitialise the field we previously destroyed
		$(newRow).prev().find('.pw_select_tagger').each(function () {
			$(this).select2({
				allowClear: true,
				tags: true
			});
		});

		// Reinitialise the field we previously destroyed
		$(newRow).prev().find('.pw_multitagselect').each(function () {
			$(this).select2_sortable();
		});
	});

	// Before a group row is shifted, destroy Select2. We'll reinitialise after the row shift
	$('.cmb-repeatable-group').on('cmb2_shift_rows_start', function (event, instance) {
		var groupWrap = $(instance).closest('.cmb-repeatable-group');
		groupWrap.find('.pw_select2').each(function () {
			$(this).select2('destroy');
		});

	});

	// When a group row is shifted, reinitialise Select2
	$('.cmb-repeatable-group').on('cmb2_shift_rows_complete', function (event, instance) {
		var groupWrap = $(instance).closest('.cmb-repeatable-group');
		groupWrap.find('.pw_select_tagger').each(function () {
			$(this).select2({
				allowClear: true,
				tags: true
			});
		});

		groupWrap.find('.pw_multitagselect').each(function () {
			$(this).select2_sortable();
		});
	});

	// Before a new repeatable field row is added, destroy Select2. We'll reinitialise after the row is added
	$('.cmb-add-row-button').on('click', function (event) {
		var $table = $(document.getElementById($(event.target).data('selector')));
		var $oldRow = $table.find('.cmb-row').last();

		$oldRow.find('.pw_select2').each(function () {
			$(this).select2('destroy');
		});
	});

	// When a new repeatable field row is added, clear selection and initialise Select2
	$('.cmb-repeat-table').on('cmb2_add_row', function (event, newRow) {

		// Reinitialise the field we previously destroyed
		$(newRow).prev().find('.pw_select_tagger').each(function () {
			$('option:selected', this).removeAttr("selected");
			$(this).select2({
				allowClear: true,
				tags: true
			});
		});

		// Reinitialise the field we previously destroyed
		$(newRow).prev().find('.pw_multitagselect').each(function () {
			$('option:selected', this).removeAttr("selected");
			$(this).select2_sortable();
		});
	});
})(jQuery);