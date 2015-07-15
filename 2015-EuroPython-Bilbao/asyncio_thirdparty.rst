#summary Third-party projects that integrate with asyncio.

See also [http://asyncio.org/ asyncio.org] (asyncio resources) and [http://trollius.readthedocs.org/ Trollius] (port of asyncio to Python 2).

= Libraries =

 * [https://github.com/Tinche/aiofiles/ aiofiles]: File support for asyncio
 * [https://github.com/KeepSafe/aiohttp aiohttp]: http client and server infrastructure for asyncio
 * [https://pypi.python.org/pypi/aiodns aiodns]: Async DNS resolver
 * [https://pypi.python.org/pypi/aiorwlock aiorwlock]: Read write lock for asyncio.
 * [https://pypi.python.org/pypi/aioutils aioutils]: Python3 Asyncio Utils, Group (like gevent.pool.Group), Pool (like event.poo.Pool), Bag and OrderedBag.
 * [https://github.com/vkryachko/tasklocals tasklocals]: Task-local variables

= Clients =

 * Asterisk: [https://panoramisk.readthedocs.org/ panoramisk], a library based on python’s asyncio to play with asterisk‘s manager
 * !ElasticSearch: [http://aioes.readthedocs.org/ aioes], client library
 * IRC: [https://irc3.readthedocs.org/ irc3], plugable irc client library based on python's asyncio
 * IRC: [https://github.com/numberoverzero/bottom bottom], asyncio-based rfc2812-compliant IRC Client
 * XMPP (Jabber): [http://git.poez.io/slixmpp slixmpp], SleekXMPP (XMPP Library) fork using asyncio, for poezio

= Databases =

SQL drivers:

 * MySQL: [https://github.com/aio-libs/aiomysql aiomysql], MySQL driver
 * PostgreSQL: [http://aiopg.readthedocs.org/ aiopg], PostgreSQL client library built on top of psycopg2

NoSQL and key-value store drivers:

 * CouchDB: [http://aiocouchdb.readthedocs.org aiocouchdb], CouchDB client
 * memcached: [https://github.com/fafhrd91/aiomemcache aiomemcache], minimal memcached client
 * MongoDB: [https://bitbucket.org/mrdon/asyncio-mongo asyncio-mongo], MongoDB driver (ported from Twisted)
 * redis: [http://asyncio-redis.readthedocs.org/ asyncio-redis], Redis client
 * redis: [http://aioredis.readthedocs.org/ aioredis], Yet another Redis client

ORM:

 * [https://peewee.readthedocs.org/ peewee]: [http://peewee-async.readthedocs.org/en/latest/ peewee-async], library providing asynchronous interface powered by asyncio for peewee ORM.

= Web frameworks =

 * [https://pypi.python.org/pypi/aiopyramid aiopyramid]: Tools for running [https://pypi.python.org/pypi/pyramid pyramid] using asyncio.
 * [https://github.com/gawel/aiowsgi aiowsgi]: minimalist wsgi server using asyncio
 * [https://pypi.python.org/pypi/api_hour API hour]: Write efficient network daemons (HTTP, SSH, ...) with ease.
 * [https://github.com/tavendo/AutobahnPython AutobahnPython]: !WebSocket and WAMP framework
 * [https://pypi.python.org/pypi/interest interest]: event-driven web framework on top of aiohttp/asyncio.
 * [https://github.com/klen/muffin muffin]: A web framework based on Asyncio stack (early alpha)
 * [https://github.com/avelino/nacho nacho]: web framework
 * [http://pythonhosted.org/pulsar/ Pulsar]: Event driven concurrent framework for python. With pulsar you can write asynchronous servers performing one or several activities in different threads and/or processes.
 * [https://github.com/mind1master/rainfall rainfall]: another web framework
 * [https://github.com/vkryachko/Vase Vase]: web framework
 * [https://github.com/aaugustin/websockets websockets]: Websockets library
 * [https://github.com/Lawouach/WebSocket-for-Python WebSocket-for-Python]: another websocket library

Looking for WSGI? Read this thread: [https://groups.google.com/forum/#!topic/python-tulip/Gs3bZ2AbS9o WSGI implementation compatible with asyncio?].

= Integration with other application libraries =

 * [https://github.com/dzen/aioamqp aioamqp]: AMQP implementation using asyncio
 * gunicorn: gunicorn has gaiohttp worker built on top of aiohttp library

= Run asyncio on top of =

 * eventlet: [http://aiogreen.readthedocs.org/ aiogreen], asyncio API implemented on top of eventlet
 * gevent: [https://pypi.python.org/pypi/aiogevent aiogevent], asyncio API implemented on top of gevent

= Adapters for other event loops =

Some people have already written adapters for integrating asyncio with other async I/O frameworks.

 * [http://eventlet.net/ eventlet]: [https://github.com/1st1/greenio greenio], Greenlets support for asyncio (PEP 3156)
 * [http://www.gevent.org/ gevent]: [https://github.com/decentfox/tulipcore tulipcore], run gevent code on top of asyncio, alternative gevent core loop
 * GLib: [https://bitbucket.org/a_ba/gbulb gbulb], event loop based on GLib
 * [https://github.com/libuv/libuv libuv]: [https://github.com/saghul/aiouv aiouv], an event loop implementation for asyncio based on [https://pyuv.readthedocs.org/ pyuv]
 * Qt: [https://github.com/harvimt/quamash Quamash], implementation of the PEP 3156 Event-Loop with Qt.
 * [https://github.com/facebook/tornado Tornado] has [https://groups.google.com/forum/#!topic/python-tulip/hg0HzhoPuFE experimental asyncio support] built right into it.
 * [http://zeromq.org/ ZeroMQ]: [http://aiozmq.readthedocs.org/ aiozmq], ZeroMQ integration with asyncio
 * [http://zeromq.org/ ZeroMQ]: [https://github.com/takluyver/Zantedeschia Zantedeschia], experimental alternative integration between asyncio and ZeroMQ sockets.

= Misc =

 * [https://github.com/gawel/aiocron/ aiocron]: Crontabs for asyncio
 * [http://stefan.sofa-rockers.org/2015/02/13/aiomas/ aiomas]: A library for multi-agent systems and RPC based on asyncio
 * [https://bitbucket.org/haypo/aiotest/ aiotest]: test suite to validate an implementation of the asyncio API
 * [https://github.com/dano/aioprocessing aioprocessing]: A Python 3.3+ library that integrates the multiprocessing module with asyncio
 * [https://github.com/akloster/blender-asyncio blender-asyncio]: Asyncio Bridge for Blender Python API
 * [https://github.com/tecki/ipython-yf ipython-yf]:  An ipython extension to make it asyncio compatible
 * [https://github.com/jettify/aiogearman aiogearman]: asyncio [http://gearman.org/ gearman] support. Gearman provides a generic application framework to farm out work to other machines or processes that are better suited to do the work.
 * Serial port using the serial module, see [https://stackoverflow.com/questions/21666106/using-serial-port-in-python3-asyncio using serial port in python3 asyncio] at Stackoverflow, serial.Serial can be registered with loop.add_reader().

= Filesystem =

asyncio does *not* support asynchronous operations on the filesystem. Even if files are opened with O_NONBLOCK, read and write will block.

Read [http://blog.libtorrent.org/2012/10/asynchronous-disk-io/ asynchronous disk I/O] (October 2012 by arvid).

The Linux kernel provides asynchronous operations on the filesystem (aio), but it requires a library and it doesn't scale with many concurrent operations. See [http://lse.sourceforge.net/io/aio.html aio].

The GNU C library (glibc) implements the POSIX aio interface, but it is implemented with threads. See [http://man7.org/linux/man-pages/man7/aio.7.html aio(7) manual page].

Recent discussion on the Linux Kernel: [http://lwn.net/Articles/612483/ Non-blocking buffered file read operations] (September 2014).
