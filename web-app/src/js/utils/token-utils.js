/**
 * Created by alberto on 29/06/17.
 */

import AES from "crypto-js/aes";
import Base64 from "crypto-js/enc-base64";
import Utf8 from "crypto-js/enc-utf8";
import AppUtils from "./app-utils";

const KY = 'cu5$&0_M';
const AES_KY = '[&F#Cfw-!D>E8"^Q';
const HEADER_TOKEN = "authorization";

export default class TokenUtils {
  /**
   * Sets the token
   * @param {string} token
   */
  static async setToken(token) {
    if (!token)
      throw 'Bad token received';

    localStorage.token = AES.encrypt(token, KY);
    return localStorage.token;
  }

  static getToken() {
    return AES.decrypt(localStorage.token, KY).toString(Utf8);
  }

  /**
   * Appends token header to headers
   * @param {Object} headers
   * @returns {Object}
   */
  static appendTokenToHeaders(headers) {
    // validando headers de entrada
    if (!headers) {
      throw "Headers can't be null";
    }

    // obteniendo jwt del storage
    let jwt = "";
    try {
      jwt = AES.decrypt(localStorage.token, KY).toString(Utf8);
      jwt = TokenUtils.tokenToBase64Str(jwt);
    } catch (e) {
      console.error('Error getting token. ' + e);
      jwt = null;
    }

    // agregando el token a los encabezados
    if (!!jwt) {
      headers[HEADER_TOKEN] = 'Bearer ' + jwt;
    } else {
      throw "Token doesn't exist";
    }

    return headers;
  }

  static getAesToken() {
    // obteniendo jwt del storage
    let jwt = "";
    try {
      jwt = AES.decrypt(localStorage.token, KY).toString(Utf8);
    } catch (e) {
      console.error('Error getting token. ' + e);
      jwt = null;
    }

    // agregando el token a los encabezados
    if (!!jwt) {
      const hexKey = this.getHexKey(AES_KY);
      const aesToken = AES.encrypt(jwt, hexKey).toString();
      const aesTokenWords = Utf8.parse(aesToken);
      return Base64.stringify(aesTokenWords);
    } else {
      throw "Token doesn't exist";
    }
  }


  static appendAesTokenToData(data) {
    // validando objeto data de entrada
    if (!data) {
      throw "Data can't be null";
    }

    data.a = TokenUtils.getAesToken();

    return data;
  }

  static getHexKey(key) {
    if (!key) {
      throw "Key can't be null";
    }
    return this.strToHex(key);
  }

  /**
   * @param {string} s
   * @returns {string}
   */
  static strToHex(s) {
    let h = '';
    for (let i = 0; i < s.length; i++) {
      h += s.charCodeAt(i).toString(16);
    }
    return h.toLowerCase();
  }

  /**
   * Get data in JWT token
   * @returns {Object|null}
   */
  static getJwtData() {
    const jwt = AES.decrypt(localStorage.token, KY).toString(Utf8);
    try {
      const jwtParts = jwt.split('.');
      const jwtDataStr = Base64.parse(jwtParts[1]).toString(Utf8);
      return JSON.parse(jwtDataStr);
    } catch (e) {
      console.error('Error getting data');
      return null;
    }
  }

  /**
   * Validate if token exists
   * @returns {boolean}
   */
  static exists() {
    return !!localStorage.token && localStorage.token !== '';
  }

  /**
   * Clears the token in storage
   */
  static clear() {
    localStorage.token = '';
  }

  /**
   * @param {!string} token
   * @returns {*}
   */
  static tokenToBase64Str(token) {
    if (!token) throw 'Invalid token string';
    const tokenWords = Utf8.parse(token);
    return Base64.stringify(tokenWords);
  }

  /**
   * Validates the token with the api
   * @param {UserService} service
   */
  static validateSessionOnService(service) {
    if (!TokenUtils.exists()) {
      AppUtils.logout();
    }

    service.validateSession()
      .then((data) => {
        if (!data.valid) {
          AppUtils.logout();
        }
      })
      .catch((e) => console.error(e));
  }
}
