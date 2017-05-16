Performance

* speed.python.org is now running pyperformance

  * CPython compiled with PGO+LTO
  * Calibrate the number of outer loops so 1 value takes at least 100
  * Each benchmark uses 20 processes, each process computes 4 values
    but ignore the first one ("warmup" value")
  * 60 values per benchmark: compute the average (arithmetic mean) and standard
    deviation (std dev)

* CPython performance

  * CPython 3.6 is now as fast or faster than CPython 2.7
  * Ok, 7 years simply to get back the same performances, hum...

* Previous optimizations attemps

  * psyco: 2002-2003
  * PyPy: 1.0 released in 2007, new JIT
  * Unladen Swallow (Google): 2009-03..2010-03 (~1 year), LLVM
  * Pyston (Dropbox): 2014-04..2017-01 (~3 years), LLVM
  * Pyjion (Microsoft): 2016-01..2017-01 (~1 year), .NET CLR
  * FAT Python: 2015-10..2016-02 (5 months), static optimizer, runtime guards
  * Others: HotPy, Jython, IronPython

* CPython performance bottlenecks
* Python language

  * Python semantics: introspection and monkey-patching
  * Everything is mutable -> need runtime guards
  * Compromise: Numba @jit decorator changes the Python semantics
  * "opt-in" optimizer

* CPython C API

  * C structures: PyList_GET_ITEM() is a macro and part of the "stable ABI"
    (ABI? API? ...), access directly ``list->ob_item[index]``
  * Reference counting and a specific garbage collector: see gilectomy
    (GIL-less CPython) nightmare with reference counting
  * Parallelism: no parallelism, global lock (GIL)

* Future of the C API

  * New API: so what? faster? more portable?
  * strip the API: backward compatibility?
  * Yet another "major incompatible release" as the painful Python 3?
  * gilectomy approach: compilation option. More canddies if you enable
    the new mode.
  * Need to analyze and experimental PyQt, numpy and other major C libraries.

* Python language

  * Create a new subset of Python, stricter than Python?
  * Similar idea to Hack for PHP

* CPython future: PyPy?

  * Need to merge CPython and PyPy dev teams?
  * New features still occur first in CPython
  * PyPy "business model" (pay developers)

* Resources

  * speed.python.org
  * Speed mailing list
  * faster-cpython: my notes
