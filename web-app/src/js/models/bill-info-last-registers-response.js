import BillInfoLastRegisterItem from "./bill-info-last-register-item";

/**
 * @class BillInfoLastRegistersResponse
 */
export default class BillInfoLastRegistersResponse {
  /**
   *
   * @param {Object} obj
   * @param {Array} obj.data
   *
   * @return BillInfoLastRegistersResponse
   */
  static makeFromObject(obj) {
    let inst = new BillInfoLastRegistersResponse();

    for (let item of obj.data) {
      let register = BillInfoLastRegisterItem.makeFromObject(item);
      inst.data.push(register);
    }

    return inst;
  }

  constructor() {
    /**
     * @memberOf BillInfoLastRegistersResponse
     * @type {BillInfoLastRegisterItem[]}
     */
    this.data = [];
  }
}