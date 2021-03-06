import BillsInfoTableRow from "./bills-info-table-row";

/**
 * @class BillInfoFilteredRegistersResponse
 */
export default class BillInfoFilteredRegistersResponse {
  /**
   *
   * @param {Object} obj
   * @param {Array} obj.data
   *
   * @return BillInfoFilteredRegistersResponse
   */
  static makeFromObject(obj) {
    let inst = new BillInfoFilteredRegistersResponse();

    for (let item of obj.data) {
      let register = BillsInfoTableRow.makeFromObject(item);
      inst.data.push(register);
    }

    return inst;
  }

  constructor() {
    /**
     * @memberOf BillInfoFilteredRegistersResponse
     * @type {BillInfoLastRegisterItem[]}
     */
    this.data = [];
  }
}