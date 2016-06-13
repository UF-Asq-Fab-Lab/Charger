$(document).ready(function() {
	if(typeof ProcessLister !== 'undefined' && ProcessLister !== null){
		var tableObserver = new MutationObserver(insertCheckboxes);
	  var form = document.getElementById("ProcessListerResults");
	  var options = {childList: true, subtree: true};
		var selectAllCheckbox = $("<input id='lab_charger_select_all' type='checkbox'/>");
		var selectAllLabel = $("<label id='lab_charger_select_all_label'>Select All</label>");
		selectAllCheckbox.click(function(){
			if($(this).attr("checked")){
				$("#lab_charger_select_all_label").text('Deselect All');
				$(".lab_charger_selector_checkbox").attr("checked", true).change();
			} else {
				$("#lab_charger_select_all_label").text('Select All');
				$(".lab_charger_selector_checkbox").attr("checked", false).change();
			}

		});
		var labChargeControl = $("<div id='ProcessLabChargeControl'></div>");
		labChargeControl.append(selectAllLabel, selectAllCheckbox);
		$("#ProcessListerResults").before(labChargeControl);

		ProcessLister.submit = function(url) {
			if(ProcessLister.inTimeout) clearTimeout(ProcessLister.inTimeout);
			ProcessLister.inTimeout = setTimeout(function() {
				tableObserver.observe(form, options);
				ProcessLister._submit(url);
			}, 250);
		};

		var duplicateButton = $("#ProcessLabChargeDuplicateButton");
		duplicateButton.attr("disabled", true).addClass("ui-state-disabled");

		var renderButton = $("#ProcessLabChargeRenderButton");
		renderButton.attr("disabled", true).addClass("ui-state-disabled");
		renderButton.click(function () {
			var data = {
				ids : $("#ProcessLabChargeRecordsIds").attr('value')
			};
			$("#ProcessLabChargeRecordsSpinner").css('display', 'inline');
			$.ajax({
				url: "./render",
				type: 'GET',
				data: data,
				success: updateRecordText,
				error: recordError
			});
			return false;
		});
	}

  function insertCheckboxes (mutations) {
    var table = $("#ProcessListerTable > table > tbody");
    if(table.length){
      table.children().each(function(i, element){

        if(!$(element).children().has(".lab_charger_selector_checkbox_td").length){
          var a = $(element).children().first();
					var id = $(a).children().first().attr('id');
					if(id){
						id = id.slice(4);
	          var boxTd = $("<td class='lab_charger_selector_checkbox_td'></td>");
	          var box = $("<input type='checkbox' class='lab_charger_selector_checkbox'/>");
	          box.attr('id', id);
						box.change(updateRenderInputs);
	          boxTd.append(box);
	          $(element).prepend(boxTd);
					}
        }

      });
    }

		var th = $("<th>Select</th>");
		$("#ProcessListerTable > table > thead > tr").prepend(th);

		tableObserver.disconnect();
  };

	function updateRenderInputs () {
		var checked = $(".lab_charger_selector_checkbox:checked");
		// update buttons
		if( checked.length > 0 ){

			$("#ProcessLabChargeRenderButton")
			.attr("disabled", null)
			.removeClass("ui-state-disabled");

			$("#ProcessLabChargeDuplicateButton")
			.attr("disabled", null)
			.removeClass("ui-state-disabled");

			$.each(checked, function(i, box){
				var sent = $(box).parent().nextAll().has("i").children("i");
				console.log(sent.attr("class"));
				if(sent.attr("class") === 'fa fa-check-square-o'){
					$("#ProcessLabChargeRenderButton")
					.attr("disabled", true)
					.addClass("ui-state-disabled");
				}
			});

		} else {

			$("#ProcessLabChargeRenderButton")
			.attr("disabled", true)
			.addClass("ui-state-disabled");

			$("#ProcessLabChargeDuplicateButton")
			.attr("disabled", true)
			.addClass("ui-state-disabled");

		}
		// update ids field
		var idsInput = $("#ProcessLabChargeRecordsIds");
		var dupIdsInput = $("#ProcessLabChargeDuplicateIds");
		if( checked.length > 0 ) {
			var val = "";
			checked.each(function(i, element){
				val+="+"+element.id;
			});
			idsInput.attr('value', val);
			dupIdsInput.attr('value', val);
		} else {
			idsInput.attr('value', "");
			dupIdsInput.attr('value', "");
		}
	};

	function updateRecordText ( data ) {
		console.log(data);
		$("#ProcessLabChargeRecordsSpinner").css('display', 'none');
		$("#ProcessLabChargeRecordsForm").css('display', 'block');
		$("#ProcessLabChargeRecordsText").text(data);
	};

	function recordError ( error ) {
		$("#ProcessLabChargeRecordsSpinner").css('display', 'none');
		console.error(error);
	};

});
