$(document).ready(function(){
  $("input[name='lab_charge_item']").click(function(){
    var ajaxUrl = $(this).attr('data-ajax-url');
    var idArray = $(this).attr('id').split("_");
    var id = idArray[idArray.length-1];
    console.dir(idArray);
    $.ajax({
      url: ajaxUrl,
      method: "GET",
      data: {lciid:id},
      success: function success (data) {
        var json = JSON.parse(data);
        console.dir(json);
        $("input[name='lab_charge_amount']").val(json.defaultAmount);
        $("input[name='lab_charge_due_date']").val(json.defaultDueDate);
      },
      error: function error (data) {
        console.error(data);
      }
    });
  });
});
