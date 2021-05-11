https://docs.google.com/document/d/1CAYgCMe3lbwkTh6oyjLdFhPxD1dcvCKRBR-y3pF61l4/edit
https://www.python.org/dev/peps/pep-0554/
    PEP 554 -- Multiple Interpreters in the Stdlib
    Python API
https://pythondev.readthedocs.io/subinterpreters.html
[subinterpreters] Meta issue: per-interpreter GIL
    https://bugs.python.org/issue40512
https://github.com/ericsnowcurrently/multi-core-python/

Agenda
======

30 min

* Use Cases (3 min)
* C API: Static types and extensions (8 min)
* Work already done (5 min)
* TODO (7 min)
* Future (2 min)
* Q & A (5 min)

Use Cases
=========

Embed Python
------------

* vim
* Blender
* LibreOffice
* pybind11 (embed Python in C++ applications)

Subinterpreters Use Cases
-------------------------

* mod_wsgi: handle HTTP requests
* weechat plugins (IRC client written in C)

Case A: Embedded Python must release memory at exit
---------------------------------------------------

* Real world use cases: Python is already embedded
* Check for memory leaks at exit (ex: Valgrind)
* Py_Finalize() should release all memory allocations done by Python.
* It may be even more important for Py_EndInterpreter()
* https://bugs.python.org/issue1635741

Case A: Plugin use case
-----------------------

* Use subinterpreters for plugins
* IRC client written in C
* Plugin A uses Python
* Plugin B also uses Python
* Plugins are not aware of each others
* Don't leak memory when a plugin is unloaded

Case B: Run interpreters in parallel
------------------------------------

* multiprocessing use cases.
* Distribute Machine Learning.

Case B: Single process is more convenient and efficient
-------------------------------------------------------

* Admin tools are more convenient with 1 process than with N processes
* Some APIs are more convenient in the same process.
* On **Windows**, **spawn a thread** is faster than spawn a process.
  (Windows doesn't have fork.)
* On **macOS**, multiprocessing became slower with spawn, rather than fork or
  forkserver

Case B: Don't share any Python object
--------------------------------------

* **Don't share any Python object** between interpreters. Even immutables
  objects.
* Problem: concurrent access on **PyObject.ob_refcnt**.
* Adding a **mutex** on ob_refcnt would kill performance.
* **Atomic operation** on ob_refcnt would be an obvious performance bottleneck:
  pressure on the same CPU cacheline for common objects like None, 1, ().
* Solution: don't share objects

Drawbacks of subinterpreters
----------------------------

* On a crash (ex: segfault), all interpreters are killed.
* All used extensions must be modified to support being run in parallel in
  subinterpreters.

Static types and extensions
===========================

Multiphase
----------

* Multiphase: **64% (76/118)**. At 2020-10-06, 76 extensions on a total of 118
  use the new multi-phase initialization API. There are 42 remaining extensions
  using the old API (bpo-1635741).

Heap types
----------

* Heap types: **35% (69/200)**. At 2020-11-01, 69 types are defined as heap
  types on a total of 200 types. There are 131 remaining static types
  (bpo-40077).

Work already done
=================

Per-interpreter free lists
--------------------------

* float
* tuple, list, dict, slice
* frame, context, asynchronous generator
* MemoryError

Per-interpreter singletons
--------------------------

* small integer ([-5; 256] range)
* empty bytes string singleton
* empty Unicode string singleton
* empty tuple singleton
* single byte character (``b'\x00'`` to ``b'\xFF'``)
* single Unicode character (U+0000-U+00FF range)
* Note: the empty frozenset singleton has been removed.

Per-interpreter...
-------------------

* slice cache
* pending calls
* type attribute lookup cache
* interned strings: ``PyUnicode_InternInPlace()``
* identifiers: ``_PyUnicode_FromId()``

Per-interpreter module states
-----------------------------

* ast
* gc
* parser
* warnings

Fix daemon threads crashes
--------------------------

* Random crashes at Python exit when using daemon threads
* take_gil() now checks in 3 places if the current thread must exit
  immediately (if Python exited).
* Don't read any Python internal structure after Python exited.

Proof of concept (May 2020)
---------------------------

* Same factorial function on 4 **CPUs**
* Sequential: **1.99 sec** +- 0.01 sec (ref)
* Threads: **3.15 sec** +- 0.97 sec (1.5x slower)
* Multiprocessing: **560 ms** +- 12 ms (**3.6x** faster)
* Subinterpreters: **583 ms** +- 7 ms (**3.4x** faster)

TODO
====

TODO (misc)
-----------

* Convert remaining extensions and static types
* GIL itself (easy)
* _PyArg_Parser
* Fix remaining bugs

TODO (hard)
-----------

* (A) Remove static types from the C API
* (B) None, True, False singletons
* (C) Get tstate from a thread local storage (TLS)

Remove static types from the C API
-----------------------------------

* Replace ``&PyLong_Type`` with ``PyLong_GetType()``
* Guido's idea: use ``&PyHeapType.ht_type`` for ``&PyLong_Type``.
* Need a PEP if the C API is broken.
* https://bugs.python.org/issue40601

None singleton
--------------

* (A) Add an "if" to Py_INCREF/DECREF: 10% slower and CPU cacheline issue
* (B) ``#define Py_None Py_GetNone()``: no API issue!
* tstate->interp->none
* https://bugs.python.org/issue39511 & draft PR 18301

Get tstate from TLS
-------------------

* Performance issue
* _PyThreadState_GET()
* C11 _Thread_local and <threads.h> **thread_local**
* x86: single MOV instruction using FS register
* Use **volatile** keyword if C11 is not supported
* Function call at the ABI level for extensions
* https://bugs.python.org/issue40522 & draft PR 23976

Performance impact of these changes
-----------------------------------

* Compare Python 3.8, 3.9 and 3.10 at speed.python.org (macro benchmarks).
* Benchmarks and microbenchmarks were run on individual changes:
  no significant overhead.

Open questions
--------------

* Need a first PEP for the overall isolated interpreter design.
* PEP to convert public static types to heap types (PyLong_GetType).
* Extensions wrapping C libraries with shared states: need a lock (GIL-like?)
  somewhere.
* What if popular C extensions are not made compatible with isolated
  subinterpreters? Another "Python 2 vs Python 3" case where all dependencies
  must be compatible? We consider that it's ok, it is an opt-in feature, not
  the default.

Future
======

Later
-----

* API to share Python objects (share data, put a proxy with locks on it)
* Support spawning subprocesses (fork)

Q & A
=====

* Ask your questions :-)
* ``./configure --with-experimental-isolated-subinterpreters``
* ``#ifdef EXPERIMENTAL_ISOLATED_SUBINTERPRETERS``

