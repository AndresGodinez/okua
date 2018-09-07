/**
 * @class Emitter
 */
export default class Emitter {
  /**
   *
   * @param {Object} obj
   * @param {string} obj.id
   * @param {string} obj.name
   * @param {number} obj.regStatus
   *
   * @return Emitter
   */
  static makeFromObject(obj) {
    let inst = new Emitter();

    inst.id = obj.id;
    inst.name = obj.name;
    inst.regStatus = obj.regStatus;

    return inst;
  }

  constructor() {
    /**
     * @memberOf Emitter
     * @type {number}
     */
    this.id = 0;

    /**
     * @memberOf Emitter
     * @type {string}
     */
    this.name = '';

    /**
     * @memberOf Emitter
     * @type {number}
     */
    this.regStatus = 0;
  }
}