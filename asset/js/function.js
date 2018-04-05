$(function(){

  var current_line;
  var current_customer;
  var current_agency;
  var multi_factor = 1;
  var maxItem = 0;
  var est_total_top = $("#est-total-top");
  var est_sale_total_top = $("#est-sale-total-top");;
  var gross_profit = $("#gross-profit");
  var table  = "#est-table";
  var table_sale = "#sale-table"

  $( '.acdn-button' ).click( function()
  {
  	// [data-target]�̑����l����������
    var target = $( this ).data( 'target' ) ;

  	$( this ).toggleClass("open") ;
  	// [target]�Ɠ������O��ID�����v�f��[slideToggle()]�����s����
  	$( '#' + target ).slideToggle() ;
  } ) ;

  //==================== TOP TABLE ====================
  // ********
  // Function Change Multiplication when choose Customer
  $('.est-customer').on('change', function() {
    if ($( this ).val () != '') {
      current_customer = getValueSplit($( this ).val (), 0);
    }
  });

  // ********
  // Function Change Multiplication when choose Customer
  $('.est-agency').on('change', function() {
    if ($( this ).val () != '') {
      multi_factor = getValueSplit($( this ).val (), 1);
      current_agency = getValueSplit($( this ).val (), 0);

      setMultiFactor (multi_factor);

      // Calculate for 見積原価合計 - 見積参考売価合計 - 粗利益
      calculatePrice ();
    }
  });


  //====================  BOTTOM TABLE ================
  // ********
  // Function get ID Item when click on row
  $( '.est-cell' ).click( function()
  {
  	// [data-target]�̑����l����������
  	var line = $( this ).parent().children(':first');
    current_line = line.text();
    // console.log(current_line);
  });

  // ********
  // Function Change Price when choose product
  $('.est-product').on('change', function() {
    onChangeProduct (this);
  });

  // ********
  // Function Change Total Price when change Quantity
  $('.est-quantity').change(function() {
    onChangeQuantity (this);
  });

  // *********
  // Add - Remove Button.  追加・削除
  $( '.add-btn-below' ).click( function()
  {
    createNewLine ($( this ).parents().eq(2), true) ;
    // createNewLineSale ($( this ).parents().eq(2), true) ;
  } ) ;

  $( '.add-btn-above' ).click( function()
  {
    createNewLine ($( this ).parents().eq(2), false) ;
    // createNewLineSale ($( this ).parents().eq(2), false) ;
  } ) ;

  $( '.remove-btn' ).click( function()
  {
    // createNewLine ($( this ).parents().eq(2), false) ;
    removeLine ($( this ).parents().eq(2));
    // removeLineSale ($( this ).parents().eq(2));
  } ) ;

  $( function() {
    $( "#datepicker" ).datepicker();
    $( "#fromdate" ).datepicker({
      dateFormat: "yy-mm-dd",
    });
    $( "#todate" ).datepicker({
      dateFormat: "yy-mm-dd",
    });
  } );

  function getValueSplit (value, position) {
    return value.split("-")[position];
  }

  function formatPrice (price) {
    price = Math.round(price) + "";
    var priceArr = price.split ("");
    var priceFormat = "";
    var counter = 0;
    for (var i = (priceArr.length-1); i >= 0; i--) {
      counter++;
      priceFormat += priceArr[i];
      if (counter == 3 && i > 0){
        priceFormat += ",";
        counter = 0;
      }
    }
    return priceFormat.split("").reverse().join("");
  }

  //  SUBMIT DATA
  $("#send").click(function()
    {
      var method = "post"; // Set method to post by default if not specified.
      var path = "estimationlist";

      var form = document.createElement("form");
      form.setAttribute("method", method);
      form.setAttribute("action", path);

      for(var key in params) {
        if(params.hasOwnProperty(key)) {
          var hiddenField = document.createElement("input");
          hiddenField.setAttribute("type", "hidden");
          hiddenField.setAttribute("name", key);
          hiddenField.setAttribute("value", params[key]);

          form.appendChild(hiddenField);
        }
      }
      document.body.appendChild(form);
      form.submit();
    });

    function collectDataTableBottom () {
      // Collect Value
      var cost_table = $("#est-table").children(':first');
      var current_row = cost_table.children(':nth-child(' +  (parseInt(current_line) + 2) + ')');
      // Estimate Cost Colunm
      var product_col = current_row.children(':nth-child(2)');
      var note_col = current_row.children(':nth-child(3)');
      var est_price_col = current_row.children(':nth-child(4)');
      var quantity_col = current_row.children(':nth-child(5)');
      var unit_col = current_row.children(':nth-child(6)');
      var total_col = current_row.children(':nth-child(7)');
      var multi_factor_col = current_row.children(':nth-child(8)');
      var pref_total_col = current_row.children(':nth-child(9)');
      var pref_price_col = current_row.children(':nth-child(10)');

      var costdata = new Object();
      costdata.line_number = current_line;
      costdata.note  = note_col.children(':first').val () ;
      costdata.cost_per_item = est_price_col.children(':nth-child(2)').val () ;
      costdata.quantity = quantity_col.children(':first').val () ;
      costdata.unit = unit_col.children(':nth-child(2)').val () ;
      costdata.cost_total = total_col.children(':nth-child(2)').val () ;
      costdata.multiplication_factor = multi_factor_col.children(':nth-child(2)').val () ;
      costdata.price_per_item = pref_total_col.children(':nth-child(2)').val () ;
      costdata.price_total = pref_price_col.children(':nth-child(2)').val () ;
      costdata.customer_id = current_customer;
      costdata.agency_id = current_agency;
      costdata.product_id = getValueSplit(product_col.children(':first').val (), 0) ;
      var jsonString= JSON.stringify(costdata);

      return jsonString;
    }

    function collectDataTableTop () {
      // Collect Value
      var cost_table = $("#est-table").children(':first');
      var current_row = cost_table.children(':nth-child(' +  (parseInt(current_line) + 2) + ')');

      // Estimate Cost Colunm
      var product_col = current_row.children(':nth-child(2)');
      var total_col = current_row.children(':nth-child(7)');
      var pref_total_col = current_row.children(':nth-child(9)');
      var pref_price_col = current_row.children(':nth-child(10)');

      // Calculating Data
      var total_cost = total_col.children(':nth-child(2)').val () ;

      var costdata = new Object();
      costdata.proposal_code = '';
      costdata.project_title  = $("#project_title").val() ;
      costdata.customer_id = $("#customer_id").val() ;
      costdata.employee_id = $("#employee_id").val() ;
      costdata.department_id = $("#department_id").val() ;
      costdata.item_id = getValueSplit(product_col.children(':first').val (), 0);
      costdata.est_total_cost = total_cost;
      costdata.est_total_selling_price = pref_price_col.children(':nth-child(2)').val () ;
      costdata.gross_profit = pref_price_col.children(':nth-child(2)').val () ;
      costdata.created_date = '';
      costdata.updated_date = '';
      costdata.product_id = getValueSplit(product_col.children(':first').val (), 0) ;
      var jsonString= JSON.stringify(costdata);

      return costdata;
    }

    // Sum All Init Price - 見積原価合計 = Sum (見積原価 - 計)
    // Count All est-total column Value
    function sumEstInitPrice () {
      var sumVal = 0;
      $("#est-table .est-total").each(function() {
        sumVal = parseInt(sumVal) + parseInt($(this).val());
      });
      return sumVal;
    }

    // 見積参考売価 - 掛け率
    function setMultiFactor (value) {
      $("#est-table .multi_factor").each(function() {
        $(this).val(value);

        // Change Sale Price along with new Multi Factor
        // 1. Estimate Cost Colunm
        var current_row = $( this ).parent().parent();
        var est_col = current_row.children(':nth-child(4)');
        var total_est_col = current_row.children(':nth-child(7)');
        var est_pref_col = current_row.children(':nth-child(9)');
        var sale_price_col = current_row.children(':nth-child(10)');

        var sale_price = parseInt(est_col.children(':nth-child(2)').val()) * value;
        var total_est = parseInt(total_est_col.children(':nth-child(2)').val()) * value;

        // Show Value
        est_pref_col.children(':first').val (formatPrice(total_est));
        sale_price_col.children(':first').val (formatPrice(sale_price));

        // Hidden Value
        est_pref_col.children(':nth-child(2)').val (total_est);
        sale_price_col.children(':nth-child(2)').val (sale_price);
      });
    }

    function createNewLine (element, isBelow) {
      // Inscrease 1 when create new Line
      maxItem++;
      // Add to total line
      $("#est-row-num").val(maxItem);


      var newLine = $(table + ' tr:last').clone();
      if (isBelow)
        $(newLine).insertAfter(element);
      else
        $(newLine).insertBefore(element);

      // Add Function to New Line
      newLine.find('.est-product').on("change", function(){ onChangeProduct (newLine.find('.est-product')); });
      newLine.find('.est-quantity').on("change", function(){ onChangeQuantity (newLine.find('.est-quantity')); });

      newLine.find('.add-btn-below').on("click", function(){ createNewLine (newLine, true); });
      newLine.find('.add-btn-above').on("click", function(){ createNewLine (newLine, false); });
      newLine.find('.remove-btn').on("click", function(){ removeLine (newLine); });

      // コピーした行の内容を編集（フォーム名とか、初期値とか）
      // Reset Default Value for new line
      $('td', newLine).each(function(){
        if ( $(this).children().length <= 0 ) {
          // do something
        }
  			else if($('select', this).length == 1) {
          resetNewValue ('select', this, '');
  			}
        else if ($('input[type = "text"]', this).length == 1) {
    			if($('input[type = "text"]', this).attr("name").indexOf('quantity') != -1){
            resetNewValue ('input[type = "text"]', this, '1');
          }
          else if($('input[type = "text"]', this).attr("name").indexOf('note') != -1){
            resetNewValue ('input[type = "text"]', this, '');
          }
          else if($('input[type = "hidden"]', this).attr("name").indexOf('unit') != -1){
            $('input[type = "text"]', this).val ('');
            resetNewValue ('input[type = "hidden"]', this, '');
          }
          else if($('input[type = "text"]', this).attr("name") == 'total'){
            resetNewValue ('input[type = "text"]', this, 0);
          }
          else if($('input[type = "hidden"]', this).attr("name").indexOf('multi_factor') != -1){
          	$('input[type = "text"]', this).val (multi_factor);
            resetNewValue ('input[type = "hidden"]', this, multi_factor);
          }
          else if($('input[type = "text"]', this).attr("name") == 'sale_total')
            resetNewValue ('input[type = "text"]', this, 0);
          else if($('input[type = "text"]', this).attr("name").indexOf('sale_per_item')  != -1)
            resetNewValue ('input[type = "text"]', this, 0);
          else if($('input[type = "text"]', this).attr("disabled") == 'disabled'){
            resetNewValue ('input[type = "hidden"]', this, 0);
            $('input[type = "text"]', this).val (0);
          }
        }
		  });
      // ------------

      arrangeNo (); // Count [No] Collum From 0 to Current Line
    }

    function removeLine (element) {
      var countLine =
      $(element).remove ();

      // Calculate again;
      calculatePrice ();

      arrangeNo (); // Count [No] Collum From 0 to Current Line
    }

    // Count Class line-no , rerange the Line Number
    function arrangeNo () {
      num = 0;
      $(".line-no").each(function() {
        var lineHtml = "<input type='hidden' name='line_num-" + num + "' value='" + num + "'/>"
        $(this).html(num + lineHtml);
        num++;
      });
    }

    function onChangeProduct (productOption) {
      if ($( productOption ).val () != '') {
        var estimate_cost = getValueSplit($( productOption ).val (), 1);

        // Estimate Cost Colunm
        var current_row = $( productOption ).parent().parent();
        var est_price_col = current_row.children(':nth-child(4)');
        var quantity_price_col = current_row.children(':nth-child(5)');
        var unit_col = current_row.children(':nth-child(6)');
        var total_cost_col = current_row.children(':nth-child(7)');
        var multi_factor_col = current_row.children(':nth-child(8)');
        var est_pref_col = current_row.children(':nth-child(9)');
        var sale_price_col = current_row.children(':nth-child(10)');

        // Calculate
        var quantity = parseInt(quantity_price_col.children(':first').val ());
        var total_est = parseInt(estimate_cost) * parseInt(quantity);
        var multi_factor = parseFloat(multi_factor_col.children(':first').val ());
        var sale_price = parseInt(estimate_cost * multi_factor);
        var unit = getValueSplit($( productOption ).val (), 2);

        // Show Value
        est_price_col.children(':first').val (formatPrice(estimate_cost));
        total_cost_col.children(':first').val (formatPrice(total_est));
        est_pref_col.children(':first').val (formatPrice(total_est * multi_factor));
        sale_price_col.children(':first').val (formatPrice(sale_price));
        unit_col.children(':first').val (unit);

        // Hidden Value
        est_price_col.children(':nth-child(2)').val (estimate_cost);
        total_cost_col.children(':nth-child(2)').val (total_est);
        est_pref_col.children(':nth-child(2)').val (total_est * multi_factor);
        sale_price_col.children(':nth-child(2)').val (sale_price);
        unit_col.children(':nth-child(2)').val (unit);

        // Top Table
        var top_total_est = parseInt(sumEstInitPrice());
        est_total_top.children(':nth-child(2)').val (formatPrice(top_total_est));
        est_sale_total_top.children(':nth-child(2)').val (formatPrice(top_total_est * multi_factor));
        gross_profit.children(':nth-child(2)').val (formatPrice((top_total_est * multi_factor) - top_total_est));

        // Hidden Value
        est_total_top.children(':nth-child(3)').val (top_total_est);
        est_sale_total_top.children(':nth-child(3)').val (top_total_est * multi_factor);
        gross_profit.children(':nth-child(3)').val ((top_total_est * multi_factor) - top_total_est);

      }
    }

    function onChangeQuantity (quantity) {
      if ($( quantity ).val () != '') {
        // Estimate Cost colunm
        var current_row = $( quantity ).parent().parent();
        var est_price_col = current_row.children(':nth-child(4)');
        var total_cost_col = current_row.children(':nth-child(7)');
        var multi_factor_col = current_row.children(':nth-child(8)');
        var est_pref_col = current_row.children(':nth-child(9)');
        var sale_price_col = current_row.children(':nth-child(10)');

        // Calculate
        var estimate_cost = est_price_col.children(':nth-child(2)').val ();
        var quantity = $( quantity ).val ();
        var total_est = parseInt(estimate_cost) * parseInt(quantity);
        var multi_factor = parseFloat(multi_factor_col.children(':first').val ());
        var sale_price = parseInt(est_price_col.children(':nth-child(2)').val()) * multi_factor;

        // Show Value
        total_cost_col.children(':first').val (formatPrice(total_est));
        est_pref_col.children(':first').val (formatPrice(total_est * multi_factor));
        sale_price_col.children(':first').val (formatPrice(sale_price));

        // Hidden Value
        total_cost_col.children(':nth-child(2)').val (total_est);
        est_pref_col.children(':nth-child(2)').val (total_est * multi_factor);
        sale_price_col.children(':nth-child(2)').val (sale_price);

        // Top Table
        var top_total_est = parseInt(sumEstInitPrice());
        est_total_top.children(':nth-child(2)').val (formatPrice(top_total_est));
        est_sale_total_top.children(':nth-child(2)').val (formatPrice(top_total_est * multi_factor));
        gross_profit.children(':nth-child(2)').val (formatPrice((top_total_est * multi_factor) - top_total_est));

        // Hidden Value
        est_total_top.children(':nth-child(3)').val (top_total_est);
        est_sale_total_top.children(':nth-child(3)').val (top_total_est * multi_factor);
        gross_profit.children(':nth-child(3)').val ((top_total_est * multi_factor) - top_total_est);

      }
    }

    function calculatePrice () {
      // Estimate Cost Colunm
      var total_est = parseInt(sumEstInitPrice());
      var total_est_sale = total_est * parseFloat(multi_factor);
      var gross_profit_val = (total_est * parseFloat(multi_factor)) - total_est;

      // Top Table
      est_total_top.children(':nth-child(2)').val (formatPrice(total_est));
      est_sale_total_top.children(':nth-child(2)').val (formatPrice(total_est_sale));
      gross_profit.children(':nth-child(2)').val (formatPrice(gross_profit_val));
      // Hidden Value
      est_total_top.children(':nth-child(3)').val (total_est);
      est_sale_total_top.children(':nth-child(3)').val (total_est_sale);
      gross_profit.children(':nth-child(3)').val (gross_profit_val);
    }

    function resetNewValue (element, line, value) {
      var obj = $(element, line)[0];
      $(obj).val(value);
      var newName = $(obj).attr('name').split ('-')[0] + '-' + maxItem;
      $(obj).attr('name', newName);
    }

    function createNewLineSale (element, isBelow) {
      // Inscrease 1 when create new Line
      maxItem++;
      // Add to total line
      $("#est-row-num").val(maxItem);


      var newLine = $(table_sale + ' tr:last').clone();
      if (isBelow)
        $(newLine).insertAfter(element);
      else
        $(newLine).insertBefore(element);

      // Add Function to New Line

      newLine.find('.add-btn-below').on("click", function(){ createNewLineSale (newLine, true); });
      newLine.find('.add-btn-above').on("click", function(){ createNewLineSale (newLine, false); });
      newLine.find('.remove-btn').on("click", function(){ removeLineSale (newLine); });

      // コピーした行の内容を編集（フォーム名とか、初期値とか）
      // Reset Default Value for new line
      $('td', newLine).each(function(){
        if ( $(this).children().length <= 0 ) {
          // do something
        }
        else if($('select', this).length == 1) {
          resetNewValue ('select', this, '');
        }
        else if ($('input[type = "text"]', this).length == 1) {
          if($('input[type = "text"]', this).attr("name").indexOf('quantity') != -1){
            resetNewValue ('input[type = "text"]', this, '1');
          }
          else if($('input[type = "text"]', this).attr("name").indexOf('note') != -1){
            resetNewValue ('input[type = "text"]', this, '');
          }
          else if($('input[type = "hidden"]', this).attr("name").indexOf('unit') != -1){
            $('input[type = "text"]', this).val ('');
            resetNewValue ('input[type = "hidden"]', this, '');
          }
          else if($('input[type = "text"]', this).attr("name") == 'total'){
            resetNewValue ('input[type = "text"]', this, 0);
          }
          else if($('input[type = "hidden"]', this).attr("name").indexOf('multi_factor') != -1){
            $('input[type = "text"]', this).val (multi_factor);
            resetNewValue ('input[type = "hidden"]', this, multi_factor);
          }
          else if($('input[type = "text"]', this).attr("name") == 'sale_total')
            resetNewValue ('input[type = "text"]', this, 0);
          else if($('input[type = "text"]', this).attr("name").indexOf('sale_per_item')  != -1)
            resetNewValue ('input[type = "text"]', this, 0);
          else if($('input[type = "text"]', this).attr("disabled") == 'disabled'){
            resetNewValue ('input[type = "hidden"]', this, 0);
            $('input[type = "text"]', this).val (0);
          }
        }
      });
      // ------------

      arrangeNo (); // Count [No] Collum From 0 to Current Line
    }

    function removeLineSale (element) {
      var countLine =
      $(element).remove ();
      arrangeNo (); // Count [No] Collum From 0 to Current Line
    }
});

function agency_check(){
  var check = document.getElementById("agency__check").checked;
  document.getElementById("agency").disabled = check;
}

// Filter data invisible or not

function filterInvisible()
  {
    var rex = new RegExp($('#filterText').val());
    if(rex =="/all/"){
      clearFilter();
    }else{
      $('.content').hide();
      $('.content').filter(function() {
      return rex.test($(this).text());
      }).show();
    }
  }
function clearFilter()
  {
    $('.filterText').val('');
    $('.content').show();
  }
// Live search

jQuery(document).ready(function(e) {
	var columnsToIndex = [0, 2];
	initLiveFilter(columnsToIndex)
});

function initLiveFilter(columnsToIndex) {
	var liveFilter = jQuery("#liveFilter");
	if (liveFilter.length > 0) {
		var liveFilterField = liveFilter.find("input.liveFilterInput"),
			liveFilterGrid = liveFilter.find("table.liveFilterList"),
			liveFilterGridRows = liveFilterGrid.find("tr:gt(0)"),
			liveFilterClear = liveFilter.find(".clearField"),
			liveFilterNoResults = liveFilterGrid.prev(),
			liveFilterDataArray = new Array(),
			characterValidationArray = [8, 45, 46],
			characterExclusionArray = [13, 20, 27, 33, 34, 37, 39, 35, 36, 16, 17, 18, 144, 145];
		if (columnsToIndex.length > 1) {
			for (col = 0; col <= columnsToIndex.length - 1; col++) {
				liveFilterGridRows.children("td:nth-child(" + columnsToIndex[col] + ")").each(function(i) {
					liveFilterDataArray[liveFilterDataArray.length++] = jQuery(this).text()
				})
			}
		} else {
			liveFilterGridRows.children("td:first-child").each(function(i) {
				liveFilterDataArray[i] = jQuery(this).text()
			})
		}
		liveFilterField.on("keyup", function(key) {
			if (jQuery.inArray(key.keyCode, characterExclusionArray) == -1) {
				var liveFilterValue = liveFilterField.val();
				if (!liveFilterField.hasClass("default")) {
					if (liveFilterValue != "") {
						liveFilterClear.fadeIn(300);
						rowsToShow = new Array();
						var currentRow = 0;
						for (var i = 0; i < liveFilterDataArray.length; i += 1) {
							RE = eval("/" + liveFilterValue + "/i");
							if (liveFilterDataArray[i].match(RE)) {
								rowsToShow.push(currentRow)
							}
							if (currentRow < liveFilterGridRows.length - 1) {
								currentRow++
							} else {
								currentRow = 0
							}
						}
						if (rowsToShow.length > 0) {
							liveFilterGrid.show();
							liveFilterGridRows.hide();
							if (liveFilterNoResults.is(":visible")) {
								liveFilterNoResults.slideUp(150)
							}
							for (var i = 0; i < rowsToShow.length; i += 1) {
								jQuery(liveFilterGridRows.get(rowsToShow[i])).show()
							}
						} else {
							liveFilterGrid.hide();
							if (liveFilterNoResults.is(":visible") && liveFilterNoResults.queue().length == 0 && jQuery.inArray(key.keyCode, characterValidationArray) == -1) {
								liveFilterNoResults.effect('shake', {
									times: 3,
									distance: 3
								}, 100)
							} else {
								liveFilterNoResults.slideDown(150)
							}
						}
					} else {
						clearField()
					}
				}
			}
		});
		liveFilterField.on("focus", function() {
			if (liveFilterField.hasClass("default")) {
				liveFilterField.val("").removeClass("default")
			}
			return !1
		});
		liveFilterClear.on("click", function() {
			clearField();
			return !1
		});

		function clearField() {
			liveFilterField.val('');
			liveFilterClear.fadeOut(300);
			liveFilterNoResults.slideUp(300);
			liveFilterGridRows.show();
			liveFilterGrid.show();
			filterInvisible()
		}
	}
}
