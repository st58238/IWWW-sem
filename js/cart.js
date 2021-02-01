'use strict';

function updatePrice() {
	let sum = 0;
	let count = 0;
	let inputs = document.querySelectorAll('.input.input-number').forEach(function(i){
		sum += parseFloat(i.value) * parseFloat(i.getAttribute('data-price'));
		count += parseInt(i.value);
	});
	sum = Math.round(sum * 100) / 100;
	sum = '' + sum;
	sum = sum.replace("\.", "\,");

	if (sum.indexOf(',') < 0) {
		sum += ',00';
	}

	if ((sum.substr(sum.indexOf(','))).length == 1) {
		sum += '00';
	} else if ((sum.substr(sum.indexOf(','))).length == 2) {
		sum += '0';
	}

	document.querySelector('.cart-sum-count').textContent = 'Počet položek: ' + count;
	document.querySelector('.cart-sum-price').textContent = 'Cena celkem: ' + sum + ' Kč';
}
