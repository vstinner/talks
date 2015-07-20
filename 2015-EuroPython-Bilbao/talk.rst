Durata: 30 minuti (inc. Q&A)

Title: The asyncio community, one year later
Subtitle: EuroPython 2015, Bilbao

Victor Stinner
REDHAT

Victor Stinner
==============

* Python core developer since 2010
* Senior Software Engineer at Red Hat
* Port OpenStack to Python 3
* Working remotely from south of France

Agenda
======

* asyncio
* asyncio clients
* asyncio servers
* asyncio other libraries
* benchmark
* trollius

asyncio launch
==============

* Python 3.4: March 2014
* Almost naked: very few libraries
* Feature level: the socket module

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
* More and more conferences on asyncio!

aiohttp
=======

* Most famous and successful asyncio library
* HTTP Client and HTTP Server
* HTTPS support
* Client and Server WebSockets out-of-the-box
* Web-server has Middlewares and pluggable routing
* https://aiohttp.rtfd.org

aiohttp client Hello World::

@asyncio.coroutine
def fetch_page(url):
    response = yield from aiohttp.request('GET', url)
    assert response.status == 200
    return (yield from response.read())

SQL drivers
===========

 * MySQL: aiomysql
 * PostgreSQL: aiopg (based on psycopg2)

aiopg example::

dsn = ('dbname=aiopg host=127.0.0.1 '
       'user=test password=xxx')

@asyncio.coroutine
def go():
    pool = yield from aiopg.create_pool(dsn)
    with (yield from pool.cursor()) as cur:
        yield from cur.execute("SELECT 1")
        ret = yield from cur.fetchone()
        assert ret == (1,)

ORM
===

 * peewee-async: peewee ORM async
 * aiopg.sa: SQLAlchemy functional SQL layer based on aiopg

Key-value store
===============

 * memcached: aiomemcache
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

 * DNS: aiodns (assync DNS resolver)
 * IRC: bottom
 * IRC: irc3
 * SSH: AsyncSSH
 * XMPP (Jabber): slixmpp (fork of SleekXMPP)

 * AMI: panoramisk (AMI and FastAGI)
 * AMQP: aioamqp
 * ElasticSearch: aioes
 * Etcd: aioetcd
 * Google Hangouts: hangups

Websockets
==========

 * aiohttp.web: a Flask-like API
 * AutobahnPython: WebSocket and WAMP framework
 * websockets
 * WebSocket-for-Python

Web frameworks
==============

 * aiopyramid
 * aiowsgi
 * API hour
 * interest
 * muffin
 * nacho
 * Pulsar
 * rainfall
 * Vase

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

 * gunicorn: gunicorn has gaiohttp worker built on top of aiohttp library

Run asyncio on top of
=====================

 * GLib: gbulb
 * Qt: Quamash
 * Tornado: builtin asyncio and trollis support
 * ZeroMQ: Zantedeschia
 * ZeroMQ: aiozmq
 * eventlet: aioeventlet
 * eventlet: greenio
 * gevent: aiogevent
 * gevent: tulipcore
 * libuv: aiouv

Unit tests
==========

 * aiotest: validate an implementation of asyncio
 * asynctest: for unittest
 * pytest-asyncio: for pytest

Misc
====

 * blender-asyncio: Asyncio Bridge for Blender Python API
 * ipython-yf:  An ipython extension to make it asyncio compatible

 * aiocron: Crontab
 * aiodns: async DNS resolver
 * aiofiles: async disk I/O
 * aiomas: multi-agent systems
 * aioprocessing: multiprocessing with asyncio
 * aiorwlock: Read-write locks
 * aioutils
 * tasklocals: Task-local variables

API-Hour benchmark
=================

* Django, Flask, API-Hour (asyncio)
* Round 5: 50 simultaneous connections with wrk
* API-Hour: between 3000 and 3600 req/s
* Django, Flask: between 600 and 628 req/s
* API-Hour handles around 5x more requests per second

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
* Trollius 2.0 now based on Git, released last week
* Only a few libraries are compatible with Trollius
* (ex: aiohttp doesn't work with trollius)

How can you help?
=================

* Need tutorials and more documentation on asyncio!
* https://docs.python.org/dev/library/asyncio.html is more a boring reference
  API doc
* Port more stdlib modules to asyncio: ftplib, poplib, imaplib, nntplib,
  smtplib, smtpd, telnetlib, xmlrpc, etc.
* Interoperability with Twisted

Links & Questions
=================

* http://asyncio.org/: Libraries, Docs, Talks, Tutorials, Blogs
* ThirdParty wiki page
* https://github.com/python/asyncio/wiki/ThirdParty

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

