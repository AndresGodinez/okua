import WebApi from "./web-api";
import TestResponse from "../models/test-response";

export default class TestService {
  constructor(host = "") {
    this.host = host;
  }

  async test() {
    let api = new WebApi(`${this.host}/api/test`, data);
    api.converter = TestResponse.converter;

    // other form of parsing response obj to class without converter
    // let response = await api.get();
    // let objResp = TestResponse.converter(response);
    // return objResp;

    return await api.get();
  }
}