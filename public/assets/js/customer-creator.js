const generatePassword = ()=>{
	const password = $('#signup-password');
	const confirm = $('#signup-confirm');
	$.ajax({ url:'/generate-password', success: function(data){
		password.val(data);
		confirm.val(data);
	}});
}
const changePasswordVisibility = ()=>{
	const eyeIcon = $('.password-eye-icon');
	const input = $(eyeIcon.attr('toggle'));
	eyeIcon.toggleClass("fa-eye fa-eye-slash");
	input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password');
}