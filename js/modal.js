'use strict';

document.querySelectorAll('.modal').forEach(function(m){
	m.addEventListener('click', function(e) {
		if (e.target.id.includes('modalbox')) {
			let m = document.querySelectorAll('.modal').forEach(function(r) {
				r.style.display = 'none';
			});
		}
	});
});