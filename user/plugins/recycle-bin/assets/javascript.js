console.log("Custom");
function restore_link (id) {
	if( $('#delete-button-'+id).hasClass('disabled') ) {
		return false;
	}
	if (!confirm('Really delete this data?')) {
		return;
	}
	var keyword = $('#keyword_'+id).val();
	alert(id);
	var nonce = get_var_from_query( $('#restore-button-'+id).attr('href'), 'nonce' );
	$.getJSON(
		custom_ajax_url,
		{ action: "restore", keyword: keyword, nonce: nonce, id: id },
		function(data){
			if (data.success == 1) {
				$("#id-" + id).fadeOut(function(){
					$(this).remove();
					if( $('#main_table tbody tr').length  == 1 ) {
						$('#nourl_found').css('display', '');
					}

					zebra_table();
				});
				decrement_counter();
				decrease_total_clicks( id );
			} else {
				alert('something wrong happened while deleting :/');
			}
		}
	);
}

function temp_remove_link(id) {
	if( $('#delete-button-'+id).hasClass('disabled') ) {
		return false;
	}
	if (!confirm('Really delete?')) {
		return;
	}
	var keyword = $('#keyword_'+id).val();
	var nonce = get_var_from_query( $('#delete-button-'+id).attr('href'), 'nonce' );
	$.getJSON(
		ajaxurl,
		{ action: "delete", keyword: keyword, nonce: nonce, id: id },
		function(data){
			if (data.success == 1) {
				$("#id-" + id).fadeOut(function(){
					$(this).remove();
					if( $('#main_table tbody tr').length  == 1 ) {
						$('#nourl_found').css('display', '');
					}

					zebra_table();
				});
				decrement_counter();
				decrease_total_clicks( id );
			} else {
				alert('something wrong happened while deleting :/');
			}
		}
	);
}
function zebra_table() {
	$("#main_table tbody tr:even").removeClass('odd').addClass('even');
	$("#main_table tbody tr:odd").removeClass('even').addClass('odd');
	$('#main_table tbody').trigger("update");
}

// Ready to add another URL
function add_link_reset() {
	$('#add-url').val('').focus();
	$('#add-keyword').val('');
}

// Increment URL counters
function increment_counter() {
	$('.increment').each(function(){
		$(this).html( parseInt($(this).html()) + 1);
	});
}

// Decrement URL counters
function decrement_counter() {
	$('.increment').each(function(){
		$(this).html( parseInt($(this).html()) - 1 );
	});
}

// Decrease number of total clicks
function decrease_total_clicks( id ) {
	var total_clicks = $("#overall_tracking strong:nth-child(2)");
	total_clicks.html( parseInt( total_clicks.html() ) - parseInt( $('#clicks-' + id).html() ) );
}

// Toggle Share box
function toggle_share(id) {
	if( $('#share-button-'+id).hasClass('disabled') ) {
		return false;
	}
	var link = $('#url-'+id+' a:first');
	var longurl = link.attr('href');
	var title = link.attr('title');
	var shorturl = $('#keyword-'+id+' a:first').attr('href');
	
	toggle_share_fill_boxes( longurl, shorturl, title );
}
