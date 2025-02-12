window.addEventListener('load', function() {
	// Define the offset from the localized variable or use 100 if empty
	let offset = js_sv100_companion_sv_smooth_scrolling_scripts_frontend.offset || "100";
	offset = parseInt(offset, 10); // Convert offset to number
	
	// Select all links with hashes
	const links = document.querySelectorAll('a[href*="#"]:not([href="#"]):not([href="#0"]):not([data-toggle]):not([target="_blank"]):not([href*="#sv_toggle_"]):not([class^="tabs"]):not([class*="tab"])');
	
	links.forEach(link =>
		link.addEventListener("click", function(event) {
			// On-page links
			if (
				location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '')
				&&
				location.hostname === this.hostname
			){
				// Does a scroll target exist?
				if (this.hash.length && document.getElementById(this.hash.replace('#', '')) && document.getElementById(this.hash.replace('#', '')).offsetTop > 0){
					// Only prevent default if animation is actually gonna happen
					event.preventDefault();
					const element = document.getElementById(this.hash.replace('#', ''));
					sv100_companion_smooth_scrolling_scroll_to(element, offset);
					history.replaceState(null, null, ' ');
				}
			}
		}));
});

document.addEventListener("DOMContentLoaded", function() {
	sv100_companion_smooth_scrolling_on_pageload();
});

function sv100_companion_smooth_scrolling_on_pageload(){
	// *only* if we have anchor on the URL
	if(window.location.hash){
		// smooth scroll to the anchor id
		const offset = js_sv100_companion_sv_smooth_scrolling_scripts_frontend.offset || "100";
		sv100_companion_smooth_scrolling_scroll_to(document.getElementById(window.location.hash.replace('#', '')), parseInt(offset, 10));
	}
}

function sv100_companion_smooth_scrolling_scroll_to(element, offset){
	if(element) {
		let y = element.getBoundingClientRect().top + window.scrollY;
		
		// calculate offset by sticky header
		const header = document.querySelector('header');
		if(header !== null){
			if (window.getComputedStyle(header).position === 'fixed' || window.getComputedStyle(header).position === 'sticky') {
				y -= header.offsetHeight;
			}
		}
		
		history.replaceState(null, null, ' ');
		
		window.scrollTo({
			top: y - offset,
			behavior: 'smooth'
		});
	}
}
