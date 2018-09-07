import Vue from 'vue';
//Related models
import Emitter from "../models/emitter";
//Relate services
import EmitterService from "../services/emitter-service";
// hostapi connection
import {HOST_API} from "../utils/app-utils";

//instance models classes
/** @type {Emitter} **/
let emitter = new Emitter();

//instance services classes
/** @type {EmitterService} **/
let emitterService = new EmitterService(HOST_API);

const types = {

};

const state = {
  emitter,
  emitterService,
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
