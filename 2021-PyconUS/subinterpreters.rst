https://docs.google.com/document/d/1CAYgCMe3lbwkTh6oyjLdFhPxD1dcvCKRBR-y3pF61l4/edit
https://www.python.org/dev/peps/pep-0554/
    PEP 554 -- Multiple Interpreters in the Stdlib
    Python API
https://pythondev.readthedocs.io/subinterpreters.html
[subinterpreters] Meta issue: per-interpreter GIL
    https://bugs.python.org/issue40512
https://github.com/ericsnowcurrently/multi-core-python/

Main use case
=============

* Distribute a Python application on N CPUs for specific use cases using
  a single process.

Technical issues
================

* Release memory in Py_Finalize() and Py_EndInterpreter()
* Isolate interpreters
* Run interpreters in parallel

Pluggin use case
================

* Write a pluggin in Python (app not written in Python)
* Load multiple pluggin instances
* *Unload* pluggin: don't leak memory

Embed Python Use Case
=====================

* Script an application in Python (vim, Blender, OpenOffice)
* Check for memory leaks at exit (ex: Valgrind)
* https://bugs.python.org/issue1635741

Run subinterpreters in parallel
===============================

* Don't share any Python objects between interpreters
* Even immutables objects
* Problem: concurrent access on PyObject.ob_refcnt
* Solution: don't share objects

Single process is simpler
=========================

* Admin tools are more convenient with 1 process than N processes
* Some APIs are more convenient in the same process
* On Windows, spawn a thread is faster than spawn a process.
  (Windows doesn't have fork.)
* On macOS, multiprocessing became slower with spawn, rather than fork or
  forkserver

Workloads without shared data
=============================

* Network client

Drawbacks of subinterpreters
============================

* On a crash (ex: segfault), all interpreters are killed.
* All used extensions must be modified to support being run in parallel in
  subinterpreters.

PoC in May 2020
===============

* Same factorial function on 4 CPUs
* Sequential: 1.99 sec +- 0.01 sec
* Threads: 3.15 sec +- 0.97 sec (1.5x slower)
* Multiprocessing: 560 ms +- 12 ms (3.6x faster)
* Subinterpreters: 583 ms +- 7 ms (3.4x faster)

Work already done
=================

* Port XXX extensions  (XX%, total: XXX)
* Port XXX types to heap types (XX%, total: XXX)
* Many global variables made "per-interpreter": free lists, singletons, caches.

TODO (misc)
===========

* Convert remaining extensions and static types
* GIL itself (easy)
* _PyArg_Parser
* Fix remaining bugs

TODO (hard)
===========

* (A) Remove static types from the C API: replace &PyLong_Type with
  PyLong_GetType().
* (B) None, True/False singletons
* (C) Get tstate from a thread local storage (TLS)

Get tstate from TLS
===================

* _PyThreadState_GET()
* C11 _Thread_local
* C11 <threads.h> thread_local
* x86: single MOV using FS register
* Use volatile if C11 is not supported
* Function call at the ABI level for extensions
* https://bugs.python.org/issue40522 & draft PR 23976

None singleton
==============

* (A) Add an "if" to Py_INCREF/DECREF: 10% slower and CPU cache issue
* (B) ``#define Py_None Py_GetNone()``: no API issue!
* tstate->interp->none
* https://bugs.python.org/issue39511 & draft PR 18301

Performance impact of these changes
===================================

* Compare Python 3.8, 3.9 and 3.10 at speed.python.org (macro benchmarks).
* Benchmarks and microbenchmarks were run on individual changes:
  no significant overhead.

Open questions
==============

* Need a first PEP for the overall isolated interpreter design.
* PEP to convert public static types to heap types (PyLong_GetType).
* Extensions wrapping C libraries with shared states: need a lock (GIL-like?)
  somewhere.
* What if popular C extensions are not made compatible with isolated
  subinterpreters? Another "Python 2 vs Python 3" case where all dependencies
  must be compatible? We consider that it's ok, it is an opt-in feature, not
  the default.

Later
=====

* API to share Python objects (share data, put a proxy with locks on it)
* Support spawning subprocesses (fork)
