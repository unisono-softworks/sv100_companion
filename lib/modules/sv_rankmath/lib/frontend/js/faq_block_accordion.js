document.addEventListener('DOMContentLoaded', () => {
	const headings = [...document.querySelectorAll('#rank-math-faq .rank-math-list-item')];
	
	headings.forEach((heading) => {
		heading.setAttribute('aria-expanded', 'false');
		heading.addEventListener('click', () => {
			const expanded = heading.getAttribute('aria-expanded') === 'true';
			headings.forEach((elem) => elem.setAttribute('aria-expanded', 'false'));
			heading.setAttribute('aria-expanded', String(!expanded));
		});
	});
});