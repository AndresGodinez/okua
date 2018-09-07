/**
 * @class FilterEmitter
 */
export default class FilterEmitter {
  /**
   *
   * @param {Object} obj
   * @param {string} obj.id
   * @param {string} obj.name
   * @param {number} obj.regStatus
   *
   * @return FilterEmitter
   */
  static makeFromObject(obj) {
    let inst = new FilterEmitter();

    inst.id = obj.id;
    inst.name = obj.name;
    inst.regStatus = obj.regStatus;

    return inst;
  }

  constructor() {
    /**
     * @memberOf FilterEmitter
     * @type {number}
     */
    this.id = 0;

    /**
     * @memberOf FilterEmitter
     * @type {string}
     */
    this.name = '';

    /**
     * @memberOf FilterEmitter
     * @type {number}
     */
    this.regStatus = 0;
  }
}