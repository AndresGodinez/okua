/**
 * @class WarningTableRow
 */

export default class WarningTableRow {
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
   * @param {number} obj.stampStatus
   * @param {number} obj.hasPdf
   *
   * @return WarningTableRow
   */
  static makeFromObject(obj) {
    let register = new WarningTableRow();

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
    register.stampStatus = obj.stampStatus;
    register.hasPdf = obj.hasPdf;
    register.regDatetime = obj.regDatetime;

    return register;
  }

  constructor() {
    /**
     * @memberOf WarningTableRow
     * @type {number}
     */
    this.id = 0;

    /**
     * @memberOf WarningTableRow
     * @type {string}
     */
    this.clientName = '';

    /**
     * @memberOf WarningTableRow
     * @type {string}
     */
    this.clientRfc = '';

    /**
     * @memberOf WarningTableRow
     * @type {string}
     */
    this.uuid = '';

    /**
     * @memberOf WarningTableRow
     * @type {string}
     */
    this.cfdiUseName = '';

    /**
     * @memberOf WarningTableRow
     * @type {string}
     */
    this.cfdiUseSatCode = '';

    /**
     * @memberOf WarningTableRow
     * @type {string}
     */
    this.documentDatetime = '';

    /**
     * @memberOf WarningTableRow
     * @type {string}
     */
    this.emailDatetime = '';

    /**
     * @memberOf WarningTableRow
     * @type {string}
     */
    this.stampDatetime = '';

    /**
     * @memberOf WarningTableRow
     * @type {number}
     */
    this.total = 0;

    /**
     * @memberOf WarningTableRow
     * @type {string}
     */
    this.currency = 'MXN';

    /**
     * @memberOf WarningTableRow
     * @type {number}
     */
    this.hasPdf = -1;
  }
}