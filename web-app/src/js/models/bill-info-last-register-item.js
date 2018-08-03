/**
 * @class BillInfoLastRegisterItem
 */
export default class BillInfoLastRegisterItem {
  /**
   *
   * @param {Object} obj
   * @param {string} obj.email
   * @param {string} obj.emailDatetime
   *
   * @return BillInfoLastRegisterItem
   */
  static makeFromObject(obj) {
    let register = new BillInfoLastRegisterItem();

    register.email = obj.email;
    register.emailDatetime = obj.emailDatetime;

    return register;
  }

  constructor() {
    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {string}
     */
    this.email = '';
    
    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {string}
     */
    this.emailDatetime = '';
  }
}