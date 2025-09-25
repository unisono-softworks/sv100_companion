document.addEventListener('DOMContentLoaded', () => {
	const headings = [...document.querySelectorAll('#rank-math-faq .rank-math-list-item')];
	
	headings.forEach((heading) => {
		heading.setAttribute('aria-expanded', 'false');
		
		heading.addEventListener('click', (e) => {
			// if click originated inside the answer, ignore it
			if (e.target.closest('.rank-math-answer')) return;
			
			const expanded = heading.getAttribute('aria-expanded') === 'true';
			headings.forEach((elem) => elem.setAttribute('aria-expanded', 'false'));
			heading.setAttribute('aria-expanded', String(!expanded));
		});
	});
});
