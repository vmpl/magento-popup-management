define([

], function () {
    return class {
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
})
