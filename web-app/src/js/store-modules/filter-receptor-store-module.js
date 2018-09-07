import Vue from 'vue';
//Related models
import FilterReceptor from "../models/filter-receptor";
//Relate services
import FilterReceptorService from "../services/filter-receptor-service";
// hostapi connection
import {HOST_API} from "../utils/app-utils";

//instance models classes
/** @type {FilterReceptor} **/
let filterReceptor = new FilterReceptor();

//instance services classes
/** @type {FilterReceptorService} **/
let filterReceptorService = new FilterReceptorService(HOST_API);

const types = {

};

const state = {
  filterReceptor,
  filterReceptorService,
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
