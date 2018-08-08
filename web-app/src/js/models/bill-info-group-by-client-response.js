import GroupByClientTableRow from "./group-by-client-table-row";

/**
 * @class BillInfoGroupByClientResponse
 */
export default class BillInfoGroupByClientResponse {
  /**
   *
   * @param {Object} obj
   * @param {Array} obj.data
   *
   * @return BillInfoGroupByClientResponse
   */
  static makeFromObject(obj) {
    let inst = new BillInfoGroupByClientResponse();

    for (let item of obj.data) {
      let register = GroupByClientTableRow.makeFromObject(item);
      inst.data.push(register);
    }

    return inst;
  }

  constructor() {
    /**
     * @memberOf BillInfoGroupByClientResponse
     * @type {GroupByClientTableRow[]}
     */
    this.data = [];
  }
}