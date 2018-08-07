import GroupByEmailTableRow from "./group-by-email-table-row";

/**
 * @class BillInfoGroupByEmailResponse
 */
export default class BillInfoGroupByEmailResponse {
  /**
   *
   * @param {Object} obj
   * @param {Array} obj.data
   *
   * @return BillInfoGroupByEmailResponse
   */
  static makeFromObject(obj) {
    let inst = new BillInfoGroupByEmailResponse();

    for (let item of obj.data) {
      let register = GroupByEmailTableRow.makeFromObject(item);
      inst.data.push(register);
    }

    return inst;
  }

  constructor() {
    /**
     * @memberOf BillInfoGroupByEmailResponse
     * @type {GroupByClientTableRow[]}
     */
    this.data = [];
  }
}