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
* weechat pluggins (IRC client written in C)

Case A: Embed don't leak memory in Py_EndInterpreter()
------------------------------------------------

* Real world use cases: Python is already embedded
* Check for memory leaks at exit (ex: Valgrind)
* https://bugs.python.org/issue1635741

Case A: Pluggin use case
------------------------

* Use subinterpreters for pluggins
* IRC client written in C
* Pluggin A uses Python
* Pluggin B also uses Python
* Pluggins are not aware of each others
* No leak memory when you unload a pluggin

Case B: Run interpreters in parallel
------------------------------------

* multiprocessing
* Can be more efficient or more convinient for some specific use cases
* Machine Learning.

Case B: Single process is simpler
---------------------------------

* Admin tools are more convenient with 1 process than N processes
* Some APIs are more convenient in the same process
* On **Windows**, **spawn a thread** is faster than spawn a process.
  (Windows doesn't have fork.)
* On **macOS**, multiprocessing became slower with spawn, rather than fork or
  forkserver

Case B: Run subinterpreters in parallel
---------------------------------------

* **Don't share any Python objects** between interpreters
* Even immutables objects
* Problem: concurrent access on **PyObject.ob_refcnt**
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

Per-interpreter free lists (bpo-40521)
--------------------------------------

* MemoryError
* asynchronous generator
* context
* dict
* float
* frame
* list
* slice
* tuple

Per-interpreter singletons (bpo-40521)
--------------------------------------

* small integer ([-5; 256] range) (bpo-38858)
* empty bytes string singleton
* empty Unicode string singleton
* empty tuple singleton
* single byte character (``b'\x00'`` to ``b'\xFF'``)
* single Unicode character (U+0000-U+00FF range)
* Note: the empty frozenset singleton has been removed.

Per-interpreter...
-------------------

* slice cache (bpo-40521).
* pending calls (bpo-39984).
* type attribute lookup cache (bpo-42745).
* interned strings (bpo-40521).
* identifiers: ``_PyUnicode_FromId()`` (bpo-39465)

Per-interpreter module states
-----------------------------

* ast (bpo-41796)
* gc (bpo-36854)
* parser (bpo-36876)
* warnings (bpo-36737 and bpo-40521)

Fix daemon threads crashes
--------------------------

* Random crashes at Python exit when using daemon threads
* tstate_must_exit() function
* take_gil() calls tstate_must_exit() in 3 places

PoC in May 2020
---------------

* It scales with the number of CPUs!
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
* Maybe break the C API: need a PEP in this case
* Guido's idea: use ``&PyHeapType.ht_type``

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
* C11 _Thread_local and <threads.h> thread_local
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
