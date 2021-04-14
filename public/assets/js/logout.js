const logout = () => {
	let cookieName = 'X-AUTH-TOKEN';
	let domain = 'redparts.test';
	Cookies.set(cookieName, '', { expires: -1, path: '/', domain: domain, sameSite: 'lax'});
}