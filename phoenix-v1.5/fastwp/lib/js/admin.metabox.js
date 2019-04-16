/* Core file */

jQuery(function($){
	/* Toggle item */
	$('.fastwp_metabox .switch-options > label').on('click', function(e){
		var me = $(this);
		if(me.hasClass('selected')) { return; }
		var data_id = me.attr('data-id');
		var new_value = (me.hasClass('cb-enable'))? 1 : 0;
		$('#'+data_id).val(new_value);
		me.parent().find('label').toggleClass('selected');
	});

	$('.fwp-admin-field-wrap .add-gallery-item').on('click', function(e){
		var me 			= $(this);
		var my_parent 	= me.parents('.fwp-admin-field-wrap');
		var temp_markup	= my_parent.find('.empty-markup').html();
		var my_root_el	= my_parent.find('.items-wrap');
		my_root_el.append(temp_markup);
		my_parent.find('.fwp-no-results').hide();
	});

	if($('.fwp-sortable').length > 0 && typeof $('body').sortable != 'undefined'){
		$('.fwp-sortable').sortable();
	}

	$('.js-add-multi').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		var holder = $(this).parent().next('.js-input-holder');
		var tpl = $(this).prev().find('input[type="text"]').clone(false);
		var oldID = tpl.attr('id');
		var oldName = tpl.attr('name');
	//	tpl1 = tpl1.wrap('<div class="tmpwrap"></div>');
	//	tpl2 = $(tpl1).text();
	var newOrder = holder.find('input').length;
		var newID = oldID.replace('^','').replace('[field','[field'+newOrder);
		var newName = oldName.replace('^','').replace('[field','[field'+newOrder);
	 	tpl.attr('id', newID);
	 	tpl.attr('name', newName);
		holder.append(tpl);

		//console.log(tpl);
	});

	/* Handle image uploading */
	var lastOpenedObject = false;
	var lastOpenedPreview = false;
	jQuery(".fwp-action-upload").live("click", function(e) {
		e.preventDefault();
		lastOpenedObject = jQuery(this).parents('.gallery-item').find(".fwp-source");
		lastOpenedPreview = jQuery(this).parents('.gallery-item').find(".preview");
		formfield = lastOpenedObject.attr("name");
		tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
		
		var ori_send_to_editor = window.send_to_editor;
		window.send_to_editor = function(html) {
			imgurl = jQuery("img",html).attr("src");
			if(lastOpenedObject != false)
				lastOpenedObject.val(imgurl);
				if(typeof lastOpenedPreview.html() == 'string'){
					$('img', lastOpenedPreview).attr('src', imgurl);
				}
			window.send_to_editor = ori_send_to_editor;
			tb_remove();
		}
	return false;
	});



    $(function() {
        $('.fwp-color-field').wpColorPicker();
    });
    

    var is_post_meta = $('#post-formats-select');
    if(typeof is_post_meta.html() == 'string'){
    	fwp_show_metabox();
    	$('[name="post_format"]', is_post_meta).on('click', function(){
    		fwp_show_metabox();
    	});
    }
});

function fwp_show_metabox(){
	var  $ = jQuery;
	var selected = $('[name="post_format"]:checked');
	if(typeof selected.html() == 'string'){
		var _val = selected.val();
		console.log(_val);
		var _ele = $('.fastwp_metabox #post-type-'+ _val);
		$('.fastwp_metabox .post-type-dependant').hide();
		_ele.show();
	}
}

function fwp_remove_item(me){
	var $ = jQuery;
	var me = $(me);
	var gallery_item = me.parents('.gallery-item');
	var my_parent_el = me.parents('.items-wrap');
	if(gallery_item.parent().hasClass('fwp-hidden')){
		console.warn('Trying to remove a hidden item. Don`t do that.')
		return;
	}
	gallery_item.remove();
	console.log($('.gallery-item', my_parent_el));
	if(my_parent_el.find('.gallery-item').length < 1){
		my_parent_el.find('.fwp-no-results').show();
	}
}