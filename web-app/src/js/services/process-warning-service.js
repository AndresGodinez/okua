import WebApi from "./web-api";
import SingleCountResponse from "../models/single-count-response";
import ProcessWarningRegistersResponse from "../models/process-warning-registers-response";

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
}

