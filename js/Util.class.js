class Util {

  /**
   * Checks if it is an iOS device
   */
  static iOSDevice() {
    const isIOS    = /Mac|iPad|iPhone|iPod/.test(navigator.userAgent);
    const isMacOS  = navigator.platform.indexOf('Mac') != -1;
    const isSafari = navigator.platform.indexOf('Safari') != -1;

    if (isIOS || isMacOS || isSafari) {
      return true;
    }

    return false;
  }
}
