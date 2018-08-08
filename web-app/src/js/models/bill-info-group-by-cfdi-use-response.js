import GroupByCfdiUseTableRow from "./group-by-cfdi-use-table-row";

/**
 * @class BillInfoGroupByCfdiUseResponse
 */
export default class BillInfoGroupByCfdiUseResponse {
  /**
   *
   * @param {Object} obj
   * @param {Array} obj.data
   *
   * @return BillInfoGroupByCfdiUseResponse
   */
  static makeFromObject(obj) {
    let inst = new BillInfoGroupByCfdiUseResponse();

    for (let item of obj.data) {
      let register = GroupByCfdiUseTableRow.makeFromObject(item);
      inst.data.push(register);
    }

    return inst;
  }

  constructor() {
    /**
     * @memberOf BillInfoGroupByCfdiUseResponse
     * @type {GroupByClientTableRow[]}
     */
    this.data = [];
  }
}