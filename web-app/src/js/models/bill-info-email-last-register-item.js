/**
 * @class BillInfoEmailLastRegisterItem
 */
export default class BillInfoEmailLastRegisterItem {
  /**
   *
   * @param {Object} obj
   * @param {string} obj.email
   * @param {string} obj.emailDatetime
   *
   * @return BillInfoEmailLastRegisterItem
   */
  static makeFromObject(obj) {
    let register = new BillInfoEmailLastRegisterItem();

    register.email = obj.email;
    register.emailDatetime = obj.emailDatetime;

    return register;
  }

  constructor() {
    /**
     * @memberOf BillInfoEmailLastRegisterItem
     * @type {string}
     */
    this.email = '';
    
    /**
     * @memberOf BillInfoEmailLastRegisterItem
     * @type {string}
     */
    this.emailDatetime = '';
  }
}