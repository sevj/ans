class ANS {
  constructor(fqcn, id, callback) {
    this.fqcn = fqcn;
    this.id   = id;
    this.callback = callback;

    this.constructTopic();
    this.listen();
  }

  constructTopic()
  {
    this.topic = 'notifications-' + this.fqcn + '-' + this.id;
  }

  listen()
  {
    const url = new URL('http://localhost:3000/.well-known/mercure');
    url.searchParams.append('topic', this.topic);
    console.log(url)
    const eventSource = new EventSource(url);

// The callback will be called every time an update is published
    eventSource.onmessage = e => this.callback(e); // do something with the payload
  }
}
