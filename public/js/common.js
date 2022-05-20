const apiURL = "http://localhost:8000/api/v1/";
const baseURL = "http://localhost/";


const notification = (type, title, message) => {
	return toastr[type](message, title);
};

let button = document.querySelector(".submit");


// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });

// when ajax has started
$(document).ajaxStart(function () {
	button != undefined ? (button.disabled = true) : null;
});

// when ajax has sent the request
$(document).ajaxSend(function (e, xhr, opt) {
	button != undefined ? (button.disabled = true) : null;
});

// ajax received a response
$(document).ajaxComplete(function () {
	button != undefined ? (button.disabled = false) : null;
});

// ajax has error
$(document).ajaxError(function () {
	button != undefined ? (button.disabled = false) : null;
});

// trim the input fields except file, select, textarea
trimInputFields = () => {
	var allInputs = $("input:not(:file())");
	allInputs.each(function () {
		$(this).val($.trim($(this).val()));
	});
};

formReset = (action = "hide") => {
	$("html, body").animate({ scrollTop: 0 }, "slow");

	if (action == "hide") {
		// hide and clear form
		$("#form_id")[0].reset();
		$("#div_form").modal('hide');
		$("#hidden_id").val("");

	} else if (action == "show") {
		// show
		$("#div_form").modal('show');
		$("#form_id")[0].reset();
		$("#hidden_id").val("");

	
		$(".submit").show();
		$("#form_id input, select, textarea").prop("disabled", false);
		$("#form_id button").prop("disabled", false);
		$("#photo_path_placeholder").attr(
			"src",
			"https://avatars.dicebear.com/api/bottts/smile.svg"
		);
	}
};