/**
 * @class BillsInfoTableRow
 */
export default class BillsInfoTableRow {
  /**
   *
   * @param {Object} obj
   * @param {number} obj.id
   * @param {string} obj.clientName
   * @param {string} obj.clientRfc
   * @param {string} obj.uuid
   * @param {string} obj.cfdiUseName
   * @param {string} obj.cfdiUseSatCode
   * @param {string} obj.documentDatetime
   * @param {string} obj.emailDatetime
   * @param {string} obj.stampDatetime
   * @param {number} obj.total
   * @param {string} obj.currency
   *
   * @return BillsInfoTableRow
   */
  static makeFromObject(obj) {
    let register = new BillsInfoTableRow();

    register.id = obj.id;
    register.clientName = obj.clientName;
    register.clientRfc = obj.clientRfc;
    register.uuid = obj.uuid;
    register.cfdiUseName = obj.cfdiUseName;
    register.cfdiUseSatCode = obj.cfdiUseSatCode;
    register.documentDatetime = obj.documentDatetime;
    register.emailDatetime = obj.emailDatetime;
    register.stampDatetime = obj.stampDatetime;
    register.total = obj.total;
    register.currency = obj.currency;

    return register;
  }

  constructor() {
    /**
     * @memberOf BillsInfoTableRow
     * @type {number}
     */
    this.id = 0;

    /**
     * @memberOf BillsInfoTableRow
     * @type {string}
     */
    this.clientName = '';

    /**
     * @memberOf BillsInfoTableRow
     * @type {string}
     */
    this.clientRfc = '';

    /**
     * @memberOf BillsInfoTableRow
     * @type {string}
     */
    this.uuid = '';

    /**
     * @memberOf BillsInfoTableRow
     * @type {string}
     */
    this.cfdiUseName = '';

    /**
     * @memberOf BillsInfoTableRow
     * @type {string}
     */
    this.cfdiUseSatCode = '';

    /**
     * @memberOf BillsInfoTableRow
     * @type {string}
     */
    this.documentDatetime = '';

    /**
     * @memberOf BillsInfoTableRow
     * @type {string}
     */
    this.emailDatetime = '';

    /**
     * @memberOf BillsInfoTableRow
     * @type {string}
     */
    this.stampDatetime = '';

    /**
     * @memberOf BillsInfoTableRow
     * @type {number}
     */
    this.total = 0;

    /**
     * @memberOf BillsInfoTableRow
     * @type {string}
     */
    this.currency = 'MXN';
  }
}