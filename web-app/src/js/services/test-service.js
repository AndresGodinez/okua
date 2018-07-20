import WebApi from "./web-api";
import TokenUtils from "../utils/token-utils";
import ValidateSessionResponse from "../models/auth/validate-session-response";
import TestResponse from "../models/test-response";

export default class UserService {
  constructor(host = "") {
    this.host = host;
  }

  async test(username, password) {
    const data = {
      username,
      password,
    };

    let api = new WebApi(`${this.host}/api/test`, data);
    api.converter = TestResponse.converter;

    // other form of parsing response obj to class without converter
    // let response = await api.get();
    // let objResp = TestResponse.converter(response);
    // return objResp;

    return await api.get();
  }
}