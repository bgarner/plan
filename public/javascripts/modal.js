
var modal;
var close;

$( ".openModal" ).on( "click", function() {
	modal = $(this).attr("modal");
	$("#"+modal).css("display","block");
});

$(".close").on( "click", function() {
	$("#"+modal).css("display","none");
});

window.onclick = function(event) {
  if (event.target == modal) {
    $("#"+modal).css("display","none");
  }
}
