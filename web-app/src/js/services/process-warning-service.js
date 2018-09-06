import WebApi from "./web-api";
import SingleCountResponse from "../models/single-count-response";
import ProcessWarningRegistersResponse from "../models/process-warning-registers-response";
import WarningFilteredRegistersResponse from "../models/warning-filtered-registers-response";

export default class ProcessWarningService {
  constructor(host = "") {
    this.host = host;
  }

    async getLastProcessWarnings(limit) {
    const data = {
      limit,
    };

    let api = new WebApi(`${this.host}/api/process/warning`, data);
    api.converter = ProcessWarningRegistersResponse.makeFromObject;

    return await api.get();
  }

  async getEveryProcessWarning(){
    let api = new WebApi(`${this.host}/api/process/warning/all`);
    api.converter = ProcessWarningRegistersResponse.makeFromObject;

    return await api.get();
  }

  async getFilteredRegisters(limit, offset, startDatetime, endDatetime, filterDateType = 1) {
    const data = {
      limit,
      offset,
      startDatetime,
      endDatetime,
      filterDateType,
    };

    let api = new WebApi(`${this.host}/api/warning`, data);
    api.converter = WarningFilteredRegistersResponse.makeFromObject;

    return await api.get();
  }

  async getFilteredRegistersCount(startDatetime, endDatetime, filterDateType = 1) {
    const data = {
      startDatetime,
      endDatetime,
      filterDateType,
    };

    let api = new WebApi(`${this.host}/api/warning/count`, data);

    return await api.get();
  }
}

