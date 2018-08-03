/**
 * @class BillsTotalResponse
 */
export default class BillsTotalResponse {
  /**
   *
   * @param {Object} obj
   * @param {number} obj.total
   *
   * @return BillsTotalResponse
   */
  static makeFromObject(obj) {
    let register = new BillsTotalResponse();

    register.total = obj.total;

    return register;
  }

  constructor() {
    /**
     * @memberOf BillsTotalResponse
     * @type {number}
     */
    this.total = 0;
  }
}