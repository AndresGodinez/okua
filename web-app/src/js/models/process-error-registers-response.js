import ProcessErrorRegisterItem from "./process-error-register-item";

/**
 * @class ProcessErrorRegistersResponse
 */
export default class ProcessErrorRegistersResponse {
  /**
   *
   * @param {Object} obj
   * @param {Array} obj.data
   *
   * @return ProcessErrorRegistersResponse
   */
  static makeFromObject(obj) {
    let inst = new ProcessErrorRegistersResponse();

    for (let item of obj.data) {
      let register = ProcessErrorRegisterItem.makeFromObject(item);
      inst.data.push(register);
    }

    return inst;
  }

  constructor() {
    /**
     * @memberOf ProcessErrorRegistersResponse
     * @type {ProcessErrorRegisterItem[]}
     */
    this.data = [];
  }
}