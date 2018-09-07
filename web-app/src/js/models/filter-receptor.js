/**
 * @class FilterReceptor
 */
export default class FilterReceptor {
  /**
   *
   * @param {Object} obj
   * @param {string} obj.id
   * @param {string} obj.name
   * @param {number} obj.regStatus
   *
   * @return FilterReceptor
   */
  static makeFromObject(obj) {
    let inst = new FilterReceptor();

    inst.id = obj.id;
    inst.name = obj.name;
    inst.regStatus = obj.regStatus;

    return inst;
  }

  constructor() {
    /**
     * @memberOf FilterReceptor
     * @type {number}
     */
    this.id = 0;

    /**
     * @memberOf FilterReceptor
     * @type {string}
     */
    this.name = '';

    /**
     * @memberOf FilterReceptor
     * @type {number}
     */
    this.regStatus = 0;
  }
}