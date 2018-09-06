/**
 * @class BillsInfoTableRow
 */
import {WARNING_INFO_STAMP_STATUSES} from "../utils/models-utils";

export default class WarningInfoTableRow {
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
   * @return BillsInfoTableRow
   */
  static makeFromObject(obj) {
    let register = new WarningInfoTableRow();

    register.id = obj.id;
    register.code = obj.code;
    register.description = obj.description;
    register.email = obj.email;
    register.cfdiId = obj.cfdiId;
    register.emailDatetime = obj.emailDatetime;
    register.regDatetime = obj.regDatetime;

    return register;
  }

  constructor() {
    /**
     * @memberOf WarningInfoTableRow
     * @type {number}
     */
    this.id = 0;

    /**
     * @memberOf WarningInfoTableRow
     * @type {string}
     */
    this.code = 0;

    /**
     * @memberOf WarningInfoTableRow
     * @type {string}
     */
    this.description = 0;

    /**
     * @memberOf WarningInfoTableRow
     * @type {string}
     */
    this.email = 0;

    /**
     * @memberOf WarningInfoTableRow
     * @type {string}
     */
    this.cfdiId = 0;

    /**
     * @memberOf WarningInfoTableRow
     * @type {string}
     */
    this.emailDatetime = '';

    /**
     * @memberOf WarningInfoTableRow
     * @type {string}
     */
    this.regDatetime = '';
  }
}