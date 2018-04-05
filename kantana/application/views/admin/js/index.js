$(function() {

			var lineCount = 1;

			$('#add_description').click(function() {
				// [data-target]�̑����l����������
				var newRow = '<div class="form-group"><input type="text" name="description_item_' + lineCount + '" class="form-control" placeholder="Description ..."></div> ';
				$('#requirement_body').append(newRow);

			});

});
