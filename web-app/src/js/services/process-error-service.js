import WebApi from "./web-api";
import SingleCountResponse from "../models/single-count-response";
import ProcessErrorRegistersResponse from "../models/process-error-registers-response";

export default class ProcessErrorService {
  constructor(host = "") {
    this.host = host;
  }

    async getLastProcessErrors(limit) {
    const data = {
      limit,
    };

    let api = new WebApi(`${this.host}/api/process/error`, data);
    api.converter = ProcessErrorRegistersResponse.makeFromObject;

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

    let api = new WebApi(`${this.host}/api/error`, data);
    api.converter = ProcessErrorRegistersResponse.makeFromObject;

    return await api.get();
  }

  async getFilteredRegistersCount(startDatetime, endDatetime, filterDateType = 1) {
    const data = {
      startDatetime,
      endDatetime,
      filterDateType,
    };

    let api = new WebApi(`${this.host}/api/error/count`, data);

    return await api.get();
  }
}

