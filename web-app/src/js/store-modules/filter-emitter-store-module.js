import Vue from 'vue';
//Related models
import FilterEmitter from "../models/filter-emitter";
//Relate services
import FilterEmitterService from "../services/filter-emitter-service";
// hostapi connection
import {HOST_API} from "../utils/app-utils";

//instance models classes
/** @type {FilterEmitter} **/
let filterEmitter = new FilterEmitter();

//instance services classes
/** @type {FilterEmitterService} **/
let filterEmitterService = new FilterEmitterService(HOST_API);

const types = {

};

const state = {
  filterEmitter,
  filterEmitterService,
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
