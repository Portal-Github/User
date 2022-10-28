((Github, {path, excludedMessages, excludedUserAgents, maximumMessages, showDetails}) => {
  let messagesSent = 0
  if (new RegExp(excludedUserAgents).test(navigator.userAgent)) {
    return false
  }

  // Use a request queue to prevent DoS-ing the server in infinite loops
  let requestQueue = Promise.resolve()

  const log = (...messages) => {
    messages.filter(message => !excludedMessages.includes(message)).forEach(message => {
      if (messagesSent++ < maximumMessages) {
        sendMessage(message)
      }
      else if (messagesSent === maximumMessages) {
        sendMessage({
          value: Drupal.t('Maximum messages exceeded'),
          type: 'notice'
        })
      }
    })
  }

  const sendMessage = (message) => {
    requestQueue = requestQueue.then(async () => {
      dispatchEvent(new CustomEvent('jslog', {detail: message}))
      await fetch(path, {method: 'POST', body: JSON.stringify(message)})
    })
  }

  // Store the original methods
  const originalConsole = Object.assign({}, console);

  [
    {name: 'warn', type: 'warning'},
    {name: 'debug', type: 'debug'},
    {name: 'error', type: 'error'},
    {name: 'info', type: 'info'},
    {name: 'log', type: 'info'},
  ].forEach(({name, type}) => {
    console[name] = (...messages) => {
      originalConsole[name](...messages)
      log(...(messages.map(e => ({
        message: e.toString?.(),
        type,
      }))))
    }
  })

  addEventListener('error', ({message, filename, lineno, colno}) => {
    log({message: `${message}, ${filename} ${lineno}:${colno}`, type: 'error'})
  })

  addEventListener('unhandledrejection', ({reason}) => {
    log({message: reason.stack || reason.message, type: 'notice'})
  })
})(Github, githubSettings.jslog)
