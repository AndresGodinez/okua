import WebApi from "./web-api";
import TokenUtils from "../utils/token-utils";

export default class AdminConfigService {
  constructor(host = "") {
    this.host = host;
  }

  async updateEmailConfigService(hostname, username, pswd) {
    let data = {
      hostname,
      username,
      pswd,
    };

    let headers = TokenUtils.appendTokenToHeaders({});

    let api = new WebApi(`${this.host}/api/config/email-service`, data, headers);

    return await api.put();
  }

  async readEmailConfigService() {
    let headers = TokenUtils.appendTokenToHeaders({});

    let api = new WebApi(`${this.host}/api/config/email-service`, {}, headers);

    return await api.get();
  }
}