import WebApi from "./web-api";
import BillsTotalResponse from "../models/bills-total-response";
import BillInfoLastRegistersResponse from "../models/bill-info-last-registers-response";
import BillInfoEmailLastRegistersResponse from "../models/bill-info-email-last-registers-response";
import BillInfoFilteredRegistersCountResponse from "../models/bill-info-filtered-registers-count-response";
import BillInfoFilteredRegistersResponse from "../models/bill-info-filtered-registers-response";
import BillInfoGroupByClientResponse from "../models/bill-info-group-by-client-response";
import BillInfoGroupByCfdiUseResponse from "../models/bill-info-group-by-cfdi-use-response";
import BillInfoGroupByEmailResponse from "../models/bill-info-group-by-email-response";
import SingleCountResponse from "../models/single-count-response";

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

  async getBillsTransferTotal(filter) {
    const data = {
      filter,
    };

    let api = new WebApi(`${this.host}/api/bill-info/taxes/transfer/total`, data);
    api.converter = BillsTotalResponse.makeFromObject;

    return await api.get();
  }

  async getBillsWithheldTotal(filter) {
    const data = {
      filter,
    };

    let api = new WebApi(`${this.host}/api/bill-info/taxes/withheld/total`, data);
    api.converter = BillsTotalResponse.makeFromObject;

    return await api.get();
  }

  async getLastEmailRegisters(limit) {
    const data = {
      limit,
    };

    let api = new WebApi(`${this.host}/api/bill-info/email/last-registers`, data);
    api.converter = BillInfoEmailLastRegistersResponse.makeFromObject;

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

  async getFilteredRegisters(limit, offset, startDatetime, endDatetime, clientRfc = '', initialAmount = 0.00, finalAmount = 0.00, filterDateType = 1) {
    const data = {
      limit,
      offset,
      startDatetime,
      endDatetime,
      clientRfc,
      initialAmount,
      finalAmount,
      filterDateType,
    };

    let api = new WebApi(`${this.host}/api/bill-info`, data);
    api.converter = BillInfoFilteredRegistersResponse.makeFromObject;

    return await api.get();
  }

  async getFilteredRegistersCount(startDatetime, endDatetime, clientRfc = '', initialAmount = 0.00, finalAmount = 0.00, filterDateType = 1) {
    const data = {
      startDatetime,
      endDatetime,
      clientRfc,
      initialAmount,
      finalAmount,
      filterDateType,
    };

    let api = new WebApi(`${this.host}/api/bill-info/count`, data);
    api.converter = BillInfoFilteredRegistersCountResponse.makeFromObject;

    return await api.get();
  }

  async getBillInfoXls(startDatetime, endDatetime, clientRfc = '', initialAmount = 0.00, finalAmount = 0.00, filterDateType = 1){
    const data = {
      startDatetime,
      endDatetime,
      clientRfc,
      initialAmount,
      finalAmount,
      filterDateType,
    };

    let api = new WebApi(`${this.host}/api/bill-info/xls`, data);
    api.converter = BillInfoFilteredRegistersResponse.makeFromObject;

    return await api.get();
  }

  async getDataGroupedByClientAndFilterCount(filter) {
    const data = {
      filter,
    };

    let api = new WebApi(`${this.host}/api/bill-info/group-by/client/count`, data);
    api.converter = SingleCountResponse.makeFromObject;

    return await api.get();
  }

  async getDataGroupedByClientAndFilter(limit, offset, filter) {
    const data = {
      limit,
      offset,
      filter,
    };

    let api = new WebApi(`${this.host}/api/bill-info/group-by/client`, data);
    api.converter = BillInfoGroupByClientResponse.makeFromObject;

    return await api.get();
  }

  async getDataGroupedByCfdiUseAndFilter(filter) {
    const data = {
      filter,
    };

    let api = new WebApi(`${this.host}/api/bill-info/group-by/cfdi-use`, data);
    api.converter = BillInfoGroupByCfdiUseResponse.makeFromObject;

    return await api.get();
  }

  async getDataGroupedByEmailAndFilter(filter){
    const data = {
      filter,
    };

    let api = new WebApi(`${this.host}/api/bill-info/group-by/email`, data);
    api.converter = BillInfoGroupByEmailResponse.makeFromObject;

    return await api.get();
  }
}