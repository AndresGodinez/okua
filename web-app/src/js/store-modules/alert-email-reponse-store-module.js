import Vue from 'vue';
//Related models
import AlertEmailResponse from "../models/alert-email-response";
//Relate services
import AlertEmailResponseService from "../services/alert-email-response-service";
// hostapi connection
import {HOST_API} from "../utils/app-utils";

//instance models classes
/** @type {AlertEmailResponse} **/
let alertEmailResponse = new AlertEmailResponse();

//instance services classes
/** @type {AlertEmailResponseService} **/
let alertEmailResponseService = new AlertEmailResponseService(HOST_API);

const types = {

};

const state = {
  alertEmailResponse,
  alertEmailResponseService,
};

const getters = {

};

const actions = {

};

const mutations = {

};

export default {
  state,
  getters,
  actions,
  mutations,
}
