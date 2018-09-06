/**
 * @class ProcessErrorRegisterItem
 */
export default class ProcessErrorRegisterItem {
  /**
   *
   * @param {Object} obj
   * @param {string} obj.email
   * @param {string} obj.emailDatetime
   *
   * @return ProcessErrorRegisterItem
   */
  static makeFromObject(obj) {
    let register = new ProcessErrorRegisterItem();

    register.id = obj.id;
    register.code = obj.code;
    register.description = obj.description;
    register.email = obj.email;
    register.emailDatetime = obj.emailDatetime;
    register.regDatetime = obj.regDatetime;

    return register;
  }

  constructor() {
    /**
     * @memberOf ProcessErrorRegisterItem
     * @type {string}
     */
    this.email = '';
    
    /**
     * @memberOf ProcessErrorRegisterItem
     * @type {string}
     */
    this.emailDatetime = '';

    this.regDatetime = '';

    this.code = '';

    this.description = '';
  }
}