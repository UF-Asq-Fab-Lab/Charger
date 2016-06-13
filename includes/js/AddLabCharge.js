$(document).ready(function(){
  var checkUfidTimer = null;
  var ajaxUrl = '';//$("form[id='ProcessPageAdd']").attr('data-ajax-url');
  var ufidExists = $("<div class='lab_charge_ufid_exists'></div>");
  var ufidDNE = $("<div class='lab_charge_ufid_dne'>That user does not exist. Please ensure you have entered the UFID correctly.</div>");
  var ufidInput = $("input[name='lab_charge_ufid']");
  ufidInput.before(ufidExists, ufidDNE);
  var now = new Date(Date.now());
  var minutes = now.getMinutes().toString();
  if(minutes.length < 2){
    minutes = "0"+minutes;
  }
  var date = (now.getMonth()+1)+"/"+now.getDate()+"/"+now.getFullYear()+" "+now.getHours()+":"+minutes;
  var titleData = {
    name : '<Name>',
    chargeItem : '<ChargeItem>',
    referenceNumber : $("#Inputfield_lab_charge_reference_number").val(),
    date : date
  };
  autofillTitle();




  function autofillTitle (){
    var title = titleData.name+" "+titleData.chargeItem;
    title += " "+titleData.referenceNumber+" "+titleData.date;
    $("#Inputfield_title").val(title);
    $("#Inputfield_title").keyup();
  }

  $("input[name='lab_charge_item']").click(function(){
    var idArray = $(this).attr('id').split("_");
    var id = idArray[idArray.length-1];
    console.dir(idArray);
    $.ajax({
      url: ajaxUrl,
      method: "GET",
      data: {lciid:id},
      success: function success (data) {
        var json = {};
        try{
          json = JSON.parse(data);
        } catch (e) {
          console.error(e);
        } finally {
          $("input[name='lab_charge_amount']").val(json.defaultAmount);
          $("input[name='lab_charge_due_date']").val(json.defaultDueDate);
          titleData.chargeItem = json.itemName;
          autofillTitle();
        }
      },
      error: function error (data) {
        console.error(data);
      }
    });
  });

  $("input[name='lab_charge_ufid']").keyup(function(e) {
		if(checkUfidTimer) clearTimeout(checkUfidTimer);
		checkUfidTimer = setTimeout(function() { checkUfid(); }, 250);
	});

  function checkUfid () {
    var ufid = ufidInput.val();
    if(!ufid.length){
      ufidExists.toggle(false);
      ufidDNE.toggle(false);
      return;
    }
    $.ajax({
      url: ajaxUrl,
      method: "GET",
      data: {check_ufid:ufid},
      success: function success (data) {
        var json = {};
        try{
          json = JSON.parse(data);
        } catch (e) {
          console.error(e);
        } finally {
          if(json.exists){
            ufidExists.text("Name: "+json.name+" Email: "+json.email+" Roles: "+json.roles);
            ufidExists.toggle(true);
            ufidDNE.toggle(false);
            titleData.name = json.name
          } else {
            ufidExists.toggle(false);
            ufidDNE.toggle(true);
            titleData.name = '<Name>';
          }
          autofillTitle();
        }
      },
      error: function error (data) {
        console.error(data);
      }
    })
  };

  var fromUser = location.search.match(/from_user=(\d+)/)[1];
  $("input[name='lab_charge_ufid']").val(fromUser).keyup();

});
