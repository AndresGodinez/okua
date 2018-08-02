/**
 * @class GroupByCfdiUseTableRow
 */
export default class GroupByCfdiUseTableRow {
  /**
   *
   * @param {Object} obj
   * @param {number} obj.cfdiUseId
   * @param {string} obj.cfdiUseName
   * @param {string} obj.cfdiUseSatCode
   * @param {number} obj.amount
   *
   * @return GroupByCfdiUseTableRow
   */
  static makeFromObject(obj) {
    let register = new GroupByCfdiUseTableRow();

    register.cfdiUseId = obj.cfdiUseId;
    register.cfdiUseName = obj.cfdiUseName;
    register.cfdiUseSatCode = obj.cfdiUseSatCode;
    register.amount = obj.amount;

    return register;
  }

  constructor() {
    /**
     * @memberOf GroupByCfdiUseTableRow
     * @type {number}
     */
    this.cfdiUseId = 0;

    /**
     * @memberOf GroupByCfdiUseTableRow
     * @type {string}
     */
    this.cfdiUseName = '';

    /**
     * @memberOf GroupByCfdiUseTableRow
     * @type {string}
     */
    this.cfdiUseSatCode = '';

    /**
     * @memberOf GroupByCfdiUseTableRow
     * @type {number}
     */
    this.amount = 0;
  }
}