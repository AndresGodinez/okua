/**
 * @class ErrorTableRow
 */

export default class ErrorTableRow {
  /**
   *
   * @param {Object} obj
   * @param {number} obj.id
   * @param {string} obj.email 
   * @param {string} obj.description
   * @param {string} obj.emailDatetime
   * @param {string} obj.regDatetime
   *
   * @return BillsInfoTableRow
   */
  static makeFromObject(obj) {
    let register = new ErrorTableRow();

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
     * @memberOf WarningInfoTableRow
     * @type {number}
     */
    this.id = 0;

    /**
     * @memberOf WarningInfoTableRow
     * @type {string}
     */
    this.code = 0;

    /**
     * @memberOf WarningInfoTableRow
     * @type {string}
     */
    this.description = '';

    /**
     * @memberOf WarningInfoTableRow
     * @type {string}
     */
    this.email = '';

    /**
     * @memberOf WarningInfoTableRow
     * @type {string}
     */
    this.emailDatetime = '';

    /**
     * @memberOf WarningInfoTableRow
     * @type {string}
     */
    this.regDatetime = '';
  }
}