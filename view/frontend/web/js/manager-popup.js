require([
    'VMPL_PopupManagement/js/action/lookUpHashPopup',
    'domReady!',
], function (lookUpHashPopup) {
    lookUpHashPopup();
    window.addEventListener('popstate', lookUpHashPopup, {passive: true});
})
