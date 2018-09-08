import WebApi from "./web-api";
import {HOST_API} from "../utils/app-utils";
import TokenUtils from "../utils/token-utils";

/**
 * @class UserService
 */
export default class UserService {
  constructor(host = "") {
    this.host = host;
    this.headers = TokenUtils.appendTokenToHeaders({});
  }

  async auth(username, password) {
    const data = {
      username,
      password,
    };

    let api = new WebApi(`${this.host}/api/user/authenticate`, data);
    return await api.post();
  }

  /**
   * @return {Promise<void>}
   */
  async getAllUsers() {
    let api = new WebApi(`${this.host}/api/user`, {}, this.headers);
    return await api.get();
  }

  /**
   * @param {number} id
   * @return {Promise<void>}
   */
  async getUserById(id) {
    let api = new WebApi(`${this.host}/api/user/${id}`, {}, this.headers);
    return await api.get();
  }

  async getUserActivities(id) {
    // let api = new WebApi(`${this.host}/api/user/${id}`, {}, this.headers);
    // return await api.get();
    let data = [
      {label: "Secciones de Administrador", code: "1", active: 1},
      {label: "procesadores cfdi", code: "2", active: 0},
      {label: "Advertencias procesadas", code: "3", active: 0},
      {label: "Sección de proveedores", code: "4", active: 1},
    ];
    return data;
  }
}