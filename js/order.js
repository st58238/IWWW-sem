'use strict';

function radioSwitch() {
	let cp = document.querySelector('#delivery-cp');
	let ppl = document.querySelector('#delivery-ppl');
	let os = document.querySelector('#delivery-os');
	let dob = document.querySelector('#payment-cp');
	let bank = document.querySelector('#payment-bank');
	let prev = document.querySelector('#payment-os');

	if (cp.checked || ppl.checked) {
		dob.removeAttribute('disabled');
		bank.removeAttribute('disabled');
		prev.setAttribute('disabled', 'disabled');
		if (prev.checked) {
			dob.checked = true;
		}
	} else if (os.checked) {
		dob.setAttribute('disabled', 'disabled');
		bank.removeAttribute('disabled');
		prev.removeAttribute('disabled');
		if (dob.checked) {
			prev.checked = true;
		}
	}
}


function checkForm() {
	/**
	* emailregex.com: Javascript regual expression for email
	* https://emailregex.com/
	*/
	let ereg = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);

	let email = document.querySelector('input[name="email"]');

	return ereg.test(email.value);
}