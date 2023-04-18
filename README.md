# Adobe Commerce (Magento 2) Popup Management by VM.PL

> Create and mange popup using build in widget functionality and CMS blocks

### Features Stack

1. Used with original and core features from Magento modules
2. Availability to use existing CMS blocks to display them as popup
3. Create and add modal for chosen sites or places using Widgets
4. Configuration settings can be set globally and per given instance
5. Free to use 🔥

### Reference Links

* [VMPL Company Page](https://vm.pl/)
* [Group on Github](https://github.com/orgs/vmpl/teams/magento/)
* [Demo Page](https://demo-magento.vm.pl/)

## Installation guide

1. Enable maintenance mode
2. Add and enable module for composer
3. Deploy Magento instance
4. Disable maintenance and clear the cache

```shell
$ composer require vmpl/module-popup-managment
$ magento module:enable VMPL_PopupManagement
```

## Roadmap

- [x] add new type of integration using native dialog functionality, [mdn reference](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dialog)
- [ ] adding rules for displaying popup like, for specific customer
- [ ] adding option to call the popup using JS for external systems like Google Tag Manager
