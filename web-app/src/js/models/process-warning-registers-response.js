import ProcessWarningRegisterItem from "./process-warning-register-item";

/**
 * @class ProcessWarningRegistersResponse
 */
export default class ProcessWarningRegistersResponse {
  /**
   *
   * @param {Object} obj
   * @param {Array} obj.data
   *
   * @return ProcessWarningRegistersResponse
   */
  static makeFromObject(obj) {
    let inst = new ProcessWarningRegistersResponse();

    for (let item of obj.data) {
      let register = ProcessWarningRegisterItem.makeFromObject(item);
      inst.data.push(register);
    }

    return inst;
  }

  constructor() {
    /**
     * @memberOf ProcessWarningRegistersResponse
     * @type {ProcessWarningRegisterItem[]}
     */
    this.data = [];
  }
}