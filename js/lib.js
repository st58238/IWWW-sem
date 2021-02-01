'use strict';

/**
* Jádro převzato z:
* stackoverflow.com: How do i promisify native XHR.
* https://stackoverflow.com/questions/30008114/
*/
function request(method, url, payload) {
	return new Promise(function (resolve, reject) {
		let http = new XMLHttpRequest();
		let result = '';

		if (!(method.toUpperCase() == 'POST' || method.toUpperCase() == 'GET')) {
			reject({
				status: -1,
				statusText: 'Unsupported method at request function: ' + method.toUpperCase()
			});
			return;
		}

		if (payload === null) {
			payload = '';
		}

		http.open(method.toUpperCase(), url, true);
		http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

		http.onload = function() {
			if (http.readyState == 4 && http.status >= 200 && http.status < 300) {
				resolve(http.response);
			} else {
				reject({
					status: this.status,
					statusText: http.statusText
				});
			}
		};

		http.onerror = function() {
			reject({
				status: this.status,
				statusText: http.statusText
			});
		}

		http.send(payload);
	});
}
