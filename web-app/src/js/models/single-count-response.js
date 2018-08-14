/**
 * @class SingleCountResponse
 */
export default class SingleCountResponse {
  /**
   *
   * @param {Object} obj
   * @param {number} obj.count
   *
   * @return SingleCountResponse
   */
  static makeFromObject(obj) {
    let inst = new SingleCountResponse();

    inst.count = obj.count;

    return inst;
  }

  constructor() {
    /**
     * @memberOf SingleCountResponse
     * @type {number}
     */
    this.count = 0;
  }
}