/**
 * @class ProcessWarningRegisterItem
 */
export default class ProcessWarningRegisterItem {
  /**
   *
   * @param {Object} obj
   * @param {string} obj.email
   * @param {string} obj.emailDatetime
   *
   * @return ProcessWarningRegisterItem
   */
  static makeFromObject(obj) {
    let register = new ProcessWarningRegisterItem();

    register.code = obj.code;
    register.description = obj.description;
    register.email = obj.email;
    register.emailDatetime = obj.emailDatetime;
    register.cfdiId = obj.cfdiId

    return register;
  }

  constructor() {
    /**
     * @memberOf ProcessWarningRegisterItem
     * @type {string}
     */
    this.email = '';
    
    /**
     * @memberOf ProcessWarningRegisterItem
     * @type {string}
     */
    this.emailDatetime = '';

    this.code = '';

    this.description = '';

    this.cfdiId = '';

  }
}