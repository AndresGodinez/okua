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
}

