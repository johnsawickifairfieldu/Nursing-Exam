
$(document).ready(function(){
// code to get all records from table via select box
$("#exam").change(function() {
var id = $(this).find(":selected").val();
var dataString = 'exam_id='+ id;
$.ajax({
url: 'QuestionsDisplay.php',
dataType: "json",
data: dataString,
cache: false,
success: function(employeeData) {
if(employeeData) {
$("#heading").show();
$("#no_records").hide();
$("#question_text").text(employeeData.question_text);
$("#records").show();
} else {
$("#heading").hide();
$("#records").hide();
$("#no_records").show();
}
}
});
})
});
