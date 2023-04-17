define([
    'jquery',
    'uiComponent',
    'Magento_Ui/js/modal/modal',
    'VMPL_PopupManagement/js/lib/storage',
    'VMPL_PopupManagement/js/action/animateCss',
    'domReady!',
], function ($, Component, modal, storage, animateCss) {
    return Component.extend({
        defaults: {
            waitTime: 3000,
            closeTimeout: 0,
            limitOpened: 0,
            storageKey: 'vmpl__popup_displayed',
            modalSettings: {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                buttons: []
            }
        },
        initialize(config, element) {
            this._super(config, element);
            this.element = element;
            if (!this.element.id) {
                return console.warn(`Popup element is missing id attribute`);
            }
            this.storage = new storage(this.storageKey, this.element.id ?? 'default')

            this.limitOpened = Number.parseInt(this.limitOpened)
            this.limitOpened = Number.isNaN(this.limitOpened) ? 0 : this.limitOpened;
            if (this.limitOpened !== 0 && this.limitOpened <= this.storage.count) {
                this.element.remove();
                return console.log(`Popup has already been opened ${this.limitOpened} times, skipping...`);
            }

            if (this.element instanceof HTMLDialogElement) {
                this.initDialog();
            } else {
                this.initModal();
            }

            setTimeout(() => {
                this.popup.openModal();
            }, this.waitTime);
        },
        onOpened() {
            this.storage.count++;

            if (this.closeTimeout > 0) {
                this.progressElement = document.createElement('div');
                this.progressElement.classList.add('progress-timeout');
                this.progressElement.style.transitionDuration = `${this.closeTimeout}ms`;
                this.element.parentElement.prepend(this.progressElement);

                this.closeTimeoutHandler = setTimeout(() => {
                    this.popup.closeModal();
                }, this.closeTimeout)

                setTimeout(() => {
                    this.progressElement.classList.add('start');
                });
            }
        },
        onClose() {
            clearTimeout(this.closeTimeoutHandler);
            this.progressElement?.remove();
        },
        initDialog() {
            const {animationIn, animationOut} = this.modalSettings.type !== 'slide'
                ? {animationIn: 'fadeInDown', animationOut: 'fadeOutDown'}
                : {animationIn: 'slideInRight', animationOut: 'slideOutRight'};

            this.popup = {
                openModal: () => {
                    animateCss(this.element, animationIn);
                    this.element.showModal()
                },
                closeModal: () => {
                    animateCss(this.element, animationOut).then(() =>{
                        this.element.close();
                    })
                },
            };

            this.element.classList.add(`type-${this.modalSettings.type}`);
            this.element.open = false;
            this.element.addEventListener('close', this.onClose.bind(this));
            this.element.addEventListener('cancel', this.onClose.bind(this));

            this.element.querySelectorAll('form[method=dialog] .action-close').forEach(it => {
                it.addEventListener('click', this.popup.closeModal.bind(this));
            });

            if (this.modalSettings.clickableOverlay) {
                const overlayHandler = (event) => {
                    const dialogRect = this.element.getBoundingClientRect();
                    const isInWidth = event.x > dialogRect.x && event.x < dialogRect.right;
                    const isInHeight = event.y > dialogRect.y && event.y < dialogRect.right;
                    if (isInWidth && isInHeight) {
                        return;
                    }

                    this.popup.closeModal();
                    document.removeEventListener('click', overlayHandler);
                };
                document.addEventListener('click', overlayHandler, {passive: true});
            }

            setTimeout(() => {
                this.popup.openModal();
                this.onOpened();
            }, this.waitTime);
        },
        initModal() {
            const modalSettings = this.modalSettings;
            modalSettings.opened = this.onOpened.bind(this);
            modalSettings.closed = this.onClose.bind(this);
            this.popup = modal(modalSettings, $(this.element));
        }
    })
})
