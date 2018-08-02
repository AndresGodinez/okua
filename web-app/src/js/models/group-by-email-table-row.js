/**
 * @class GroupByEmailTableRow
 */
export default class GroupByEmailTableRow {
  /**
   *
   * @param {Object} obj
   * @param {string} obj.email
   * @param {number} obj.amount
   *
   * @return GroupByEmailTableRow
   */
  static makeFromObject(obj) {
    let register = new GroupByEmailTableRow();

    register.email = obj.email;
    register.amount = obj.amount;

    return register;
  }

  constructor() {
    /**
     * @memberOf GroupByEmailTableRow
     * @type {string}
     */
    this.email = 0;

    /**
     * @memberOf GroupByEmailTableRow
     * @type {number}
     */
    this.amount = 0;
  }
}