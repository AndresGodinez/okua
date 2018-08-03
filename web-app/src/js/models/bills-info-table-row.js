/**
 * @class BillsInfoTableRow
 */
export default class BillsInfoTableRow {
  /**
   *
   * @param {Object} obj
   * @param {number} obj.id
   * @param {string} obj.email
   * @param {string} obj.emitterName
   * @param {string} obj.emitterRfc
   * @param {string} obj.uuid
   * @param {string} obj.cfdiUseSatCode
   * @param {number} obj.subtotal
   * @param {number} obj.discount
   * @param {number} obj.total
   * @param {string} obj.currency
   * @param {string} obj.type
   * @param {string} obj.paymentType
   * @param {string} obj.documentDatetime
   * @param {string} obj.stampDatetime
   * @param {string} obj.emailDatetime
   * @param {string} obj.regDatetime
   *
   * @return BillsInfoTableRow
   */
  static makeFromObject(obj) {
    let register = new BillsInfoTableRow();

    register.id = obj.id;
    register.clientName = obj.emitterName;
    register.clientRfc = obj.emitterRfc;
    register.uuid = obj.uuid;
    register.cfdiUseName = '';
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