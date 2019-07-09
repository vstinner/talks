Past -- questions
====

* Python Implementations History

  * 1989: Guido van Rossum creates **CPython** (version 1.0 in 1994)
  * 1997: Jim Hugunin creates **JPython** (renamed to **Jython**), JVM
  * 1998: Christian Tismer creates **Stackless Python**
  * 2006: Jim Hugunin creates **IronPython**
  * 2014: Damien George creates **MicroPython**

* Faster Python History

  * 2002: Armin Rigo creates **psyco**, JIT compiler for a single function
  * 2007: **PyPy** created
  * 2009-2010: **Unladen Swallow** project, funded by Google
  * 2014-2017: Kevin Modzelewsk creates **Pyston**, funded by Dropbox
  * 2016-2017: Dino Viehland creates **Pyjion**, funded by Microsoft

* Two main approaches

  * Fork CPython
  * Implementation written from scratch

* Fork CPython

 * Examples: Pyston, Pyjion
 * Performance limited by CPython design (1989): specific memory allocators,
   C structures, reference counting, mark-and-sweep GC, etc.
 * CPython is mostly limited to 1 thread because of the GIL (more later).

* Implementation written from scratch

  * Examples: PyPy, Jython, IronPython.
  * PyPy is a great example of adopting new technics: different GC, very
    efficient structures like specialized lists for integers, etc.
  * C extensions: no support, or slower than CPython (PyPy cpyext)
  * cpyext converts PyPy "JIT-friendly" objects to CPython PyObject:
    O(n) complexity for a list.
  * Jython and IronPython have no GIL!

* Stackless Python mostly replaced with gevent and eventlet, thanks to greenlet
  which works on top on unmodified CPython.
* Competition with CPython

  * CPython has around 30 active core developers to maintain it.
  * New features first land into CPython.
  * Why users would prefer an outdated fork or an incompatible implementation?
  * Who will sponsor the development?

* Performance

  * Would users adopt another Python implementation if it is only 30% faster?
  * What if it's 2x faster?
  * Status quo: CPython remains the **reference** implementation where most
    people are active.
  * Other implementations are spending a lot of time to catch up CPython.
  * PyPy can be 6x faster or more depending on the workload.
  * PyPy is not widely adopted yet: why?

* Is it only about performance?

  * Tooling around CPython
  * CPython is shipped with Linux distributions, macOS, FreeBSD, and now also
    with Windows 10.

* Dropbox: while Pyston was developed, another team rewrote code causing
  performance bottlenecks in Go. The main motivation to sponsor Pyston didn't
  make sense anymore.

* Unladen Swallow fight bugs in LLVM
* Gilectomy

  * CPython fork to "remove the GIL"
  * Replace unique GIL with many smaller locks
  * Not more efficent yet
  * Reference counting seems to be incompatible with thread scalability
  * Need to find a different approach?

* Unlock raw performances requires to move away from CPython legacy code
* C extensions rely on the C API
* The C API leaks CPython internals.
* Backward compatibility

  * Python 2 to Python 3 transition shows the importance of backward
    compatibility
  * Need to find better approach for Python evolutions: involve maintainers of
    popular Python modules in backward incompatible changes.

Present -- answers
=======

* PyPy

  * Drop-in replacement for CPython
  * Way faster
  * Fully compatible
  * Support C extension with cpyext

* pyperformance: benchmark suite

  * speed.python.org
  * speed.pypy.org
  * Track performance over time

* Understand the GIL

  * Unique lock to protect the whole "Python world" from the outside
  * Python calling outside code can release the GIL: os.read(), hashlib, etc.
  * Data passed to external code must not be modified by Python
  * No need to write "thread-safe" code: "Python" code is single-threaded
  * Implicitly protected by the GIL: reference counters, Python memory
    allocator, Python internal structures, etc.

* Multi processes to workaround GIL for CPU-bound workload

  * multiprocessing
  * concurrent.futures
  * Web server: accept a connection, pass the socket to a worker process

* Cython

  * Good compromise between speed and development time
  * Syntax close to Python
  * Emit fast machine code

* multiprocessing

  * Distribute workload on multiple CPUs using multipe processes
  * Support shared memory since Python 3.8

* Twisted, Tornado, eventlet, gevent, asyncio

  * Efficient concurrent programming for I/O-bound workloads
  * CPU-bound workloads done in threads and/or worker processes

* pickle version 5 in Python 3.8

  * Reduce or even avoid memory copies

* For scientific computation like numpy

  * numba and pythran can emit efficient code using SIMD instructions (SSE,
    AVX, etc.) or even use GPGPU (CUDA, OpenCL, etc.)


Future -- promises
======

* PEP 554 "sub-interpreters" per process

  * Run them in parallel
  * One lock per interpreter

* C API

  * Evolved organically: private functions exposed "by mistake"
  * API exposes implementation details: structure fields, memory allocators,
    reference counting, etc.

* Smaller C API

  * Python 3.8 has 3 C APIs
  * **public** portable C API
  * **private** C API specific to CPython
  * **internal** C API: should not be used

* New (incompatible) C API? ... unclear plan
* More generally: better separation between the Python **language** and the
  Python **runtime**: runtimes should be interoperable, compatible

  * One binary, multiple runtimes
  * Python 3.7
  * Python 3.8 (release build)
  * Python 3.8 (debug build)
  * Your Python fork!

* Transition approach

  * Stricter (limited) API hiding most implementation details
  * New runtime, existing one remains unchanged
  * Allow to experiment optimizations like tagged pointer

* Binary compatibility between CPython and PyPy?


Conclusion
==========

* CPython remains the reference implementation but shows its age.
* PyPy shows that the Python language can be very efficient.
* On-going work on the C API for better compatibility between CPython versions
  and PyPy.
* Make the stable ABI usable more easily: support multiple Python versions
  with a single binary.
* Hiding implementation details will allow exciting optimizations like
  tagged pointers.
* Backward compatibility is key: Python community rely on PyPI packages
  which must move with CPython evolutions.
