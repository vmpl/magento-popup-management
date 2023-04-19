define([
    'text!/vmpl-popup/config/?filter[]=HashTriggerRegex',
    'mage/apply/main'
], function (popupConfig, main) {
    let { HashTriggerRegex } = JSON.parse(popupConfig);
    HashTriggerRegex = new RegExp(HashTriggerRegex);

    return function () {
        const matches = window.location.hash.match(HashTriggerRegex) ?? [];
        const identifier = matches.shift();
        if (!identifier) {
            return;
        }

        fetch(`/vmpl-popup/popup/trigger/identifier/${identifier}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }

                return response.text();
            })
            .then(content => {
                const containerElement = document.createElement('template');
                containerElement.classList.add('container');
                containerElement.innerHTML = content;

                Array.from(containerElement.children).forEach(child => {
                    document.body.append(child);
                    main.apply(child);
                })
            })
            .catch(error => {
                console.error(error);
            })
    }
})
