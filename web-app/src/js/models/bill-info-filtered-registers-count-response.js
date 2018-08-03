/**
 * @class BillInfoFilteredRegistersCountResponse
 */
export default class BillInfoFilteredRegistersCountResponse {
  /**
   *
   * @param {Object} obj
   * @param {number} obj.count
   *
   * @return BillInfoFilteredRegistersCountResponse
   */
  static makeFromObject(obj) {
    let inst = new BillInfoFilteredRegistersCountResponse();

    inst.count = obj.count;

    return inst;
  }

  constructor() {
    /**
     * @memberOf BillInfoFilteredRegistersCountResponse
     * @type {number}
     */
    this.count = 0;
  }
}