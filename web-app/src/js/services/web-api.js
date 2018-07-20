/**
 * Created by alberto on 12/26/17.
 */

import ObjectUtils from "../utils/object-utils";

/**
 * METHOD get const
 * @type {string}
 */
export const METHOD_GET = 'GET';

/**
 * METHOD post const
 * @type {string}
 */
export const METHOD_POST = 'POST';

/**
 * METHOD put const
 * @type {string}
 */
export const METHOD_PUT = 'PUT';

/**
 * METHOD delete const
 * @type {string}
 */
export const METHOD_DELETE = 'DELETE';

/**
 * HEADER Content-Type const wrapper
 * @type {string}
 */
export const HEADER_CONTENT_TYPE = 'Content-Type';

/**
 * HEADER Accept const wrapper
 * @type {string}
 */
export const HEADER_ACCEPT = 'Accept';

/**
 * HEADER value 'application/x-www-form-urlencoded' for HEADER_CONTENT_TYPE
 * @type {string}
 */
export const CONTENT_TYPE_X_WWW_FORM_URLENCODED = 'application/x-www-form-urlencoded';

/**
 * HEADER value 'application/json' for HEADER_CONTENT_TYPE
 * @type {string}
 */
export const CONTENT_TYPE_JSON = 'application/json';

/**
 * HEADER value 'application/json' for HEADER_ACCEPT
 * @type {string}
 */
export const ACCEPT_JSON = 'application/json';

export const RESULTS = {
  NotFound: -1,
  InvalidParams: -2,
  MultipleResultsFound: -3,
};

/**
 * WebApi class for rest api support
 * @class
 */
export default class WebApi {
  /**
   * Constructor for WebApi class
   * @param {string} uri
   * @param {Object} data
   * @param {Object} headers
   */
  constructor(uri = '', data = {}, headers = {}) {

    /** @name WebApi#request */
    /** @type Request */
    /** @default null */
    this.request = null;

    /** @name WebApi#uri */
    /** @type string */
    /** @default '' */
    this.uri = uri;

    /** @name WebApi#dataObj */
    /** @type Object */
    this.dataObj = data;

    /** @name WebApi#headersObj */
    /** @type Object */
    this.headersObj = headers;

    /** @name WebApi#converter */
    /** @type Function */
    /** @default null */
    this.converter = null;
  }

  /**
   * Wraper for GET method request
   * @returns {Promise}
   */
  get() {
    // request generation
    this.request = this.makeRequest(this.uri, METHOD_GET, this.dataObj, this.headersObj);

    // request execution
    return WebApi.execRequest(this.request, this.converter);
  }

  /**
   * Wraper for POST method request
   * @returns {Promise}
   */
  post() {
    // request generation
    this.request = this.makeRequest(this.uri, METHOD_POST, this.dataObj, this.headersObj);

    // request execution
    return WebApi.execRequest(this.request, this.converter);
  }

  /**
   * Wraper for PUT method request
   * @returns {Promise}
   */
  put() {
    // request generation
    this.request = this.makeRequest(this.uri, METHOD_PUT, this.dataObj, this.headersObj);

    // request execution
    return WebApi.execRequest(this.request, this.converter);
  }

  /**
   * Wraper for DELETE method request
   * @returns {Promise}
   */
  deleteRequest() {
    // request generation
    this.request = this.makeRequest(this.uri, METHOD_DELETE, this.dataObj, this.headersObj);

    // request execution
    return WebApi.execRequest(this.request, this.converter);
  }

  /**
   * Make the request object with the data and headers provided by the user
   * @param {string} uri
   * @param {string} method
   * @param {Object} dataObj
   * @param {Object} headersObj
   * @returns {Request}
   */
  makeRequest(uri = '', method = '', dataObj = {}, headersObj = {}) {
    let body = null;

    // if exists, process the data object depending the method provided (GET, POST)
    if (!ObjectUtils.isEmtpy(dataObj)) {
      if (method === METHOD_GET) {
        // prepare query string params
        let params = this.prepareQueryStringParams(dataObj);

        // if params exists, concat it to the query string of the uri
        if (!!params) {
          uri = `${uri}?${params}`;
        }
      } else if (method === METHOD_POST || method === METHOD_PUT) {
        // prepare body of request with query string params
        if (HEADER_CONTENT_TYPE in headersObj && headersObj[HEADER_CONTENT_TYPE] === CONTENT_TYPE_JSON) {
          body = JSON.stringify(dataObj);
        } else {
          body = this.prepareQueryStringParams(dataObj);
        }

        // if content-type header doesnt exists, add it as application/x-www-form-urlencoded
        if (!(HEADER_CONTENT_TYPE in headersObj)) {
          headersObj[HEADER_CONTENT_TYPE] = CONTENT_TYPE_X_WWW_FORM_URLENCODED;
        }
      }
    }

    if (!(HEADER_ACCEPT in headersObj)) {
      headersObj[HEADER_ACCEPT] = ACCEPT_JSON;
    }

    // process the headers
    let headers = this.makeHeadersFromObj(headersObj);

    // generate config of the request
    let config = {
      method,
      headers,
      body,
      mode: 'cors',
      cache: 'default',
    };

    // return instance of request
    return new Request(uri, config);
  }

  //noinspection JSValidateJSDoc
  /**
   * Executes the request of this instance and returns a Promise
   * @param {Request} request
   * @param {?Function} converter
   * @returns {Promise.<TResult>}
   */
  static execRequest(request, converter = null) {
    /** @type {Response} response **/
    return fetch(request).then((response) => {
      // validate status of response
      if (response.status !== 200 && response.status !== 304) {
        // parse bad response msg
        return response.json().then(Promise.reject.bind(Promise));
      }

      // parse ok response
      if (!!converter && typeof converter === 'function') {
        // if converter function is given and is a function, execute it over the parsed json response
        return response.json().then(response => converter(response));
      } else {
        // returns the parsed json response
        return response.json();
      }
    });
  }

  /**
   * Make headers Object from std object
   * @param {Object} headersObj
   * @returns {Headers}
   */
  makeHeadersFromObj(headersObj = {}) {
    // generate Headers instance
    let headers = new Headers();

    // loop over each entry of the object and append them to headers
    ObjectUtils.forEachEntries(headersObj, ([key, value]) => {
      headers.append(key, value);
    });

    return headers;
  }

  /**
   * Process data object and generate query string params
   * @param {Object} dataObj
   * @returns {string}
   */
  prepareQueryStringParams(dataObj) {
    // init params array variable
    let paramsArr = [];

    // loop over each entry of the object and push them to params array
    ObjectUtils.forEachEntries(dataObj, ([key, value]) => {
      if (Array.isArray(value)) {
        value.forEach((arrvalue) => paramsArr.push(`${key}[]=${encodeURIComponent(arrvalue)}`));
      } else if (typeof value === 'object') {
        let valueStr = JSON.stringify(value);
        paramsArr.push(`${key}=${encodeURIComponent(valueStr)}`);
      } else {
        paramsArr.push(`${key}=${encodeURIComponent(value)}`);
      }
    });

    // prepare query string params string (key=value joined by &)
    return paramsArr.length > 0 ? paramsArr.join('&') : '';
  }
}
