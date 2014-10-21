http://www.pycon.fr/2014/schedule/
Dimanche 11:30, Exploration de la boucle d'événement asyncio
http://www.pycon.fr/2014/schedule/presentation/5/


Discover the asyncio event loop
===============================

* How asyncio is implemented
* Code snippets close to but different than asyncio
* No error handling
* No optimization


asyncio kernel: callback
========================

Callback
--------

Event loop::

    class CallbackEventLoop:
        def __init__(self):
            self.callbacks = []

        def call_soon(self, func):
            self.callbacks.append(func)

        def execute_callback(self):
            callbacks = self.callbacks
            self.callbacks = []
            for cb in callbacks:
                cb()

Example::

    def hello():
        print("Hello World")

    loop = CallbackEventLoop()
    loop.call_soon(hello)
    loop.execute_callback()

Call at (and call later)
------------------------

Event loop::

    class TimerEventLoop(CallbackEventLoop):
        def __init__(self):
            super().__init__()
            self.timers = []

        def call_at(self, when, func):
            self.timers.append((when, func))

        def execute_timers(self):
            now = time.time()
            new_timers = []
            for when, func in self.timers:
                if when <= now:
                    self.call_soon(func)
                else:
                    new_timers.append((when, func))
            self.timers = new_timers

            self.execute_callback()

    # Real implementation: comparable TimerHandle and heapq

Example::

    def hello():
        print("Hello World")

    # Call hello() in 5 seconds
    loop = TimerEventLoop()
    loop.call_at(time.time() + 5, hello)
    time.sleep(5)
    loop.execute_timers()

Call later::

    def call_later(self, delay, func):
        at = time.time() + delay
        self.call_at(at, func)



Selector
--------

Event loop::

    class SelectorEventLoop(TimerEventLoop):
        def __init__(self):
            super().__init__()
            self.selector = selectors.Selector()

        def add_reader(self, sock, func):
            self.selector.register(sock, selectors.EVENT_READ, func)

        def _compute_timeout(self):
            if self.callbacks:
                # already something to do
                return 0
            elif self.timers:
                next_timer = min(self.timers)[0]
                return max(next_timer - time.time(), 0.0)
            else:
                # blocking call
                return None

        def select(self):
            timeout = self._compute_timeout()
            events = self.selector.select(timeout)
            for key, mask in events:
                func = key.data
                self.call_soon(func, key.fileobj)

            self.execute_timers()

Example::

    def reader(sock):
        print("Received:", sock.recv(100))

    rsock, wsock = socket.socketpair()
    loop = SelectorEventLoop()

    loop.add_reader(rsock, reader)
    wsock.send(b'abc')
    loop.select()


Run forever, stop
-----------------

Blocking event loop::

    class StopEventLoop(Exception):
        pass

    class EventLoop(SelectEventLoop):
        def _stop(self):
            raise StopEventLoop

        def stop(self):
            self.call_soon(self._stop)

        def run_forever(self):
            try:
                while 1:
                    self.select()
            except StopEventLoop:
                pass

    # missing: exception to stop the event loop


Future
======

::

    class Future:
        def __init__(self):
            self.callbacks = []
            self._result = None

        def add_done_callback(self, func):
            self.callbacks.append(func)

        def set_result(self, result):
            self._result = result
            for func in self.callbacks:
                func(self)

        def result(self):
            return self._result

        def __iter__(self):
            yield self

    # TODO: handle exception, result() must fail if there is no result


Future: integration with the event loop
=======================================

::

    class LoopFuture(Future):
        def __init__(self, loop):
            super().__init__()
            self.loop = loop

        def set_result(self, result):
            self._result = result
            for func in self.callbacks:
                self.loop.call_soon(func, self)

Python generator and yield-from
===============================

Generator
---------

::

    def demo_gen():
        print("start")
        yield 1
        print("stop")
        return 2

    gen = demo_gen()
    # not started yet
    print(gen.next())  # print 1
    # gen stopped again
    try:
        gen.next()
    except StopIteration as exc:
        print(exc.value)   # print 2

yield-from
----------

::

    def producer():
        yield "Hello"
        yield "World!"

    def wrapper():
        print("enter wrapper")
        yield from producer()
        print("exit wrapper")

    for item in wrapper():
        print(item)

Output::

    enter wrapper
    Hello
    World!
    exit wrapper


asyncio Task
============

Coroutine
---------

A coroutine is a generator::

    def my_coroutine(future):
        yield from future
        res = future.result()

Task
----

Schedule a coroutine::

    class Task:
        def __init__(self, coro):
            self.coro = coro

        def step(self):
            try:
                next(self.coro)
            except StopIteration:
                pass

    def coroutine():
        print("step 1")
        yield from []  # hack to interrupt the coroutine
        print("step 2")

    task = Task(coroutine())
    task.step() # print "step 1"
    task.step() # print "step 2"


Coroutine waiting for a future
------------------------------

::

    class Task:
        def __init__(self, coro):
            self.coro = coro

        def step(self):
            try:
                result = next(self.coro)
            except StopIteration:
                pass
            else:
                if isinstance(result, Future):
                    result.add_done_callback(self.wakeup)

        def wakeup(self, fut):
            self.step()

    # TODO: support exception

    def coroutine(future):
        print("wait future")
        yield from future
        print("future result", future.result())

    future = Future()
    task = Task(coroutine(future))
    task.step()            # print "waiting future"
    future.set_result(5)   # print "future result: 5"


Task: integration with the event loop
-------------------------------------

::

    class LoopTask(Task):
        def __init__(self, coro, loop):
            super().__init__()
            loop.call_soon(self.step)

        def step(self):
            try:
                next(self.coro)
            except StopIteration:
                pass
            else:
                loop.call_soon(self.step)

    # and use LoopFuture, not Future
