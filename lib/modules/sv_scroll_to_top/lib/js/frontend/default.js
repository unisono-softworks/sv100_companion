document.querySelector('#sv100_companion_sv_scroll_to_top').addEventListener('click', function() {
	document.querySelector('html').scrollIntoView({
		behavior: 'smooth'
	});
});

document.addEventListener('scroll', function() {
    if ( window.innerWidth > 799 ) {
		if ( window.scrollY > window.innerHeight ) {
			document.querySelector('#sv100_companion_sv_scroll_to_top').classList.add('show')
		} else {
			document.querySelector('#sv100_companion_sv_scroll_to_top').classList.remove('show')
		}
    }
});