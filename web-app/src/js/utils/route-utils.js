export default class RouteUtils {
  static getLogin() {
    window.location.replace('/app/login');
  }
  static getlogOut(){
    window.location.replace('/app/logout');
  }

  static goBills() {
    window.location.replace('/app/bills');
  }

  static goProcessWarnings() {
    window.location.replace('/app/process-warnings');
  }

  static goProcessErrors() {
    window.location.replace('/app/process-errors');
  }

  static goModuleProviders() {
    window.location.replace('/app/providers/home');
  }

  static goHome() {
    window.location.replace('/app');
  }

  static adminSections(urlAddress) {
    window.location.replace('/admin' + urlAddress);
  }
}