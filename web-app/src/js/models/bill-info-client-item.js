/**
 * @class BillInfoClientItem
 */
export default class BillInfoClientItem {
  /**
   *
   * @param {Object} obj
   * @param {string} obj.emitterName
   * @param {string} obj.emitterRfc
   *
   * @return BillInfoClientItem
   */
  static makeFromObject(obj) {
    let inst = new BillInfoClientItem();

    inst.emitterName = obj.emitterName;
    inst.emitterRfc = obj.emitterRfc;

    return inst;
  }

  constructor() {
    /**
     * @memberOf BillInfoClientItem
     * @type {string}
     */
    this.emitterName = '';

    /**
     * @memberOf BillInfoClientItem
     * @type {string}
     */
    this.emitterRfc = '';
  }
}