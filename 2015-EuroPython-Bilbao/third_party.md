See also [asyncio.org](http://asyncio.org/) (asyncio resources) and [Trollius](http://trollius.readthedocs.org/) (port of asyncio to Python 2).

# Libraries #

  * [aiofiles](https://github.com/Tinche/aiofiles/): File support for asyncio
  * [aiorwlock](https://pypi.python.org/pypi/aiorwlock): Read write lock for asyncio
  * [aioutils](https://pypi.python.org/pypi/aioutils): Python3 Asyncio Utils, Group (like gevent.pool.Group), Pool (like gevent.pool.Pool), Bag and OrderedBag
  * [tasklocals](https://github.com/vkryachko/tasklocals): Task-local variables

## Unit testing ##

  * [asynctest](https://github.com/Martiusweb/asynctest/): Enhance the standard unittest package for testing asyncio libraries
  * [pytest-asyncio](https://github.com/pytest-dev/pytest-asyncio): Pytest support for asyncio

# Protocols implementations #

## Clients ##

  * **AMQP**: [aioamqp](https://github.com/dzen/aioamqp): AMQP implementation using asyncio (Used by RabbitMQ)
  * **AMI**: [panoramisk](https://panoramisk.readthedocs.org/), a library to play with Asterisk's protocols: AMI and FastAGI
  * **CouchDB**: [aiocouchdb](http://aiocouchdb.readthedocs.org), CouchDB client
  * **DNS**: [aiodns](https://pypi.python.org/pypi/aiodns): Async DNS resolver
  * **ElasticSearch**: [aioes](http://aioes.readthedocs.org/): ElasticSearch client library
  * **Etcd**: [aioetcd](https://github.com/lisael/aioetcd): Coroutine-based etcd client
  * **Google Hangouts**: [hangups](https://github.com/tdryer/hangups): Client for Google Hangouts
  * **HTTP**: [aiohttp.requests](http://aiohttp.readthedocs.org/en/latest/client.html): http client with Requests-like API.
  * **IRC**:
      * [irc3](https://irc3.readthedocs.org/), plugable irc client library based on python's asyncio
      * [bottom](https://github.com/numberoverzero/bottom), asyncio-based rfc2812-compliant IRC Client
  * **memcached**: [aiomemcache](https://github.com/fafhrd91/aiomemcache), minimal memcached client
  * **MongoDB**: [asyncio-mongo](https://bitbucket.org/mrdon/asyncio-mongo), MongoDB driver (ported from Twisted)
  * **MySQL**: [aiomysql](https://github.com/aio-libs/aiomysql), MySQL driver
  * **PostgreSQL**: [aiopg](http://aiopg.readthedocs.org/), PostgreSQL client library built on top of psycopg2
  * **Redis**:
      * [asyncio-redis](http://asyncio-redis.readthedocs.org/), Redis client with pubsub support
      * [aioredis](http://aioredis.readthedocs.org/), Yet another Redis client
  * **SSH**: [AsyncSSH](https://github.com/ronf/asyncssh): SSH client and server implementation
  * **WebSockets**: [aiohttp.ws_connect](http://aiohttp.readthedocs.org/en/latest/client_websockets.html): WebSockets client
  * **XMPP (Jabber)**: [slixmpp](http://git.poez.io/slixmpp), SleekXMPP (XMPP Library) fork using asyncio, for poezio

## Servers ##

  * **FastAGI**: [panoramisk](https://panoramisk.readthedocs.org/), a library to play with Asterisk's protocols: AMI and FastAGI
  * **IRC**: [irc3d](https://github.com/gawel/irc3/tree/master/irc3d), irc server library based on irc3
  * **HTTP**: [aiohttp](https://github.com/KeepSafe/aiohttp): http client and server infrastructure for asyncio
  * **SSH**: [AsyncSSH](https://github.com/ronf/asyncssh): SSH client and server implementation

# Web Frameworks #

## For classical HTTP/1.1 protocol ##

Looking for WSGI? Read this thread: [WSGI implementation compatible with asyncio?](https://groups.google.com/forum/#!topic/python-tulip/Gs3bZ2AbS9o).

  * [aiohttp.web](http://aiohttp.readthedocs.org/en/latest/web.html): a Flask-like API to build quickly HTTP applications, made by the creators of [aiohttp](https://github.com/KeepSafe/aiohttp).
  * [aiopyramid](https://pypi.python.org/pypi/aiopyramid): Tools for running [pyramid](https://pypi.python.org/pypi/pyramid) using asyncio.
  * [aiowsgi](https://github.com/gawel/aiowsgi): minimalist wsgi server using asyncio
  * [interest](https://pypi.python.org/pypi/interest): event-driven web framework on top of aiohttp/asyncio.
  * [muffin](https://github.com/klen/muffin): A web framework based on Asyncio stack (early alpha)
  * [nacho](https://github.com/avelino/nacho): web framework
  * [Pulsar](http://pythonhosted.org/pulsar/): Event driven concurrent framework for python. With pulsar you can write asynchronous servers performing one or several activities in different threads and/or processes.
  * [rainfall](https://github.com/mind1master/rainfall): another web framework
  * [Vase](https://github.com/vkryachko/Vase): web framework

## For WebSockets ##

  * [aiohttp.web](http://aiohttp.readthedocs.org/en/latest/web.html): a Flask-like API to build quickly HTTP applications, made by the creators of [aiohttp](https://github.com/KeepSafe/aiohttp).
  * [AutobahnPython](https://github.com/tavendo/AutobahnPython): WebSocket and WAMP framework
  * [websockets](https://github.com/aaugustin/websockets): Websockets library
  * [WebSocket-for-Python](https://github.com/Lawouach/WebSocket-for-Python): another websocket library

# ORMs #

  * [aiopg.sa](http://aiopg.readthedocs.org/en/stable/sa.html): support for SQLAlchemy functional SQL layer, based on aiopg
  * [peewee](https://peewee.readthedocs.org/): [peewee-async](http://peewee-async.readthedocs.org/en/latest/), library providing asynchronous interface powered by asyncio for peewee ORM.

# Integration with other applications #

  * [API-Hour](https://pypi.python.org/pypi/api_hour): Transform easily your AsyncIO server source code (HTTP, SSH, ...) to be multiprocess: it will help to improve the efficency on multi-CPU servers.
  * [Gunicorn](http://www.gunicorn.org/): Gunicorn has gaiohttp worker built on top of aiohttp library

# Applications built with AsyncIO #

* [ktcal2](https://github.com/cr0hn/ktcal2): SSH brute forcer tool and library, using AsyncIO of Python 3.4

# Run asyncio on top of #

  * eventlet: [aiogreen](http://aiogreen.readthedocs.org/), asyncio API implemented on top of eventlet
  * gevent: [aiogevent](https://pypi.python.org/pypi/aiogevent), asyncio API implemented on top of gevent

# Adapters for other event loops #

Some people have already written adapters for integrating asyncio with other async I/O frameworks.

  * [eventlet](http://eventlet.net/): [greenio](https://github.com/1st1/greenio), Greenlets support for asyncio (PEP 3156)
  * [gevent](http://www.gevent.org/): [tulipcore](https://github.com/decentfox/tulipcore), run gevent code on top of asyncio, alternative gevent core loop
  * GLib: [gbulb](https://bitbucket.org/a_ba/gbulb), event loop based on GLib
  * [libuv](https://github.com/libuv/libuv): [aiouv](https://github.com/saghul/aiouv), an event loop implementation for asyncio based on [pyuv](https://pyuv.readthedocs.org/)
  * Qt: [Quamash](https://github.com/harvimt/quamash), implementation of the PEP 3156 Event-Loop with Qt.
  * [Tornado](https://github.com/facebook/tornado) has [experimental asyncio support](https://groups.google.com/forum/#!topic/python-tulip/hg0HzhoPuFE) built right into it.
  * [ZeroMQ](http://zeromq.org/):
    * [aiozmq](http://aiozmq.readthedocs.org/), ZeroMQ integration with asyncio
    * [Zantedeschia](https://github.com/takluyver/Zantedeschia), experimental alternative integration between asyncio and ZeroMQ sockets.

# Misc #

  * [aioauth-client](https://github.com/klen/aioauth-client): OAuth1/2 support (authorization, resource's loading)
  * [aiocron](https://github.com/gawel/aiocron/): Crontabs for asyncio
  * [aiomas](http://stefan.sofa-rockers.org/2015/02/13/aiomas/): A library for multi-agent systems and RPC based on asyncio
  * [aiotest](https://bitbucket.org/haypo/aiotest/): test suite to validate an implementation of the asyncio API
  * [aioprocessing](https://github.com/dano/aioprocessing): A Python 3.3+ library that integrates the multiprocessing module with asyncio
  * [blender-asyncio](https://github.com/akloster/blender-asyncio): Asyncio Bridge for Blender Python API
  * [ipython-yf](https://github.com/tecki/ipython-yf):  An ipython extension to make it asyncio compatible
  * [aiogearman](https://github.com/jettify/aiogearman): asyncio [gearman](http://gearman.org/) support. Gearman provides a generic application framework to farm out work to other machines or processes that are better suited to do the work.
  * Serial port using the serial module, see [using serial port in python3 asyncio](https://stackoverflow.com/questions/21666106/using-serial-port-in-python3-asyncio) at Stackoverflow, serial.Serial can be registered with loop.add\_reader().
  * [GoogleScraper](https://github.com/NikolaiT/GoogleScraper): A Python module to scrape several search engines (like Google, Yandex, Bing, Duckduckgo, Baidu and others) by using proxies (socks4/5, http proxy) and with many different IP's.

# Filesystem #

asyncio does **not** support asynchronous operations on the filesystem. Even if files are opened with O\_NONBLOCK, read and write will block.

Read [asynchronous disk I/O](http://blog.libtorrent.org/2012/10/asynchronous-disk-io/) (October 2012 by arvid).

The Linux kernel provides asynchronous operations on the filesystem (aio), but it requires a library and it doesn't scale with many concurrent operations. See [aio](http://lse.sourceforge.net/io/aio.html).

The GNU C library (glibc) implements the POSIX aio interface, but it is implemented with threads. See [aio(7) manual page](http://man7.org/linux/man-pages/man7/aio.7.html).

Recent discussion on the Linux Kernel: [Non-blocking buffered file read operations](http://lwn.net/Articles/612483/) (September 2014).

For now, the workaround is to use [aiofiles](https://github.com/Tinche/aiofiles/) that uses threads to handle files.
