$(document).ready(function() {
	var tableObserver = new MutationObserver(insertCheckboxes);
  var form = document.getElementById("ProcessListerResults");
  var options = {childList: true, subtree: true};

  function insertCheckboxes (mutations) {
    var table = $("#ProcessListerTable > table > tbody");
    if(table.length){
      table.children().each(function(i, element){

        if(!$(element).children().has(".lab_charger_selector_checkbox_td").length){
          var a = $(element).children().first();
					var id = $(a).children().first().attr('id').slice(4);
          var boxTd = $("<td class='lab_charger_selector_checkbox_td'></td>");
          var box = $("<input type='checkbox' class='lab_charger_selector_checkbox'/>");
          box.attr('id', id);
					box.change(updateRenderInputs);
          boxTd.append(box);
          $(element).prepend(boxTd);
        }

      });
    }

		var th = $("<th>Select</th>");
		$("#ProcessListerTable > table > thead > tr").prepend(th);

		tableObserver.disconnect();
  };

	function updateRenderInputs () {
		var checked = $(".lab_charger_selector_checkbox:checked");
		// update button
		if( checked.length > 0 ){
			$("#ProcessLabChargeRenderButton")
			.attr("disabled", null)
			.removeClass("ui-state-disabled");
		} else {
			$("#ProcessLabChargeRenderButton")
			.attr("disabled", true)
			.addClass("ui-state-disabled");
		}
		// update ids field
		var idsInput = $("#ProcessLabChargeRecordsIds");
		if( checked.length > 0 ) {
			var val = "";
			checked.each(function(i, element){
				val+="+"+element.id;
			});
			idsInput.attr('value', val);
		} else {
			idsInput.attr('value', "");
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

	ProcessLister.submit = function(url) {
		if(ProcessLister.inTimeout) clearTimeout(ProcessLister.inTimeout);
		ProcessLister.inTimeout = setTimeout(function() {
			tableObserver.observe(form, options);
			ProcessLister._submit(url);
		}, 250);
	};

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

});