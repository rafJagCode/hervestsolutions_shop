const logout = () => {
	let date = new Date().toGMTString();
	let cookieName = 'X-AUTH-TOKEN';
	let domain = 'localhost';
	document.cookie = `${cookieName}= ;expires = ${date};domain=${domain};path=/`;
}