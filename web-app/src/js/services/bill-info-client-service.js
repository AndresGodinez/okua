import WebApi from "./web-api";
import BillInfoClientRegistersOrderedResponse from "../models/bill-info-client-registers-ordered-response";

export default class BillInfoClientService {
  constructor(host = "") {
    this.host = host;
  }

  async getRegistersOrderedByName() {
    let api = new WebApi(`${this.host}/api/bill-info-client`);
    api.converter = BillInfoClientRegistersOrderedResponse.makeFromObject;

    return await api.get();
  }
}