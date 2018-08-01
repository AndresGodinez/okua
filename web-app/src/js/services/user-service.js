import WebApi from "./web-api";

export default class UserService {
  constructor(host = "") {
    this.host = host;
  }

  async auth(username, password) {
    const data = {
      username,
      password,
    };

    let api = new WebApi(`${this.host}/api/user/authenticate`, data);

    return await api.post();
  }
}