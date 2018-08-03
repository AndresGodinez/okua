import WebApi from "./web-api";
import BillsTotalResponse from "../models/bills-total-response";

export default class BillInfoService {
  constructor(host = "") {
    this.host = host;
  }

  async getBillsTotal(filter) {
    const data = {
      filter,
    };

    let api = new WebApi(`${this.host}/api/bill-info/total`, data);
    api.converter = BillsTotalResponse.makeFromObject;

    return await api.get();
  }
}