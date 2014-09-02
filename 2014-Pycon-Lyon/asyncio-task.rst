asyncio kernel: callback
========================

Callback
--------

Example::

    def hello():
        print("Hello World")
    call_soon(hello)

Event loop::

    class CallbackEventLoop:
        def __init__(self):
            self.callbacks = []

        def call_soon(self, func):
            self.callbacks.append(func)

        def scheduler_callback():
            for cb in self.callbacks:
                cb()
            self.callbacks.clear()

Call at (and call later)
------------------------

Example::

    def hello():
        print("Hello World")

    # Call hello() in 5 seconds
    call_at(time.time() + 5, hello)

Event loop::

    class TimerEventLoop(CallbackEventLoop):
        def __init__(self):
            super().__init__()
            self.timers = []

        def call_at(self, when, func):
            self.timers.append((when, func))

        def scheduler_timer(self):
            now = time.time()
            new_timers = []
            for index, (when, func) in self.timers:
                if when >= now:
                    self.call_soon(func)
                else:
                    new_timers.append((when, func))
            self.timers = new_timers

            self.scheduler_callback()

    # Real implementation: comparable TimerHandle and heapq

Call later:

    def call_later(delay, func):
        at = time.time() + delay
        call_at(at, func)

Selector
--------

Example::

    def reader(sock):
        print("Received:", sock.recv(100))

    # Wait data from a socket
    loop.add_reader(sock, reader)

Event loop::

    class SelectEventLoop(TimerEventLoop):
        def __init__(self):
            super().__init__()
            self.selector = selectors.Selector()

        def add_reader(self, sock, func):
            self.selector.register(sock, selectors.EVENT_READ, func)

        def scheduler_select(timeout=0.0):
            events = self.selector.select(timeout)
            for key, mask in events:
                func = key.data
                self.call_soon(func, key.fileobj)

    # Real implementation: comparable TimerHandle and heapq

All together
------------

Full event loop::

    class FullEventLoop(SelectEventLoop):
        def _run_once(self):
            if self.callbacks:
                timeout = 0
            else:
                timeout = <timeout of the next timer>
            self.scheduler_select(timeout)
            self.scheduler_timer()

        def run_forever(self):
            while 1:
                self._run_once()

    # missing: exception to stop the event loop



Python generator and yield-from
===============================

xxx

asyncio Task
============

xxx
