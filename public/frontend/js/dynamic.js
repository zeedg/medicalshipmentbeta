jQuery(function(){

jQuery("#add_controll").click(function(){

				jQuery("#reset_all").show();

				var remove_id=jQuery("#romove_id").val();

				var next=parseInt(remove_id) + parseInt(1);

				

				jQuery('#reset_all').append(

				'<div style="text-align:left" class="remove_textarea" id="remove_textarea' + next + '">' 

					

					+ '<table class="tbl"><tr>'

					

					

					

					+ '<td><input placeholder="Enter Item#" type="text" name="items[]" id="country' + next + '" onkeyup="vpb_suggest_items(this.value, this.id);" class="vpb_input_fields" /></td>'

					

					+ '<td class="td_small"><input type="text" name="qnty[]" class="vpb_input_fields qnty" value="1" style="text-align:center" /></td>'
                    
                    + '<td><textarea name="desc[]" class="text_areaabg" spellcheck="false" id="desc' + next + '"></textarea></td>'
					

					+ '<td class="td_small"><a class="red_link" href="javascript:remove_control(' + next + ')">Remove</a></td>'
					
					+ '<td width="28%"></td>'

					

					

					

					+ '</tr></table>'

					

					+ '<div id="suggestions' + next + '" align="left"></div>'

					

				+ '</div>'

				

				);

				

				jQuery("#romove_id").val(next);

				

		

		});

});

function remove_control(id){

	jQuery('#remove_textarea' + id).fadeOut("normal", function() {

        jQuery(this).remove();

    });

}

function reset_all(id){

	jQuery("#romove_id").val(parseInt(0));

	jQuery('#' + id).slideUp("slow", function() {

        jQuery(this).html('');

		

    });

    

}