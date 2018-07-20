/**
 * Created by alberto on 12/26/17.
 */

export default class ObjectUtils {
  /**
   * Check if object is empty
   * @param {Object} obj
   * @returns {boolean}
   */
  static isEmtpy(obj) {
    return !!obj && Object.keys(obj).length === 0 && obj.constructor === Object;
  }

  /**
   * Do foreach over an object with entries values
   * @param {Object} obj
   * @param {function} callbackfn
   * @returns {void|*}
   */
  static forEachEntries(obj, callbackfn) {
    // genero array de entries del objeto
    let entries = Object.entries(obj);

    // recorro array de entries y poblo el objeto de headers
    return entries.forEach(callbackfn);
  }
}
