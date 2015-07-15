The asyncio project was officially launched with the release of Python 3.4 in
March 2014. The project was public before that under the name “tulip”. asyncio
is just a core network library, it requires third party library to be usable
for common protocols. One year later, asyncio has a strong community writing
libraries on top of it.

The most advanced library is aiohttp which includes a complete HTTP client but
also a HTTP server. There are also libraries to access asynchronously the file
system, resolve names with DNS, have variables local to tasks, read-write
locks, etc. There are clients for AMQP, Asterisk, ElasticSearch, IRC, XMPP
(Jabber), etc. (and even an IRC server!). There are asynchronous drivers for
all common databases, and even for some ORMs. As expected, there are tons of
new web frameworks based on asyncio. It’s also possible to plug asyncio into
Gtk, Qt, gevent, eventlet, gunicorn, tornado, etc.

I will also discuss use cases of asyncio in production and benchmarks. Spoiler:
asyncio is not slow.

The asyncio library also evolved to become more usable: it has a better
documentation, is easier to debug and has a few new functions. There is also a
port to Python 2: trollius.
