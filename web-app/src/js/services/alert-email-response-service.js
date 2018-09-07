import WebApi from "./web-api";
import {HOST_API} from "../utils/app-utils";
import TokenUtils from "../utils/token-utils";

export default class AlertEmailResponseService {
  constructor(host = "") {
    this.host = host;
    this.service = "alert-email-response";
    this.headers = TokenUtils.appendTokenToHeaders({});
  }

  async getAll() {
    let api = new WebApi(`${this.host}/api/${this.service}`, {}, this.headers);
    return await api.get();
  }

  async getById(id) {
    let api = new WebApi(`${this.host}/api/${this.service}/${id}`, {}, this.headers);
    return await api.get();
  }

  /**
   * @param {number} id
   * @param {Object} data
   * @return {Promise<void>}
   */
  async updateData(id, data) {
    if(!data) {
      throw "Error al recibir los datos del formulario";
    }

    let api = new WebApi(`${this.host}/api/${this.service}/${id}`, data, this.headers);
    return await api.put();
  }
}