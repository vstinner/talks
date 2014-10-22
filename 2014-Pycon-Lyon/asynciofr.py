import time
import socket
import selectors

class CallbackEventLoop:
    def __init__(self):
        self.callbacks = []

    def call_soon(self, func):
        self.callbacks.append(func)

    def execute_callbacks(self):
        callbacks = self.callbacks
        self.callbacks = []
        for cb in callbacks:
            cb()

class TimerEventLoop(CallbackEventLoop):

    def __init__(self):
        super().__init__()
        self.timers = []

    def call_at(self, when, func):
        timer = (when, func)
        self.timers.append(timer)

    def execute_timers(self):
        now = time.time()
        new_timers = []
        for when, func in self.timers:
            if when <= now:
                self.call_soon(func)
            else:
                new_timers.append((when, func))
        self.timers = new_timers

        self.execute_callbacks()



class SelectorEventLoop(TimerEventLoop):

    def __init__(self):
        super().__init__()
        self.selector = selectors.DefaultSelector()

    def add_reader(self, sock, func):
        self.selector.register(sock,
                     selectors.EVENT_READ,
                     data=func)

    def select(self):
        timeout = self.compute_timeout()

        events = self.selector.select(timeout)
        for key, mask in events:
            func = key.data
            self.call_soon(func)

        self.execute_timers()

    def compute_timeout(self):
        if self.callbacks:
            # already something to do
            return 0
        elif self.timers:
            next_timer = min(self.timers)[0]
            timeout = next_timer - time.time()
            return max(timeout, 0.0)
        else:
            # blocking call
            return None


class BaseTask:
    def __init__(self, coro):
        self.coro = coro

    def step(self):
        try:
            next(self.coro)
        except StopIteration:
            pass

class Future:

    def __init__(self, loop):
        self.loop = loop
        self.callbacks = []
        self._result = None

    def add_done_callback(self, func):
        self.callbacks.append(func)

    def result(self):
        return self._result

    def set_result(self, result):
        self._result = result

        for func in self.callbacks:
            self.loop.call_soon(func)

    def __iter__(self):
        # used by “yield from future”
        yield self


class Task:

    def __init__(self, coro, loop):
        self.coro = coro
        loop.call_soon(self.step)

    def step(self):
        try:
            result = next(self.coro)
        except StopIteration:
            return

        if isinstance(result, Future):
            result.add_done_callback(self.step)

def sleep(delay, loop):
    fut = Future(loop)
    cb = functools.partial(fut.set_result,
                           None)
    loop.call_later(delay, cb)
    yield from fut

def wait_for(fut):
    print("wait for")
    yield from fut
    print("result", fut.result())

loop = TimerEventLoop()
fut = Future(loop)
coro = wait_for(fut)
task = Task(coro, loop)
loop.call_at(time.time() + 1.0, lambda: fut.set_result(5))
for run in range(5):
    loop.execute_timers()
    time.sleep(1.0)
