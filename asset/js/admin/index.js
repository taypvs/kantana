$(function() {
	$('#add_description').click(function() {
		var newRow = '<div class="input-group margin">';
		newRow += '<div class="form-group"><input type="text" class="form-control description_item" placeholder="Description ..."></div>';
		newRow += '<span class="input-group-btn">';
		newRow += '<button type="button" class="btn btn-info btn-flat">X</button>';
		newRow += '</span>';
		newRow += '</div>';
		$('#description_body').append(newRow);
		sortDescriptionName();

	});

	$('#add_requirement').click(function() {
		var newRow = '<div class="input-group margin">';
		newRow += '<input type="text" class="form-control requirement_item" placeholder="Requirement ...">';
		newRow += '<span class="input-group-btn">';
		newRow += '<button type="button" class="btn btn-info btn-flat">X</button>';
		newRow += '</span>';
		newRow += '</div>';
		$('#requirement_body').append(newRow);
		sortRequirementName();
	});

	$('.remove-line').click(function() {
		$(this).parents().eq(1).remove();
		sortDescriptionName();
		sortRequirementName();
	});

	//Date picker
	$('#datepicker').datepicker({
		autoclose: true
	});
  $('#datepicker_end').datepicker({
		autoclose: true
	});
});

function sortDescriptionName() {
	var count = 0;
	$( ".description_item" ).each(function( index ) {
  	// console.log( index + ": " + $( this ).text() );
		 $(this).attr('name', 'description_item_'+ index);
		 count++;
	});
	$('#deCount').val(count);
}

function sortRequirementName() {
	var count = 0;
	$( ".requirement_item" ).each(function( index ) {
  	// console.log( index + ": " + $( this ).text() );
		 $(this).attr('name', 'requirement_item_'+ index);
		 count++;
	});
	$('#reCount').val(count);
}
