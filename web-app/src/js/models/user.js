/**
 * @class User
 */
export default class User {
  /**
   *
   * @param {Object} obj
   * @param {string} obj.id
   * @param {string} obj.name
   * @param {number} obj.regStatus
   *
   * @return User
   */
  static makeFromObject(obj) {
    let inst = new User();

    inst.id = obj.id;
    inst.name = obj.name;
    inst.regStatus = obj.regStatus;

    return inst;
  }

  constructor() {
    /**
     * @memberOf User
     * @type {number}
     */
    this.id = 0;

    /**
     * @memberOf User
     * @type {string}
     */
    this.name = '';

    /**
     * @memberOf User
     * @type {number}
     */
    this.regStatus = 0;
  }
}