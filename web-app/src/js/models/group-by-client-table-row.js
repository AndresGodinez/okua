/**
 * @class GroupByClientTableRow
 */
export default class GroupByClientTableRow {
  /**
   *
   * @param {Object} obj
   * @param {number} obj.clientId
   * @param {string} obj.clientName
   * @param {string} obj.clientRfc
   * @param {number} obj.amount
   *
   * @return GroupByClientTableRow
   */
  static makeFromObject(obj) {
    let register = new GroupByClientTableRow();

    register.clientId = obj.clientId;
    register.clientName = obj.clientName;
    register.clientRfc = obj.clientRfc;
    register.amount = obj.amount;

    return register;
  }

  constructor() {
    /**
     * @memberOf GroupByClientTableRow
     * @type {number}
     */
    this.clientId = 0;

    /**
     * @memberOf GroupByClientTableRow
     * @type {string}
     */
    this.clientName = '';

    /**
     * @memberOf GroupByClientTableRow
     * @type {string}
     */
    this.clientRfc = '';

    /**
     * @memberOf GroupByClientTableRow
     * @type {number}
     */
    this.amount = 0;
  }
}