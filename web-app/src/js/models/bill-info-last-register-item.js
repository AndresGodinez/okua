import {BILL_INFO_STAMP_STATUSES} from "../utils/models-utils";

/**
 * @class BillInfoLastRegisterItem
 */
export default class BillInfoLastRegisterItem {
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
   * @return BillInfoLastRegisterItem
   */
  static makeFromObject(obj) {
    let register = new BillInfoLastRegisterItem();

    register.id = obj.id;
    register.clientName = obj.emitterName;
    register.clientRfc = obj.emitterRfc;
    register.email = obj.email;
    register.uuid = obj.uuid;
    register.cfdiUseName = '';
    register.total = obj.total;
    register.cfdiUseSatCode = obj.cfdiUseSatCode;
    register.documentDatetime = obj.documentDatetime;
    register.emailDatetime = obj.emailDatetime;
    register.stampDatetime = obj.stampDatetime;
    register.total = obj.total;
    register.currency = obj.currency;
    register.stampStatus = obj.stampStatus;
    register.hasPdf = obj.hasPdf;

    return register;
  }

  constructor() {
    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {number}
     */
    this.id = 0;

    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {string}
     */
    this.clientName = '';

    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {string}
     */
    this.clientRfc = '';

    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {string}
     */
    this.uuid = '';

    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {string}
     */
    this.cfdiUseName = '';

    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {string}
     */
    this.cfdiUseSatCode = '';

    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {string}
     */
    this.documentDatetime = '';

    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {string}
     */
    this.emailDatetime = '';

    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {string}
     */
    this.stampDatetime = '';

    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {number}
     */
    this.total = 0;

    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {string}
     */
    this.currency = 'MXN';

    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {number}
     */
    this.stampStatus = BILL_INFO_STAMP_STATUSES.NOT_DEFINED;

    /**
     * @memberOf BillInfoLastRegisterItem
     * @type {number}
     */
    this.hasPdf = -1;
  }
}