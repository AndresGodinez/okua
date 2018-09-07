import TokenUtils from "./token-utils";
import RoutesUtils from "./route-utils";
import WebApi from "../services/web-api";

export const HOST_API = process.env.MIX_HOST_API;

/**
 * @param {number} ms
 * @return {Promise<any>}
 */
export const delay = ms => new Promise(_ => setTimeout(_, ms));

/** @class */
export default class AppUtils {
  /**
   * Logout process
   */
  static logout() {
    // clear the stored token
    TokenUtils.clear();

    // go to login page
    RoutesUtils.goLogin();
  }

  static getIdMeta() {
    let $elements = document.head.querySelector('meta[name="okua:id"]');

    if (!$elements) throw 'Error. ID not present';

    return $elements.getAttribute('content');
  }
}
