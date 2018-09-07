import WebApi from "./web-api";
import {HOST_API} from "../utils/app-utils";
import TokenUtils from "../utils/token-utils";

export default class FilterReceptorService {
  constructor(host = "") {
    this.host = host;
    this.section = "filter-receptor";
    this.headers = TokenUtils.appendTokenToHeaders({});
  }

  /**
   * @return {Promise<void>}
   */
  async getAll() {
    let api = new WebApi(`${this.host}/api/${this.section}`, {}, this.headers);
    return await api.get();
  }

  /**
   * @param {number} id
   * @return {Promise<void>}
   */
  async getById(id) {
    let api = new WebApi(`${this.host}/api/${this.section}/${id}`, {}, this.headers);
    return await api.get();
  }

  /**
   * @param {number} id
   * @param {Object} data
   * @return {Promise<void>}
   */
  async updateData(id, data) {
    let api = new WebApi(`${this.host}/api/${this.section}/${id}`, data, this.headers);
    return await api.put();
  }

  /**
   * @param {Object} data
   * @return {Promise<void>}
   */
  async create(data) {
    let api = new WebApi(`${this.host}/api/${this.section}`, data, this.headers);
    return await api.post();
  }

  /**
   *
   * @param {number} id
   * @return {Promise<void>}
   */
  async deleteEmitter(id) {
    let api = new WebApi(`${this.host}/api/${this.section}/${id}`, {}, this.headers);
    return await api.deleteRequest();
  }
}