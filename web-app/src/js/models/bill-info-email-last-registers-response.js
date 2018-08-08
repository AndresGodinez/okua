import BillInfoEmailLastRegisterItem from "./bill-info-email-last-register-item";

/**
 * @class BillInfoEmailLastRegistersResponse
 */
export default class BillInfoEmailLastRegistersResponse {
  /**
   *
   * @param {Object} obj
   * @param {Array} obj.data
   *
   * @return BillInfoEmailLastRegistersResponse
   */
  static makeFromObject(obj) {
    let inst = new BillInfoEmailLastRegistersResponse();

    for (let item of obj.data) {
      let register = BillInfoEmailLastRegisterItem.makeFromObject(item);
      inst.data.push(register);
    }

    return inst;
  }

  constructor() {
    /**
     * @memberOf BillInfoEmailLastRegistersResponse
     * @type {BillInfoEmailLastRegisterItem[]}
     */
    this.data = [];
  }
}