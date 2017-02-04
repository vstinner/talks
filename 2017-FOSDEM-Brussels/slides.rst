+++++++++++++++++++++++++++++
How to run a stable benchmark
+++++++++++++++++++++++++++++

Victor Stinner
==============

* CPython core developer since 2010
* Working for Red Hat on OpenStack
* Fan of optimization, profiling and benchmarks!

Agenda
======

* What the is problem?
* Causes of benchmark instabilities
* perf module
* CPython benchmarks

What is the problem?
====================

Optimization 1: BINARY_ADD
--------------------------

* In 2014, optimization for int + int operator
* 14 patches
* multiple authors
* is it worth it?
* *The Grand Unified Python Benchmark Suite*
* some benchmarks were slower, some were faster, but **randomly**
* "unreliable" and "unstable" benchmarks?

Optimization 2: FASTCALL
------------------------

* April 2014, I experimented a change to avoid temporary tuple
  to call functions
* Promising results: many builtin functions 20-50% faster!
* *But* some benchmarks were slower
* Bisection to reduce a 10.000 lines patch to... a patch only adding a new
  function, but don't call it!?
* Few benchmarks still XXX% slower

Requirement
-----------

* Reproductible benchmark results on the same computer
* Unreliable benchmarks => risk of taking a bad decision?
* Patch makes Python faster, slower or... is not significant?

Causes of benchmark instabilities
=================================

* Isolated CPUs
* NOHZ_FULL
* Code placement and PGO

  - ASLR
  - Randomized Python hash function
  - Environment variables
  - Command line arguments
  - etc.

* Average
* perf project

System noise
============

* Applications and the kernel share resources like CPU, memory and storage
* CPU-bound microbenchmark::

    $ python3 -m timeit 'sum(range(10**7))'

* Idle system: **229** msec
* Busy system, run multiple times::

    python3 -c 'while True: pass'

* High system load: **372** msec (1.6x slower, +62%)


Isolated CPUs
-------------

* Linux allows to "isolate" CPUs: not schedule processes on them
* Enter GRUB, add ``isolcpus=3`` to the Linux command line
* Check /sys/devices/system/cpu/isolated
* Run script on CPU 3::

    taskset -c 3 python3 script.py

* Idle system: **229** msec
* High system load: **372** msec (1.6x slower, +62%)
* High system load, isolated CPU: **230** msec (same speed!)
* Isolated CPUs are not impacted by other applications!
* In htop, see all CPUs busy in htop except of isolated CPUs

NOHZ_FULL and rcu_nocbs
=======================

* nohz_full=3: when only 0 or 1 application runs on CPU 3, disable all
  interruptions of this CPU
* rcu_nocbs=3: avoid running kernel code  on the CPU 3
* Be aware of NUMA and HyperThreading: ``lscpu --all --extended``

htop
====

* SCREENSHOT

Deadcode
========

* I reduced my 10.000 lines patch to a patch adding an unused function
* Adding a C function makes Python slower
* Modify the added function to remove its body: Python becomes faster
* WTF??


Deadcode: perf
==============

* Great Linux perf tool to analyze CPU caches:
  hint: use --repeat=10 for more reliable metrics.
  Look at branches, L1 instruction cache, L1 data cache, stallen CPU cycles
  (CPU is fetching instructions from the memory)
* ... nothing obvious: same numbers on reference, slower and faster binaries

Deadcode: cachegrind
====================

* Valgrind includes a cachegrind tool which simulates CPU caches to estimate
  the performance of these caches
* Nothing obvious


Deadcode: strace, ltrace
========================

* Different memory addresses...
* .... no major difference which can explain timing differences

Deacode: compiler options
=========================

* -O0, -O1, -O2, -O3
* -falign-functions=N
* -Os
* -fomit-frame-pointer
* -flto (Link Time Optimization: LTO)
* ... everything now looks random, pure noise...

Deacode: PGO
============

* The root issue is code "code placement"
* Depending on the exact memory layout and code layout,
  performance can vary a lot
* Control memory layout: disabling ASLR helps
* Control code layout: __attribute__((hot)) helps, but it's not enough
* Profile Guided Optimization (PGO) is the real solution

Worst microbenchmark
====================

* bm_call_simple.py
* Performance of calling a Python function
* Simple, isn't it?

ASLR and Python randomized hash function
========================================

* Disable ASLR: "echo 0|sudo tee /proc/sys/kernel/randomize_va_space"
* Results still random
* Linux perf shows that sometimes, Python spends more time in hash table
  to find keys. Maybe some runs get more hash collisitons than others?

3 runs with 3 fixed hash functions:

    $ PYTHONHASHSEED=1 ./python bm_call_simple.py
    0.198
    $ PYTHONHASHSEED=3 ./python bm_call_simple.py
    0.207   # slower?
    $ PYTHONHASHSEED=4 ./python bm_call_simple.py
    0.187   # faster!


Env vars, cwd
=============

* Isolated CPU, fixed ASLR, fixed hash function
* Working directly, command line::

    $ cd /home/haypo/prog/python/fastcall
    $ pgo/python ../benchmarks/performance/bm_call_simple.py -n 1
    0.215

    $ cd /home/haypo/prog/python/benchmarks
    $ ../fastcall/pgo/python ../benchmarks/performance/bm_call_simple.py -n 1
    0.203

    $ cd /home/haypo/prog/python
    $ fastcall/pgo/python benchmarks/performance/bm_call_simple.py -n 1
    0.200

* WTF?

Env vars
========

* Isolated CPU, fixed ASLR, fixed hash function
* Env vars::

    $ taskset -c 1 env -i PYTHONHASHSEED=3 ./python bm_call_simple.py -n 1
    0.201
    $ taskset -c 1 env -i PYTHONHASHSEED=3 VAR1=1 VAR2=2 VAR3=3 VAR4=4 ./python bm_call_simple.py -n 1
    0.202
    $ taskset -c 1 env -i PYTHONHASHSEED=3 VAR1=1 VAR2=2 VAR3=3 VAR4=4 VAR5=5 ./python bm_call_simple.py -n 1
    0.198

Env vars
========

* Isolated CPU, fixed ASLR, fixed hash function
* Command line::

    $ PYTHONHASHSEED=3 taskset -c 1 ./python bm_call_simple.py -n 1
    0.201
    $ PYTHONHASHSEED=3 taskset -c 1 ./python bm_call_simple.py -n 1 arg1 arg2 arg3 arg4 arg5 arg6
    0.210  # slower, even if args are ignored!?

* WTF?+++

Average
=======

* Too many things have an impact on the memory layout and so the code placement
* Just stop! What is your goal? Reliable benchmarks!
* Run the benchmark N times: spawn 20 worker processes
* Compute average and standard deviation
* Enable ASLR, randomized hash function

perf project
============

* Project started to spawn multiple worker processes sequentially
* Compute average and standard deviation
* JSON exchange format for samples
* Don't store average but all samples: allow to append more samples later
  to increase the reliability and more
* Statistics: min/max, samples#, dates, etc.
* Metadata: snapshot of the system state, CPU frequency, sensors,
  hostname, Python version, etc.
* Metadata helps to detect misconfigured system or benchmark ran on different
  configurations
* Example: error if benchmark ran on two different Python versions

More nightmare: Turbo Boost
===========================

* Sometimes, I noticed that **suddenly** a benchmark became 20% faster whereas
  I didn't touch anything, whereas it was slower 10 secondes ago.
* WTF++++
* Today, CPU frequency is no more fixed, it changes anytimes
* /proc/cpuinfo is not reliable
* Use turbostat: CPU frequency average, %time spend in different power states
* Turbo Boost: 20% faster when a single core is running, 10% faster if only two
  cores are active, etc.
* Disable Turbo Boost::

  echo 1|sudo tee /sys/devices/system/cpu/intel_pstate/no_turbo

More more nightmare: Intel Pstate and NOHZ_FULL
===============================================

After days, nights and months of benchmarks, everything was perfectly stable
until... the big drama.

A friday, I was running the same benchmark for 24 hours to measure the impact
of compiler options on performances. When I closed my GNOME session, the
benchmark became 20% faster.

WHAAAAAAAAAAAAAAAAAAAAAAAAT?

ASLR, hash function, Turbo Boost, WTF++++.... WTF *again*?

It took me one month (analyze effect of the CPU temperature) to find a reliable
way to reproduce the bug:
https://bugzilla.redhat.com/show_bug.cgi?id=1378529

The Intel maintainer of the intel_pstate CPU driver confirmed me that he never
tested his driver with isolated CPU and NOHZ_FULL.

I discussed with Linux RealTime (RT) engineers and my colleague Frederic
Weisbecker who developped NOHZ_FULL.

NOHZ_FULL disables interruptions. Ok.

intel_pstate driver is called by the Linux scheduler. Ok.

The Linux scheduler interrupts the running process HZ times per second to
run its code. intel_pstate callbacks are called here.

NOHZ_FULL disables interruptions. So what?

With NOHZ_FULL, intel_pstate doesn't update Pstates anymore. The Pstate
of the CPU used for benchmarks doesn't rely on workload anymore. In short,
it depends on the workload of other CPUs.

Since I was using my desktop PC to run benchmarks, the benchmark results
depend on how I use my computer for other tasks...

It *want* to call NOHZ_FULL+intel_pstate a kernel bug... But developers want to
call it a feature...

By design, if interruptions are disabled, intel_pstate is not more called.
Understood? No?

Well, the summary is: *never* use NOHZ_FULL with intel_pstate and variable CPU
Pstates. Run the CPU at a fixed frequency or don't use NOHZ_FULL.

I chose to stop using NOHZ_FULL since I still want to be able to use my
computer for other tasks.

More more more?
===============

* Well, I was bitten one more time by code placement
* PGO compiler crashed with a GCC bug on Ubuntu 14.04
* speed-python server upgraded to Ubuntu 16.04
* Old results removed, benchmarks ran again
* Performance history on one year
* Now super table
* A few remaining a only stable, not super stable, but still much more stable
  than what we had one year ago!

How to use perf?
================

Please stop using timing
------------------------

::

    $ python3 -m timeit -s "d=dict.fromkeys(map(str,range(10**6)))" "list(d)"
    10 loops, best of 3: 46.7 msec per loop
    $ python3 -m timeit -s "d=dict.fromkeys(map(str,range(10**6)))" "list(d)"
    10 loops, best of 3: 46.9 msec per loop
    $ python3 -m timeit -s "d=dict.fromkeys(map(str,range(10**6)))" "list(d)"
    10 loops, best of 3: 46.9To msec per loop
    $ python3 -m timeit -s "d=dict.fromkeys(map(str,range(10**6)))" "list(d)"
    10 loops, best of 3: 47 msec per loop

    $ python2 -m timeit -s "d=dict.fromkeys(map(str,range(10**6)))" "list(d)"
    10 loops, best of 3: 36.3 msec per loop
    $ python2 -m timeit -s "d=dict.fromkeys(map(str,range(10**6)))" "list(d)"
    10 loops, best of 3: 36.1 msec per loop
    $ python2 -m timeit -s "d=dict.fromkeys(map(str,range(10**6)))" "list(d)"
    10 loops, best of 3: 36.5 msec per loop

    $ python3 -m timeit -s "d=dict.fromkeys(map(str,range(10**6)))" "list(d)"
    10 loops, best of 3: 48.3 msec per loop
    $ python3 -m timeit -s "d=dict.fromkeys(map(str,range(10**6)))" "list(d)"
    10 loops, best of 3: 48.4 msec per loop
    $ python3 -m timeit -s "d=dict.fromkeys(map(str,range(10**6)))" "list(d)"
    10 loops, best of 3: 48.8 msec per loop

Please stop using timing
------------------------

::

    $ python3 -m timeit -s "d=dict.fromkeys(map(str,range(10**6)))" "list(d)"
    10 loops, best of 3: 46.7 msec per loop
    (...)
    $ python3 -m timeit -s "d=dict.fromkeys(map(str,range(10**6)))" "list(d)"
    10 loops, best of 3: 48.8 msec per loop

46.7 or 48.8 ms? What is the standard deviation? Stop!

Use perf::

    haypo@selma$ python3 -m perf timeit 'sorted(range(1000))'
    .....................
    Median +- std dev: 32.9 us +- 1.8 us

perf emits a warning if the benchmark is unstable::

    haypo@selma$ python3 -m perf timeit 'len("abc")' -l 1
    ....................
    ERROR: the benchmark may be very unstable, the shortest raw sample only took 514 ns
    Try to rerun the benchmark with more loops or increase --min-time

    Median +- std dev: 607 ns +- 60 ns

Compare with::

    haypo@selma$ python3 -m perf timeit 'len("abc")'
    .....................
    Median +- std dev: 49.6 ns +- 2.8 ns


Behind the scene
================

Verbose mode::

    haypo@selma$ python3 -m perf timeit 'len("abc")' -v -o len.json
    Run 1/21: calibrate
    - 1 loop: 1.15 us
    - 2 loops: 958 ns
    (...)
    - 2^21 loops: 116 ms
    Calibration: use 2^21 loops

    Run 2/21: warmup (1): 51.9 ns; samples (3): 51.0 ns, 50.5 ns, 51.1 ns
    (...)
    Run 7/21: warmup (1): 54.5 ns; samples (3): 50.4 ns (-5%), 53.1 ns, 60.0 ns (+13%)
    (...)
    Run 21/21: warmup (1): 50.8 ns; samples (3): 50.0 ns, 49.6 ns, 49.4 ns

    Median +- std dev: 50.3 ns +- 4.1 ns


Analyze
=======

::

    haypo@selma$ python3 -m perf show len.json
    Median +- std dev: 50.3 ns +- 4.1 ns

Analyze
=======

Statistics::

    haypo@selma$ python3 -m perf stats len.json
    Total duration: 8.9 sec
    Start date: 2017-02-02 17:04:47
    End date: 2017-02-02 17:05:00
    Raw sample minimum: 103 ms
    Raw sample maximum: 163 ms

    Number of runs: 21
    Total number of samples: 60
    Number of samples per run: 3
    Number of warmups per run: 1
    Loop iterations per sample: 2^21

    Minimum: 49.3 ns (-2%)
    Median +- std dev: 50.3 ns +- 4.1 ns
    Mean +- std dev: 51.4 ns +- 4.1 ns
    Maximum: 77.8 ns (+55%)

Warning: ``77.8 ns (+55%)`` doesn't seem good.


Hist
====

::

    48.0 ns: 11 ###################
    49.8 ns: 38 #################################################################
    51.6 ns:  4 #######
    53.3 ns:  2 ###
    55.1 ns:  0 |
    56.9 ns:  3 #####
    58.7 ns:  1 ##
    60.4 ns:  0 |
    62.2 ns:  0 |
    64.0 ns:  0 |
    65.8 ns:  0 |
    67.6 ns:  0 |
    69.3 ns:  0 |
    71.1 ns:  0 |
    72.9 ns:  0 |
    74.7 ns:  0 |
    76.4 ns:  1 ##

76.4 ns: what happened?

Linux not tuned for benchmark.


Metadata
========

All::

    $ python3 -m perf metadata len.json
    Metadata:
    - aslr: Full randomization
    - boot_time: 2017-02-01 07:44:47
    - cpu_config: 0-3=driver:intel_pstate, intel_pstate:turbo, governor:powersave; idle:intel_idle
    - cpu_count: 4
    - cpu_model_name: Intel(R) Core(TM) i7-3520M CPU @ 2.90GHz
    - hostname: selma
    - loops: 2^21
    - name: timeit
    - perf_version: 0.9.4
    - platform: Linux-4.9.5-200.fc25.x86_64-x86_64-with-fedora-25-Twenty_Five
    - python_cflags: -Wno-unused-result -Wsign-compare -DDYNAMIC_ANNOTATIONS_ENABLED=1 -DNDEBUG -O2 -g -pipe -Wall -Werror=format-security -Wp,-D_FORTIFY_SOURCE=2 -fexceptions -fstack-protector-strong --param=ssp-buffer-size=4 -grecord-gcc-switches -specs=/usr/lib/rpm/redhat/redhat-hardened-cc1 -m64 -mtune=generic -D_GNU_SOURCE -fPIC -fwrapv
    - python_executable: /usr/bin/python3
    - python_implementation: cpython
    - python_version: 3.5.2 (64-bit)
    - timeit_stmt: 'len("abc")'
    - timer: clock_gettime(CLOCK_MONOTONIC), resolution: 1.00 ns

System::

    - cpu_count: 4
    - cpu_model_name: Intel(R) Core(TM) i7-3520M CPU @ 2.90GHz
    - hostname: selma
    - perf_version: 0.9.4
    - platform: Linux-4.9.5-200.fc25.x86_64-x86_64-with-fedora-25-Twenty_Five
    - python_implementation: cpython
    - python_version: 3.5.2 (64-bit)
    - timer: clock_gettime(CLOCK_MONOTONIC), resolution: 1.00 ns

Benchmark::

    - loops: 2^21
    - name: timeit
    - timeit_stmt: 'len("abc")'

System configuration, hardware state::

    - aslr: Full randomization
    - boot_time: 2017-02-01 07:44:47
    - cpu_config: 0-3=driver:intel_pstate, intel_pstate:turbo, governor:powersave; idle:intel_idle

Version::

    - perf_version: 0.9.4
    - platform: Linux-4.9.5-200.fc25.x86_64-x86_64-with-fedora-25-Twenty_Five
    - python_version: 3.5.2 (64-bit)


perf system tune
================

::

    $ sudo python3 -m perf system tune
    Tune the system configuration to run benchmarks

    Actions
    =======

    Perf event: Max sample rate set to 1 per second
    CPU Frequency: Minimum frequency of CPU 2-3 set to the maximum frequency
    Turbo Boost (intel_pstate): Turbo Boost disabled: ...
    IRQ affinity: Set default affinity to CPU 0-1
    ...

    System state
    ============

    Perf event: Maximum sample rate: 1 per second
    ASLR: Full randomization
    Linux scheduler: Isolated CPUs (2/4): 2-3
    Linux scheduler: RCU disabled on CPUs (2/4): 2-3
    CPU Frequency: 0-1=min=1200 MHz, max=3600 MHz; 2-3=min=max=3600 MHz
    Turbo Boost (intel_pstate): Turbo Boost disabled
    ...
    Power supply: the power cable is plugged


CPython benchmarks
==================

* Results published at http://speed.python.org/
* Results on the 2016
* Nice speedup in 2016, single example:
  <picture of telco>
* https://github.com:python/performance
* https://github.com:haypo/perf.git

Questions?
==========

Questions?

https://github.com:haypo/perf.git

Bonus slides
============

Microbenchmarks
---------------

* Macrobenchmarks and microbenchmarks
* My own definition: a microbenchmark measures a single function
  which takes less than 1 ms. In CPython, it's common that timings are close to
  100 ns (only 300 instructions on a 3 GHz CPU)
* The more short the timing is, the more issues you will start to see
* Microbenchmarks are commonly used in CPython to justifiy a "micro
  optimization"



==

https://fosdem.org/2017/schedule/event/python_stable_benchmark/

How to run a stable benchmark

Working on optimizations is a task more complex than expected on the first look. Any optimization must be measured to make sure that, in practice, it speeds up the application task. Problem: it is very hard to obtain stable benchmark results.

The stability of a benchmark (performance measurement) is essential to be able to compare two versions of the code and compute the difference (faster or slower?). An unstable benchmark is useless, and is a risk of giving a false result when comparing performance which could lead to bad decisions.

I'm gonna show you the Python project "perf" which helps to launch benchmarks, but also to analyze them: compute the mean and the standard deviation on multiple runs, render an histogram to visualize the probability curve, compare between multiple results, run again a benchmark to collect more samples, etc.

The use case is to measure small isolated optimizations on CPython and make sure that they don't introduce performance regression in term of performance.

