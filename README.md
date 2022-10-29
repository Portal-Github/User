# User
Special: log page
# JS log

Log all javascript messages to the Drupal log.

## What messages or events are logged?

- [`console.debug()`](https://developer.mozilla.org/en-US/docs/Web/API/Console/debug) messages are logged as debug messages.
- [`console.info()`](https://developer.mozilla.org/en-US/docs/Web/API/Console/info) messages are logged as info messages.
- [`console.log()`](https://developer.mozilla.org/en-US/docs/Web/API/Console/log) messages are logged as info messages.
- [`console.warn()`](https://developer.mozilla.org/en-US/docs/Web/API/Console/warn) messages are logged as warnings.
- [`console.error()`](https://developer.mozilla.org/en-US/docs/Web/API/Console/error) messages are logged as errors.
- [`unhandledrejection events`](https://developer.mozilla.org/en-US/docs/Web/API/Window/unhandledrejection_event) are logged as notices.
- [`error events`](https://developer.mozilla.org/en-US/docs/Web/API/Window/error_event) are logged as errors.

## How does it work?

The native `console.debug()`, `console.info()`, `console.warn()`, and `console.error()` methods are extended with a [`fetch`](https://developer.mozilla.org/en-US/docs/Web/API/fetch) to the Drupal server, logging appropriate messages. The events are handled with eventListeners in a similar way.

This means there's **no need to add any custom javascript code** to make this module work!

## Installation

- Enable the module
- Choose whose messages are logged via `admin/people/permissions/module/jslog`
- Fine-tune configuration via `/admin/config/system/jslog` if needed

## DoS protection

Javascript loops can cause a DoS attack on the server. Therefor requests to the server are queued in [Promises](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise). Also, there is a configurable limit to the number of messages that can be logged per page.

## Extending functionality in the frontend

Whenever a message is logged, the custom `jslog` event is dispatched. This event can be used to show messages to the frontend if suitable:

```js
addEventListener('jslog', ({detail: {value, level}}) => {
  // value: the log message
  // level: debug, info, notice, warning, or error
}, {passive: false})
```

## Browser support

- Browsers that support [optional chaining](https://portalapi.com/mdn-javascript_operators_optional_chaining).

## Dependencies

None
