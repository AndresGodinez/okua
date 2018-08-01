/**
 * Created by alberto on 27/06/17.
 */

import swal from 'sweetalert';

export const TYPES = {
  WARNING: 'warning',
  SUCCESS: 'success',
  ERROR: 'error',
};

export default class AlertUtils {
  static showTestAlert() {
    swal("Test alert!");
  }

  /**
   * Shows error message alert
   *
   * @param {Object} error
   * @param {?string} error.message
   * @param {?string} error.Message
   */
  static showApiErrorMsgAlert(error) {
    return AlertUtils.showErrorWithAlert(error);
  }

  /**
   * Shows error alert with message and
   *
   * @param {Object} error
   * @param {?string} error.msg
   * @param {?string} error.Message
   * @param {Function} cb
   * @param {Object|null} options
   */
  static showErrorWithAlert(error, cb = null, options = null) {
    let msg = '';
    if (typeof error === 'object' && !!error.msg) {
      msg = error.msg;
    } else if (typeof error === 'object' && !!error.message) {
      msg = error.message;
    } else if (typeof error === 'object' && !!error.Message) {
      msg = error.Message;
    } else if (!!error) {
      msg = error;
    }

    return AlertUtils.showAlert(msg, 'Error', TYPES.ERROR,  options);
  }

  /**
   * Shows warning alert with message
   *
   * @param {string} message
   */
  static showWarningAlert(message) {
    return AlertUtils.showAlert(message, "Atención", TYPES.WARNING);
  }

  /**
   * Shows success alert with message
   *
   * @param {string} message
   * @param {Object|null} options
   */
  static showSuccessAlert(message, options = null) {
    return AlertUtils.showAlert(message, 'Completado', TYPES.SUCCESS,  options);
  }

  static showWarningWithCallbackAlert(message, options = null) {
    return AlertUtils.showAlert(message, 'Atención', TYPES.WARNING, options);
  }

  static showYesNoWarningAlert(message) {
    const buttons = ["No", "Si"];
    return AlertUtils.showWarningAlert(message, {buttons});
  }

  /**
   * Shows alert with message
   * @param {string} text
   * @param {string} title
   * @param {string} icon
   * @param {Object|null} options
   */
  static showAlert(text, title, icon, options = null) {
    // def options
    const closeOnEsc = false;

    const defOptions = {
      title,
      text,
      icon,
      closeOnEsc,
    };

    if (!options) {
      options = {};
    }

    Object.assign(options, defOptions);

    return swal(options);
  }
}
