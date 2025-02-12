window.addEventListener('load', function() {

	// images
	const images = document.querySelectorAll('a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".gif"], a[href*=".webp"], a[href*=".svg"]');
	images.forEach(element =>
		element.addEventListener("click", function(event) {
			if(element.classList.contains('no_lightbox')){ return; }
			event.preventDefault();
			basicLightbox.create('<img src="'+this.getAttribute("href")+'">').show();
		}
	));

	// videos
	const videos = document.querySelectorAll('a[href*=".mp4"]');
	videos.forEach(element =>
		element.addEventListener("click", function(event) {
			if(element.classList.contains('no_lightbox')){ return; }
			event.preventDefault();
			basicLightbox.create('<video controls autoplay playsinline><source src="'+this.getAttribute("href")+'" type="video/mp4"></video>').show();
		}
	));

	// HTML
	const html = document.querySelectorAll('a[href*="#lightbox_"]');
	html.forEach(element =>
		element.addEventListener("click", function(event) {
			if(element.classList.contains('no_lightbox')){ return; }
			event.preventDefault();
			let el = document.querySelector(this.getAttribute("href"));
			if(el){
				basicLightbox.create(el.innerHTML).show();
			}
		}
	));
});