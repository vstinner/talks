Durata: 30 minuti (inc. Q&A)

asyncio launch
==============

* Python 3.4: March 2014
* Almost naked: very few libraries

asyncio moved to Github
=======================

* code.google.com is closing
* Move from code.google.com to Github
* Use Git instead of Mercurial: Git is more popular
* Github is widely used, pull requests are simpler
* At least 26 contributors to asyncio

Discussion
==========

* python-tulip mailing list (Google Group)
* #asyncio IRC channel on the Freenode network
* Python bug tracker (bugs.python.org)

aiohttp
=======

* Most famous and successful project
* HTTP Client and HTTP Server.
* (HTTPS support)
* Server WebSockets and Client WebSockets out-of-the-box
* Web-server has Middlewares and pluggable routing
* https://aiohttp.rtfd.org

* aiohttp: http client and server infrastructure for asyncio
* aiohttp is battle tested

Client::

    @asyncio.coroutine
    def fetch_page(url):
        response = yield from aiohttp.request('GET', url)
        assert response.status == 200
        return (yield from response.read())

SQL drivers
===========

 * MySQL: aiomysql
 * PostgreSQL: aiopg (based on psycopg2)

::

    dsn = 'dbname=aiopg user=aiopg password=passwd host=127.0.0.1'

    @asyncio.coroutine
    def go():
        pool = yield from aiopg.create_pool(dsn)
        with (yield from pool.cursor()) as cur:
            yield from cur.execute("SELECT 1")
            ret = yield from cur.fetchone()
            assert ret == (1,)

ORM
===

 * peewee ORM: peewee-async
 * aiopg.sa: SQLAlchemy functional SQL layer based on aiopg

Key-value store
===============

 * memcached: aiomemcache, minimal memcached client
 * redis: aioredis
 * redis: asyncio-redis

aioredis::

    # No pipelining
    @asyncio.coroutine
    def wait_each_command():
        foo = yield from redis.get('foo')
        bar = yield from redis.incr('bar')
        return foo, bar

    # Sending multiple commands and then gathering results
    @asyncio.coroutine
    def pipelined():
        get = redis.get('foo')
        incr = redis.incr('bar')
        foo, bar = yield from asyncio.gather(get, incr)
        return foo, bar

NoSQL
=====

 * CouchDB: aiocouchdb
 * MongoDB: asyncio-mongo (ported from Twisted)

Clients
=======

Unsorted:

  * AMQP: aioamqp: AMQP implementation using asyncio (Used by RabbitMQ)
  * AMI: panoramisk, a library to play with Asterisk's protocols: AMI and FastAGI
  * DNS: aiodns: Async DNS resolver
  * ElasticSearch: aioes: ElasticSearch client library
  * Etcd: aioetcd: Coroutine-based etcd client
  * Google Hangouts: hangups: Client for Google Hangouts
  * SSH: AsyncSSH: SSH client and server implementation
  * XMPP (Jabber): slixmpp, SleekXMPP (XMPP Library) fork using asyncio, for poezio

Clients
=======

 * Asterisk: panoramisk, a library based on python’s asyncio to play with asterisk's manager
 * !ElasticSearch: aioes, client library
 * IRC: irc3, plugable irc client library based on python's asyncio
 * IRC: bottom, asyncio-based rfc2812-compliant IRC Client
 * XMPP (Jabber): slixmpp, SleekXMPP (XMPP Library) fork using asyncio, for poezio

Websockets
==========

 * aiohttp.web: a Flask-like API to build quickly HTTP applications, made by the creators of aiohttp.
 * AutobahnPython: WebSocket and WAMP framework
 * websockets: Websockets library
 * WebSocket-for-Python: another websocket library

Web frameworks
==============

 * aiopyramid: Tools for running pyramid using asyncio.
 * aiowsgi: minimalist wsgi server using asyncio
 * API hour: Write efficient network daemons (HTTP, SSH, ...) with ease.
 * AutobahnPython: !WebSocket and WAMP framework
 * interest: event-driven web framework on top of aiohttp/asyncio.
 * muffin: A web framework based on Asyncio stack (early alpha)
 * nacho: web framework
 * Pulsar: Event driven concurrent framework for python. With pulsar you can write asynchronous servers performing one or several activities in different threads and/or processes.
 * rainfall: another web framework
 * Vase: web framework
 * websockets: Websockets library
 * WebSocket-for-Python: another websocket library

 Others: ...

Servers
=======

 * FastAGI: panoramisk, a library to play with Asterisk's protocols: AMI and FastAGI
 * IRC: irc3d, irc server library based on irc3
 * HTTP: aiohttp: http client and server infrastructure for asyncio
 * SSH: AsyncSSH: SSH client and server implementation

aiohttp web server::

    @asyncio.coroutine
    def hello(request):
        return web.Response(body=b"Hello, world")

    app = web.Application()
    app.router.add_route('GET', '/', hello)


Integration with other application libraries
============================================

 * aioamqp: AMQP implementation using asyncio
 * gunicorn: gunicorn has gaiohttp worker built on top of aiohttp library

Run asyncio on top of
=====================

 * eventlet: aiogreen, asyncio API implemented on top of eventlet
 * gevent: aiogevent, asyncio API implemented on top of gevent

Adapters for other event loops
==============================

Some people have already written adapters for integrating asyncio with other
async I/O frameworks.

 * eventlet: greenio, Greenlets support for asyncio (PEP 3156)
 * gevent: tulipcore, run gevent code on top of asyncio, alternative gevent core loop
 * GLib: gbulb, event loop based on GLib
 * libuv: aiouv, an event loop implementation for asyncio based on pyuv
 * Qt: Quamash, implementation of the PEP 3156 Event-Loop with Qt.
 * Tornado has experimental asyncio support built right into it.
 * ZeroMQ: aiozmq, ZeroMQ integration with asyncio
 * ZeroMQ: Zantedeschia, experimental alternative integration between asyncio and ZeroMQ sockets.

Misc
====

 * aiocron: Crontabs for asyncio
 * aiomas: A library for multi-agent systems and RPC based on asyncio
 * aiotest: test suite to validate an implementation of the asyncio API
 * aioprocessing: A Python 3.3+ library that integrates the multiprocessing module with asyncio
 * blender-asyncio: Asyncio Bridge for Blender Python API
 * ipython-yf:  An ipython extension to make it asyncio compatible
 * aiogearman: asyncio gearman support. Gearman provides a generic application framework to farm out work to other machines or processes that are better suited to do the work.
 * Serial port using the serial module, see using serial port in python3 asyncio at Stackoverflow, serial.Serial can be registered with loop.add_reader().

Libraries
=========

 * aiofiles: File support for asyncio
 * aiodns: Async DNS resolver
 * aiorwlock: Read write lock for asyncio.
 * aioutils: Python3 Asyncio Utils, Group (like gevent.pool.Group), Pool (like event.poo.Pool), Bag and OrderedBag.
 * tasklocals: Task-local variables

API-Hour benchmark
=================

* Django, Flask, API-Hour
* Round 5: 50 simultaneous connections with wrk
* between 3000 and 3600 requests/second for API-Hour (asyncio)
* between 600 and 628 requests/second for Django and Flask
* All benchmarks at http://blog.gmludo.eu/

API-Hour benchmark
=================

* Simple JSON document
* API-Hour: around 395,847 requests/second
* Django, Flask: between 70,598 and 79,598 requests/second
* API-Hour handles around 5x more requests per second

API-Hour benchmark
=================

* All benchmarks at http://blog.gmludo.eu/

Trollius
========

* Trollius is the Python 2 port of asyncio
* Work on Python 2.6 - 3.6
* Trollius 2.0

Links
=====

* http://asyncio.org/: Libraries, Docs, Talks, Tutorials, Blogs
* ThirdParty wiki page
* https://github.com/python/asyncio/wiki/ThirdParty

How can you help?
=================

* Need tutorials and more documentation on asyncio!
* https://docs.python.org/dev/library/asyncio.html is more a boring reference
  API doc
* Port more stdlib modules to asyncio: ftplib, poplib, imaplib, nntplib,
  smtplib, smtpd, telnetlib, xmlrpc, etc.
* Interoperability with Twisted

Questions
=========



Sources of photos
=================

* https://www.flickr.com/photos/gotovan/7126982137/
* https://www.flickr.com/photos/pankseelen/6856818098/
* https://www.flickr.com/photos/ewestrum/4590703575/
* https://www.flickr.com/photos/keroyama/13793000744/
* https://www.flickr.com/photos/freetheimage/13197345653/
* https://www.flickr.com/photos/31064702@N05/3558517884/
* https://www.flickr.com/photos/aidanmorgan/2256230386/
* https://www.flickr.com/photos/duncanh1/7335557978/
* https://www.flickr.com/photos/ewestrum/4590702749/
* https://www.flickr.com/photos/sis/490541142/
* https://www.flickr.com/photos/pankseelen/5468062766/
* https://www.flickr.com/photos/pankseelen/5470825013/in/photostream/
* https://www.flickr.com/photos/pankseelen/5468062632/in/photostream/



