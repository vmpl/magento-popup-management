define([
    'text!/vmpl-popup/config/?filter[]=HashTriggerRegex'
], function (popupConfig) {
    let { HashTriggerRegex } = JSON.parse(popupConfig);
    HashTriggerRegex = new RegExp(HashTriggerRegex);

    return function () {
        const matches = window.location.hash.match(HashTriggerRegex) ?? [];
        const identifier = matches.shift();
        if (!identifier) {
            return;
        }


    }
})
