import Vue from 'vue';
//Related models
import User from "../models/user";
//Relate services
import UserService from "../services/user-service";
// hostapi connection
import {HOST_API} from "../utils/app-utils";

//instance models classes
/** @type {User} **/
let user = new User();

//instance services classes
/** @type {UserService} **/
let userService = new UserService(HOST_API);

const types = {

};

const state = {
  user,
  userService,
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
