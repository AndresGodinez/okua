/**
 * @class AlertEmailResponse
 */
export default class AlertEmailResponse {
  /**
   *
   * @param {Object} obj
   * @param {string} obj.id
   * @param {string} obj.name
   * @param {number} obj.regStatus
   *
   * @return AlertEmailResponse
   */
  static makeFromObject(obj) {
    let inst = new AlertEmailResponse();

    inst.id = obj.id;
    inst.name = obj.name;
    inst.regStatus = obj.regStatus;

    return inst;
  }

  constructor() {
    /**
     * @memberOf AlertEmailResponse
     * @type {number}
     */
    this.id = 0;

    /**
     * @memberOf AlertEmailResponse
     * @type {string}
     */
    this.name = '';

    /**
     * @memberOf AlertEmailResponse
     * @type {number}
     */
    this.regStatus = 0;
  }
}