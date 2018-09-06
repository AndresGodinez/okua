import WarningInfoTableRow from "./warning-info-table-row";

/**
 * @class WarningFilteredRegistersResponse
 */
export default class WarningFilteredRegistersResponse {
  /**
   *
   * @param {Object} obj
   * @param {Array} obj.data
   *
   * @return WarningFilteredRegistersResponse
   */
  static makeFromObject(obj) {
    let inst = new WarningFilteredRegistersResponse();

    for (let item of obj.data) {
      let register = WarningInfoTableRow.makeFromObject(item);
      inst.data.push(register);
    }

    return inst;
  }

  constructor() {
    /**
     * @memberOf WarningFilteredRegistersResponse
     * @type {WarningLastRegisterItem[]}
     */
    this.data = [];
  }
}