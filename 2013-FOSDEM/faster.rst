###############################
Two projects to optimize Python
###############################

Description
-----------

http://python-fosdem.org/talk/10-two-projects-to-optimize-python

The Python bytecode is inefficient: the compiler generates useless and
redundant instructions, dead code and only implement basic optimizations. We
can do better! I will present two projects trying to generate better bytecode.

astoptimizer optimizes the abstract syntax tree (AST) of a Python program. It
tries to do as much work as possible at compile time. It is able to call
builtin functions with immutables arguments, simplifies expressions, optimizes
loops, iterators and generators, fold constants and removes dead code.
https://bitbucket.org/haypo/astoptimizer

registervm is a fork of Python 3.4 rewriting its evaluation loop to support new
instructions using registers instead of a stack. Bytecode using registers is
shorter (less instruction) and using registers allows new optimizations. For
example, it is much easier to move constants out of loops. registervm removes
useless instructions like LOAD_NAME following STORE_NAME, and useless jumps.
Duplicated constant loads are also removed.
http://hg.python.org/sandbox/registervm


Existing projects: Static
-------------------------

Subset of Python:

 * Shedskin, Pythran, Nuitka: compile a subset of Python to C++
 * Numba: LLVM, focused on numpy

Old projects: Dynamic
---------------------

Full Python:

 * (old) pysco: simple JIT
 * (old) Hotpy: XXX
 * (old) Unladen Swallow: LLVM, slow JIT using a lot of memory

New projects: Dynamic
---------------------

Full Python:

 * WPython
 * PyPy: really good JIT
 * Hotpy 2: status?
 * pymothoa: "don't support classes nor exceptions."

Why a new project?
------------------

 * CPython is still the reference for Python: new features are first
   implemented in CPython
 * CPython is still dominant in production
 * CPython is inefficient, we must do better!
 * A JIT is too much work

CPython is inefficient
----------------------

 * No-op jumps
 * Constant folding
 * Dummy operations like STORE_FAST, LOAD_FAST

 * Useless jump: JUMP_ABSOLUTE <offset+0>
 * Generate dead code: RETURN_VALUE; RETURN_VALUE (the second instruction is unreachable)
 * Duplicate constants: see TupleSlicing of pybench
 * Constant folding: see astoptimizer project
 * STORE_NAME 'f'; LOAD_NAME 'f'
 * STORE_GLOBAL 'x'; LOAD_GLOBAL 'x'

astoptimizer: How it works
--------------------------

 * Parser
 * AST <= astoptimizer!
 * Bytecode <= peepholer
 * Python evaluates bytecode

astoptimizer: optimizations
---------------------------

 * Call builtin functions:
   ``len("abc")`` => ``3``
 * Call methods of builtin types:
   ``(32).bit_length()`` => ``6``
 * Call functions of math and string modules:
   ``math.log(32) / math.log(2)`` => ``5.0``
 * Format strings for str%args and print(arg1, arg2, ...):
   ``"x=%s" % 5`` => ``"x=5"``
 * Simplify expressions:
   ``not(x in y)`` => ``x not in y``
 * Optimize loops:
   ``while True: pass`` => ``while 1: pass``
   ``for x in range(3): pass`` => ``for x in (0, 1, 2): pass``
   ``for x in range(1000): pass`` => ``for x in xrange(1000): pass``
 * Optimize iterators, list comprehension, and generators:
   ``set([x for x in "abc"])`` => ``{"a", "b", "c"}``
 * Replace list with tuple (need "builtin_funcs" feature). Examples:
   - ``for x in [1, 2, 3]: pass`` => ``for x in (1, 2, 3): pass``
 * Evaluate operators:
   ``1 + 2 * 3`` => ``7``
   ``"abcdef"[:3]`` => ``"abc"``
   ``def f(): return 2 if 4 < 5 else 3`` => ``def f(): return 2``
 * Remove dead code. Examples:
   - ``if DEBUG: print("debug")`` => ``pass`` with DEBUG declared as False


astoptimizer as a preprocessor
------------------------------

 * ``if debug:`` and ``if os.name == "nt":`` have a cost
 * astoptimizer evaluates tests during compilation and remove dead code:
   ``if 0:``
 * Pythonic preprocessor: no need to modify your code, your code will
   still work on any Python version without astoptimizer
 * avoids tricks like multiple definitions of the same function depending
   on the platform
 * constants must be marked as constant explictly:
   ``config.add_constant('os.name', os.name)``


astoptimizer: limitations
-------------------------

 * The result cannot only be stored as a PYC file, not back to PY file
 * Operations on mutable values are not optimized, ex: len([1, 2, 3]).
 * Unsafe optimizations are disabled by default. For example, len("\\U0010ffff") is not
   optimized because the result depends on the build options of Python. Enable
   "builtin_funcs" and "pythonenv" features to enable more optimizations.
 * On Python 3, comparaison between bytes and Unicode strings are not optimized
   because the comparaison may emit a warning or raise a BytesWarning
   exception. Bytes string are not converted to Unicode string. For example,
   b"abc" < "abc" and str(b"abc") are not optimized. Converting a bytes string
   to Unicode is never optimized.

registervm
----------

 * Allocate 256 registers
 * Replace instructions to use registers instead of the stack
 * SSA
 * Replace duplicate loads

   * LOAD_CONST_REG reg1, cst1; LOAD_CONST_REG reg2, cst1
   * STORE_NAME_REG name, value; LOAD_NAME_REG reg, name
     => STORE_NAME_REG name, reg1; MOVE_REG reg2, reg1
   * STORE_GLOBAL_REG; LOAD_GLOBAL_REG

 * Move LOAD_CONST_REG out of loops
 * Register allocator
 * Remove no-op jumps
 * Remove deadcode after RETURN_VALUE
 * Convert binary operator to inplace operator:

   - "x = x + y" to "x += y"

registervm: implementation issues
---------------------------------

 * Register Allocation
 * Control Flow
 * Data Flow
 * registervm uses basic and naive algorithms
 * registervm still emits invalid code

Example: Python
---------------

Simple function computing the factorial of n::

    def fact_iter(n):
        f = 1
        for i in range(2, n+1):
            f *= i
        return f

Example: Stack-based bytecode
-----------------------------

Stack-based bytecode (20 instructions)::

          0 LOAD_CONST           1 (const#1)
          3 STORE_FAST           'f'
          6 SETUP_LOOP           <relative jump to 46 (+37)>
          9 LOAD_GLOBAL          0 (range)
         12 LOAD_CONST           2 (const#2)
         15 LOAD_FAST            'n'
         18 LOAD_CONST           1 (const#1)
         21 BINARY_ADD
         22 CALL_FUNCTION        2 (2 positional, 0 keyword pair)
         25 GET_ITER
    >>   26 FOR_ITER             <relative jump to 45 (+16)>
         29 STORE_FAST           'i'
         32 LOAD_FAST            'f'
         35 LOAD_FAST            'i'
         38 INPLACE_MULTIPLY
         39 STORE_FAST           'f'
         42 JUMP_ABSOLUTE        <jump to 26>
    >>   45 POP_BLOCK
    >>   46 LOAD_FAST            'f'
         49 RETURN_VALUE

Example: Register-based bytecode
--------------------------------

Register-based bytecode (13 instructions)::


          0 LOAD_CONST_REG       'f', 1 (const#1)
          5 LOAD_CONST_REG       R0, 2 (const#2)
         10 LOAD_GLOBAL_REG      R1, 'range' (name#0)
         15 SETUP_LOOP           <relative jump to 57 (+39)>
         18 BINARY_ADD_REG       R2, 'n', 'f'
         25 CALL_FUNCTION_REG    4, R1, R1, R0, R2
         36 GET_ITER_REG         R1, R1
    >>   41 FOR_ITER_REG         'i', R1, <relative jump to 56 (+8)>
         48 INPLACE_MULTIPLY_REG 'f', 'i'
         53 JUMP_ABSOLUTE        <jump to 41>
    >>   56 POP_BLOCK
    >>   57 RETURN_VALUE_REG     'f'

The body of the main loop of this function is composed of 1 instructions
instead of 5.

Example: Benchmark
------------------

 * Stack: 25.8 ms
 * Register: 23.9 ms (-7.5%)

pybench
-------

 * BuiltinMethodLookup (without moving LOAD_ATTR_REG):

   - 24 ms => 1 ms, 24x faster
   - merge duplicate loads: 390 instructions => 22

 * NormalInstanceAttribute:

   - 40 ms => 21 ms (1.9x faster)
   - fewer instructions: 381 => 81

 * StringPredicates:

   - 42 ms => 24 ms (1.8x faster)
   - fewer instructions: 303 => 92

 * SimpleListManipulation:

   - 28 ms => 21 ms (1.3x faster)
   - fewer instructions: 388 => 114

 * SpecialInstanceAttribute:

   - 40 ms => 21ms, 1.9x faster
   - remove duplicate LOAD_ATTR_REG and useless instructions:
     381 instructions => 81

