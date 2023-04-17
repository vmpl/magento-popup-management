define([
    'jquery',
    'uiComponent',
    'Magento_Ui/js/modal/modal',
    'domReady!'
], function ($, Component, modal) {
    const storage = class {
        #storageKey;
        #elementKey;
        #data = {};
        constructor(storageKey, elementKey) {
            this.#storageKey = storageKey;
            this.#elementKey = elementKey;
            this.#data = JSON.parse(localStorage.getItem(this.#storageKey) ?? '{}');
        }

        get count() {
            return this.#data.hasOwnProperty(this.#elementKey)
                ? ~~this.#data[this.#elementKey]
                : 0;
        }

        set count(index) {
            this.#data[this.#elementKey] = index;
            localStorage.setItem(this.#storageKey, JSON.stringify(this.#data));
        }
    }

    return Component.extend({
        defaults: {
            waitTime: 3000,
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

            const modalSettings = this.modalSettings;
            modalSettings.opened = this.onOpened.bind(this)
            this.popup = modal(modalSettings, $(this.element));

            if (!this.element.id) {
                return console.warn(`Popup element is missing id attribute`);
            }
            this.storage = new storage(this.storageKey, this.element.id ?? 'default')

            if (this.limitOpened !== 0 && this.limitOpened <= this.storage.count) {
                return console.log(`Popup has already been opened ${this.limitOpened} times, skipping...`);
            }

            setTimeout(() => {
                this.popup.openModal();
            }, this.waitTime);
        },
        onOpened() {
            this.storage.count++;
        }
    })
})
