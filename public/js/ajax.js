// To be used in other JS files
/**
 * Receives a dict and returns the string equivalent of the data
 * @param data dict with data to be processed
 * @returns {string|null}
 */
function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

/**
 * Sends a Ajax request
 * @param method {string} 'get', 'post', 'put', 'patch', 'delete'
 * @param url {string} The url of the request: '/api/smth'
 * @param data {object} A dictionary with the data to send
 * @param handler {function} the callback function
 * @param async {boolean} Defaults to true. Boolean true if the request is to be made asynchronous
 */
function sendAjaxRequest(method, url, data, handler, async = true) {
    let request = new XMLHttpRequest();

    request.open(method, url, async);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
}


/*
Original AJAX function

function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}
*/
