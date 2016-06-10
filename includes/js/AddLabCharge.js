$(document).ready(function(){
  var checkUfidTimer = null;
  var ajaxUrl = '';//$("form[id='ProcessPageAdd']").attr('data-ajax-url');
  var ufidExists = $("<div class='lab_charge_ufid_exists'></div>");
  var ufidDNE = $("<div class='lab_charge_ufid_dne'>That user does not exist. Please ensure you have entered the UFID correctly.</div>");
  var ufidInput = $("input[name='lab_charge_ufid']");
  ufidInput.before(ufidExists, ufidDNE);

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
          } else {
            ufidExists.toggle(false);
            ufidDNE.toggle(true);
          }
        }
      },
      error: function error (data) {
        console.error(data);
      }
    })
  }

});
