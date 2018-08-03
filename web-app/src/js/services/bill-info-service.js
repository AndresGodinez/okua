import WebApi from "./web-api";
import BillsTotalResponse from "../models/bills-total-response";
import BillInfoLastRegistersResponse from "../models/bill-info-last-registers-response";

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

  async getLastRegisters(limit) {
    const data = {
      limit,
    };

    let api = new WebApi(`${this.host}/api/bill-info/last-registers`, data);
    api.converter = BillInfoLastRegistersResponse.makeFromObject;

    return await api.get();
  }
}