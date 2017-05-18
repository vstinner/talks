Benchmarks
==========

How to run stable benchmarks
----------------------------

* March 2016: no core dev trusted benchmark results, many benchmarks were not
  reliable
* New perf project spawning multiple processes and computing the average rather
  the minimum
* Benchmark suite rewritten using perf, misc minor enhancements
* Tune the system to run benchmarks: sudo python3 -m perf system tune
* CPython now compiled with LTO+PGO to avoid random
* Don't use timeit but perf timeit: python3 -m perf timeit STMT
* Read perf documentation! http://perf.rtfd.io/

Spot a performance regression
-----------------------------

My work on perf helped to find & fix a performance issue on Python startup:
Fev: 20 ms => Oct: 27 ms => Nov: 17 ms!
http://bugs.python.org/issue28637
https://twitter.com/VictorStinner/status/796858637507588096

Performance timeline
--------------------

April, 2014-May,2017 (3 years)
https://speed.python.org/timeline/

Benchmark results
=================

Python 3.6 faster than Python 3.5
---------------------------------

+---------------------+-----------------------------------+-----------------------------------+
| Benchmark           | 3.5                               | 3.6                               |
+=====================+===================================+===================================+
| xml_etree_iterparse | 405 ms                            | 194 ms: 2.09x faster (-52%)       |
+---------------------+-----------------------------------+-----------------------------------+
| unpickle_list       | 9.46 us                           | 6.36 us: 1.49x faster (-33%)      |
+---------------------+-----------------------------------+-----------------------------------+
| xml_etree_parse     | 287 ms                            | 240 ms: 1.20x faster (-16%)       |
+---------------------+-----------------------------------+-----------------------------------+
| python_startup      | 16.9 ms                           | 14.3 ms: 1.18x faster (-15%)      |
+---------------------+-----------------------------------+-----------------------------------+
| xml_etree_generate  | 244 ms                            | 209 ms: 1.16x faster (-14%)       |
+---------------------+-----------------------------------+-----------------------------------+
| spectral_norm       | 300 ms                            | 258 ms: 1.16x faster (-14%)       |
+---------------------+-----------------------------------+-----------------------------------+
| sympy_sum           | 227 ms                            | 198 ms: 1.15x faster (-13%)       |
+---------------------+-----------------------------------+-----------------------------------+
| sympy_expand        | 1.08 sec                          | 945 ms: 1.14x faster (-12%)       |
+---------------------+-----------------------------------+-----------------------------------+
| regex_v8            | 48.7 ms                           | 43.3 ms: 1.13x faster (-11%)      |
+---------------------+-----------------------------------+-----------------------------------+
| unpickle            | 34.4 us                           | 30.7 us: 1.12x faster (-11%)      |
+---------------------+-----------------------------------+-----------------------------------+

+---------------------+-----------------------------------+-----------------------------------+
| Benchmark           | 2017-04-02_08-37-3.5-9881e02d690f | 2017-04-03_16-26-3.6-d184c20e3599 |
+=====================+===================================+===================================+
| regex_compile       | 311 ms                            | 380 ms: 1.22x slower (+22%)       |
+---------------------+-----------------------------------+-----------------------------------+


Python 3.6 faster than Python 2.7
---------------------------------

"sympy benchmarks: Python 3.6 is between 8% and 48% faster than Python
2.7 #python #benchmark":
https://twitter.com/VictorStinner/status/794289596683210760

Python 3.6 is between 12% (1.14x) and 97% (32x) FASTER than Python 2.7 in the
following benchmarks:
https://twitter.com/VictorStinner/status/794525289623719937


Python 3.7 faster than Python 3.6
---------------------------------

Sad part
========

Python 3.6 is between 25% and 54% slower than Python 2.7 in the following
benchmarks:
https://twitter.com/VictorStinner/status/794305065708376069


Optimizations
=============

2016-12-14: speedup method calls
--------------------------------

2016-04-22: pymalloc allocator
------------------------------

** Faster memory allocator: PyMem_Malloc() now also uses pymalloc

2015-12-07: Optimize ElementTree.iterparse(), xml_etree_iterparse
-----------------------------------------------------------------

2015-09-19: PGO uses test suite, pidigits
-----------------------------------------

2015-05-30: C implementation of collections.OrderedDict, html5lib
-----------------------------------------------------------------

2015-05-23: C implementation of functools.lru_cache(), sympy
------------------------------------------------------------

Other optimizations
===================

* Wordcode

    The bytecode format and instructions to call functions were redesign to run
    bytecode faster.

    * Faster bytecode (5 min)
    ** wordcode: fixed size instructions: always 16-bit
    ** CALL_FUNCTION instructions reworked

Fastcall
========

    * Fast calls (5 min)
    ** Python 3.5 creates temporary tuple and dict internally to call functions
    ** New API avoiding temporary tuple and dict
    ** Benchmark: many instructions are now up to 50% faster

    * Argument Clinic (3 min)
    ** Faster argument parsing in C code: new cache in C code parsing arguments (_PyArg_Parser)
    ** New METH_FASTCALL calling convention, reused by Cython

A new C calling convention, called "fast call", was introduced to avoid
temporary tuple and dict. The way Python parses arguments was also
optimized using a new internal cache.

Microbenchmark on calling builtin functions:

+--------------------------------------------+---------+------------------------------+
| Benchmark                                  | 3.5     | 3.7                          |
+============================================+=========+==============================+
| struct.pack("i", 1)                        | 105 ns  | 77.6 ns: 1.36x faster (-26%) |
+--------------------------------------------+---------+------------------------------+
| getattr(1, "real")                         | 79.4 ns | 64.4 ns: 1.23x faster (-19%) |
+--------------------------------------------+---------+------------------------------+

Microbenchmark on calling methods of builtin types:

+--------------------------------------------+---------+------------------------------+
| Benchmark                                  | 3.5     | 3.7                          |
+============================================+=========+==============================+
| {1: 2}.get(7, None)                        | 84.9 ns | 61.6 ns: 1.38x faster (-27%) |
+--------------------------------------------+---------+------------------------------+
| collections.deque([None]).index(None)      | 116 ns  | 87.0 ns: 1.33x faster (-25%) |
+--------------------------------------------+---------+------------------------------+
| {1: 2}.get(1)                              | 79.4 ns | 59.6 ns: 1.33x faster (-25%) |
+--------------------------------------------+---------+------------------------------+
| "a".replace("x", "y")                      | 134 ns  | 101 ns: 1.33x faster (-25%)  |
+--------------------------------------------+---------+------------------------------+
| b"".decode()                               | 71.5 ns | 54.5 ns: 1.31x faster (-24%) |
+--------------------------------------------+---------+------------------------------+
| b"".decode("ascii")                        | 99.1 ns | 75.7 ns: 1.31x faster (-24%) |
+--------------------------------------------+---------+------------------------------+
| collections.deque.rotate(1)                | 106 ns  | 82.8 ns: 1.28x faster (-22%) |
+--------------------------------------------+---------+------------------------------+
| collections.deque.insert()                 | 778 ns  | 608 ns: 1.28x faster (-22%)  |
+--------------------------------------------+---------+------------------------------+
| b"".join((b"hello", b"world") * 100)       | 4.02 us | 3.32 us: 1.21x faster (-17%) |
+--------------------------------------------+---------+------------------------------+
| [0].count(0)                               | 53.9 ns | 46.3 ns: 1.16x faster (-14%) |
+--------------------------------------------+---------+------------------------------+
| collections.deque.rotate()                 | 72.6 ns | 63.1 ns: 1.15x faster (-13%) |
+--------------------------------------------+---------+------------------------------+
| b"".join((b"hello", b"world"))             | 102 ns  | 89.8 ns: 1.13x faster (-12%) |
+--------------------------------------------+---------+------------------------------+

Microbenchmark on builtin functions calling Python functions (callbacks):

+--------------------------------------------+---------+------------------------------+
| Benchmark                                  | 3.5     | 3.7                          |
+============================================+=========+==============================+
| map(lambda x: x, list(range(1000)))        | 76.1 us | 61.1 us: 1.25x faster (-20%) |
+--------------------------------------------+---------+------------------------------+
| sorted(list(range(1000)), key=lambda x: x) | 90.2 us | 78.2 us: 1.15x faster (-13%) |
+--------------------------------------------+---------+------------------------------+
| filter(lambda x: x, list(range(1000)))     | 81.8 us | 73.4 us: 1.11x faster (-10%) |
+--------------------------------------------+---------+------------------------------+

Microbenchmark on calling slots (``__getitem__``, ``__init__``, ``__int__``)
implemented in Python:

+--------------------------------------------+---------+------------------------------+
| Benchmark                                  | 3.5     | 3.7                          |
+============================================+=========+==============================+
| Python __getitem__: obj[0]                 | 167 ns  | 87.0 ns: 1.92x faster (-48%) |
+--------------------------------------------+---------+------------------------------+
| call_pyinit_kw1                            | 348 ns  | 240 ns: 1.45x faster (-31%)  |
+--------------------------------------------+---------+------------------------------+
| call_pyinit_kw5                            | 564 ns  | 401 ns: 1.41x faster (-29%)  |
+--------------------------------------------+---------+------------------------------+
| call_pyinit_kw10                           | 960 ns  | 734 ns: 1.31x faster (-24%)  |
+--------------------------------------------+---------+------------------------------+
| Python __int__: int(obj)                   | 241 ns  | 207 ns: 1.16x faster (-14%)  |
+--------------------------------------------+---------+------------------------------+

Microbenchmark on calling a method descriptor (static method):

+--------------------------------------------+---------+------------------------------+
| Benchmark                                  | 3.5     | 3.7                          |
+============================================+=========+==============================+
| int.to_bytes(1, 4, "little")               | 177 ns  | 103 ns: 1.72x faster (-42%)  |
+--------------------------------------------+---------+------------------------------+

Faster codecs
=============

Operations on bytes and encodes like UTF-8 were optimized a lot thanks to a
new API to create bytes objects. The API allows very efficient
optimizations and reduces memory reallocations.

    * Bytes writter API (_PyBytesWriter) (3 min)
    ** API to handle memory allocation
    ** Much faster codecs (ASCII, Latin1, UTF-8) when error handlers are used: between 3x and 75x as fast
    ** bytes%args and bytearray%args are up to 2x as fast


_asyncio
========

Some parts of asyncio were rewritten in C to speedup code up to 25%. The
PyMem_Malloc() function now also uses the fast pymalloc allocator also
giving tiny speedup for free.

New C accelerator (_asyncio) for asyncio: speedup some asyncio code up to 25% (issue #26081)

Future
======

Finally, we will see optimization projects for Python 3.7: use fast calls
in more cases, speed up method calls, a cache on opcodes, a cache on global
variables.

    * Optimizations projects for Python 3.7 (3 min)
    ** Use fast calls in more cases (tp_call, tp_init and tp_new slots)
    ** Speed up method calls: LOAD_METHOD instruction, per-opcode cache
    ** Cache global variables



Questions
=========

Compare Python 2.7, 3.5, 3.6 and 3.7 performances:

    https://speed.python.org/comparison/
