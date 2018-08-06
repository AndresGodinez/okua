import BillInfoClientItem from "./bill-info-client-item";

/**
 * @class BillInfoClientRegistersOrderedResponse
 */
export default class BillInfoClientRegistersOrderedResponse {
  /**
   *
   * @param {Object} obj
   * @param {Array} obj.data
   *
   * @return BillInfoClientRegistersOrderedResponse
   */
  static makeFromObject(obj) {
    let inst = new BillInfoClientRegistersOrderedResponse();

    for (let item of obj.data) {
      let register = BillInfoClientItem.makeFromObject(item);
      inst.data.push(register);
    }

    return inst;
  }

  constructor() {
    /**
     * @memberOf BillInfoClientRegistersOrderedResponse
     * @type {BillInfoClientItem[]}
     */
    this.data = [];
  }
}