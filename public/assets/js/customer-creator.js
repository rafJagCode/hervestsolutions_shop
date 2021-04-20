const generatePassword = ()=>{
	const password = $('#signup-password');
	const confirm = $('#signup-confirm');
	$.ajax({ url:'/generate-password', success: function(data){
		password.val(data);
		confirm.val(data);
	}});
}