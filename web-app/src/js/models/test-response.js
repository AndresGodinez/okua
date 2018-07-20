/** @class */
export default class TestResponse {
  /**
   * @param {Object} response
   * @param {string} response.msg
   * @returns {TestResponse}
   */
  static converter(response) {
    let inst = new TestResponse();
    inst.msg = response.msg;
    return inst;
  }

  constructor() {
    /** @member {string} */
    self.msg = '';
  }
}