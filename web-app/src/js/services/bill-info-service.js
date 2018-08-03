import WebApi from "./web-api";
import BillsTotalResponse from "../models/bills-total-response";
import BillInfoLastRegistersResponse from "../models/bill-info-last-registers-response";
import BillInfoFilteredRegistersCountResponse from "../models/bill-info-filtered-registers-count-response";
import BillInfoFilteredRegistersResponse from "../models/bill-info-filtered-registers-response";
import GroupByClientTableRow from "../models/group-by-client-table-row";
import BillInfoGroupByClientResponse from "../models/bill-info-group-by-client-response";

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

  async getFilteredRegisters(limit, offset, startDatetime, endDatetime, clientRfc = '', initialAmount = 0.00, finalAmount = 0.00) {
    const data = {
      limit,
      offset,
      startDatetime,
      endDatetime,
      clientRfc,
      initialAmount,
      finalAmount,
    };

    let api = new WebApi(`${this.host}/api/bill-info`, data);
    api.converter = BillInfoFilteredRegistersResponse.makeFromObject;

    return await api.get();
  }

  async getFilteredRegistersCount(startDatetime, endDatetime, clientRfc = '', initialAmount = 0.00, finalAmount = 0.00) {
    const data = {
      startDatetime,
      endDatetime,
      clientRfc,
      initialAmount,
      finalAmount,
    };

    let api = new WebApi(`${this.host}/api/bill-info/count`, data);
    api.converter = BillInfoFilteredRegistersCountResponse.makeFromObject;

    return await api.get();
  }

  async getDataGroupedByClientAndFilter(filter) {
    const data = {
      filter,
    };

    let api = new WebApi(`${this.host}/api/bill-info/group-by/client`, data);
    api.converter = BillInfoGroupByClientResponse.makeFromObject;

    return await api.get();
  }
}