# About

**Status Dashboard API** is a wrapper for Uptime Robot's API to be consumed by **Status Dashboard Frontend**.

The frontend consumes Uptime Robot's API with read-only keys, so them can be in the public repository and the web page can be hosted at Github Pages with no security issues.

A read-only key has access to a single monitor. To avoid making as many requests as the number of monitors enabled, this wrapper makes a single request with a full access key and gets data from all monitors at once.

In case this wrapper (https://api.status.afonso.io) is down,  **Status Dashboard Frontend** automatically falls back to Uptime Robot's API.

# Links

  - Frontend: https://status.afonso.io
  - Frontend source: https://github.com/afonsodemori/aio-status
  - API: https://api.status.afonso.io
  - API source: *(this repo)*
