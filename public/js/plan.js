$(document).off("keydown");

window.onload = function() { 
	$('textarea#plan').keyup(function() {
  	updateStatus("typing");
  });    
};

$('a.load-plan').click(function() {
	$('a.load-plan').css("font-weight", "normal");
	$(this).css("font-weight", "bold");
	var plan_id = $(this).attr("plan-id");
	var plan_date = $(this).attr("plan-date");
	var plan = fetchPlan(plan_id, plan_date);
});

$( ".lightbulb" ).on( "click", function() {
	var setdarkmode = $(this).data("darkmode");
	var user_id = $('#current_user_id').val();
	console.log("updating with these preferences, user: " + user_id + ", setting to: " + setdarkmode);

	// swap the classes, reset the button to now do the opposite
	if(setdarkmode == 1){
		$( "body" ).addClass( "dark" );
		$( ".lightbulb" ).data("darkmode", 0);
	} else {
		$( "body" ).removeClass( "dark" );	
		$( ".lightbulb" ).data("darkmode", 1);
	}	

	updatePref(user_id, setdarkmode);
});

//darkmode switch
const updatePref = (user_id, darkmode) => {
	axios({
	  method: 'post',
	  url: '/api/v1/prefs/set',
	  data: {
	    user_id: user_id,
	    darkmode: darkmode
	  }
	})
	.then(function (response) {
	  //set the button to now to the opposite
		console.log("preference set to: " + darkmode);
	})
	.catch(function (error) {
	  console.log(error);
	})
};

const updateStatus = (status) => {
	switch(status) {
		case "typing":
			$(".save_status").text("...changes...");
			break;

		case "saved":
			$(".save_status").text("Saved!");
			break;

		case "oops":
			$(".save_status").text("Something went wrong :(");
			break;			

		default:
			$(".save_status").text("");
			break;
	}
};

const fetchPlan = (plan_id, plan_date) => {
	axios({
	  method: 'post',
	  url: '/api/v1/plan/show',
	  data: {
	    plan_id: plan_id 
	  }
	})
	.then(function (response) {
		$("#current_plan_id").val(response.data[0].plan_id);
		$("textarea#plan").val(response.data[0].plan);
		$("#today").text(plan_date);
	})
	.catch(function (error) {
	  console.log(error);
	})
	.then(function () {
	  console.log("fetched the plan: "+ plan_id +" ...done!");
	})
};

//this is a brand new plan... ie - there is no plan saved for today, the plan_id field is empty
const savePlan = (user_id, plan) => {
	axios({
	  method: 'post',
	  url: '/api/v1/plan/new',
	  data: {
	  	user_id: user_id,
	    plan: plan
	  }
	})
	.then(function (response) {
//		console.log("new plan id: " + response.data);
	  $("#current_plan_id").val(response.data);
	  $("#todays_plan_link").attr("plan-id", response.data);
	  updateStatus("saved");
	})
	.catch(function (error) {
//	  console.log(error);
	  updateStatus("oops");
	})
	.then(function () {
//	  console.log("new plan saved ...done!");
	})	
};

//push the current plan to the db
const updatePlan = (plan_id, plan) => {
	axios({
	  method: 'post',
	  url: '/api/v1/plan/update',
	  data: {
	  	plan_id: plan_id,
	    plan: plan
	  }
	})
	.then(function (response) {
	  // console.log(response);
	  updateStatus("saved");
	})
	.catch(function (error) {
	  // console.log(error);
	  updateStatus("oops");
	})
	.then(function () {
	  // console.log("plan updated ...done!");
	})	
};

setInterval(function(){ 
		var plan_id = $("#current_plan_id").val();
		var plan = $('textarea#plan').val();
		var user_id = $('#current_user_id').val();
		
		// if (!plan) {
		// 	console.log("no plan yet...");
		// 	return;
		// }

		if( plan_id === "") {
			savePlan(user_id, plan);
		} else {
			updatePlan(plan_id, plan)
		}

}, 3000);


