export default class RouteUtils {
  static getLogin() {
    window.location.replace('/app/login');
  }

  static goBills() {
    window.location.replace('/app/bills');
  }

  static goModuleProviders() {
    window.location.replace('/app/providers/home');
  }

  static goHome() {
    window.location.replace('/app');
  }
}