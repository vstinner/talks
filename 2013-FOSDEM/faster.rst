###############################
Two projects to optimize Python
###############################

Description
-----------

http://python-fosdem.org/talk/10-two-projects-to-optimize-python

Track: Python devroom
Room: K.3.401
Day: Sunday
Start: 15:30
End: 15:55

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

Agenda
------

 * CPython is inefficient
 * Optimize AST
 * Register-based bytecode
 * State of the art


CPython is inefficient
----------------------

 * Python is very dynamic
 * CPython 3.3 peepholer only support basic optimizations:
   1+1 replaced with 2
 * Bytecode is inefficient


CPython: inefficient bytecode
-----------------------------

Python source code::

    def func():
        x = 33
        return x


CPython: inefficient bytecode
-----------------------------

I get 4 instructions::

    LOAD_CONST 1 (33)
    STORE_FAST 0 (x)
    LOAD_FAST  0 (x)
    RETURN_VALUE


CPython: inefficient bytecode
-----------------------------

I expected (2 instructions)::

    LOAD_CONST 1 (33)
    RETURN_VALUE


CPython: inefficient bytecode
-----------------------------

Or even (1 instruction)::

    RETURN_VALUE <const #1> (33)


How Python works
----------------

Different states of Python code:

 * Parser
 * Abstract Syntax Tree (Tree)
 * Bytecode
 * Python evaluates bytecode


Optimize AST
------------

 * AST contains a lot of information
 * Implement an AST optimizer is simple, but nobody did it before
 * Rewrite the AST the emit faster code
 * Some dynamic features must be turned off to allow more assumptions
 * All optimizations are configurable
 * Unpythonic optimizations are disabled by default


AST optimizations (1)
---------------------

 * Call builtin functions:
   ``len("abc")`` => ``3``
 * Call methods of builtin types:
   ``(32).bit_length()`` => ``6``
 * Call functions of math and string modules:
   ``math.log(32) / math.log(2)`` => ``5.0``
 * Format strings for str%args and print(arg1, arg2, ...):
   ``"x=%s" % 5`` => ``"x=5"``
   ``print(1.5)`` => ``print("1.5")``


AST optimizations (2)
---------------------

 * Simplify expressions:
   ``not(x in y)`` => ``x not in y``
 * Optimize loops:
   ``while True: ...`` => ``while 1: ...``
   ``for x in range(3): ...`` => ``for x in (0, 1, 2): ...``
   ``for x in range(1000): ...`` => ``for x in xrange(1000): ...``
 * Optimize iterators, list comprehension, and generators:
   ``set([x for x in "abc"])`` => ``{"a", "b", "c"}``

AST optimizations (3)
---------------------

 * Replace list with tuple:
   - ``for x in [1, 2, 3]: ...`` => ``for x in (1, 2, 3): ...``
 * Evaluate operators:
   ``1 + 2 * 3`` => ``7``
   ``"abcdef"[:3]`` => ``"abc"``
   ``def f(): return 2 if 4 < 5 else 3`` => ``def f(): return 2``
 * Remove dead code. Examples:
   - ``if DEBUG: print("debug")`` => ``pass`` with DEBUG declared as False

Faster code
-----------

 * fastest code depends on the Python version
 * tuple and frozenset are constants
 * list and dict are created at runtime
 * ``while True: ...`` requires to lookup for the name True in Python 2
 * True is a constant in Python 3


astoptimizer configuration
--------------------------

 * Unsafe (unpythonic) optimizations are disabled by default
 * astoptimizer is not really "pythonic"
 * Optimizations can be enabled in the config


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


astoptimizer TODO list
----------------------

 * Constant folding: experimental code still have bugs
 * Unroll (short) loops
 * Function inlining
 * Integrate astoptimizer in Python 3.4!


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


CPython evulation loop
----------------------

CPython bytecode uses a small stack. Example::

    def func2():
        x = 33
        return x + 1


Stack-based bytecode
--------------------

Stack-based bytecode (6 instructions)::

    LOAD_CONST 1 (33)  # stack: []
    STORE_FAST 0 (x)   # stack: [33]
    LOAD_FAST  0 (x)   # stack: []
    LOAD_CONST 2 (1)   # stack: [33]
    BINARY_ADD         # stack: [33, 1]
    RETURN_VALUE       # stack: [34]

Register-based bytecode
-----------------------

I want to replace the stack with registers.

Register-based bytecode (4 instructions)::

    LOAD_CONST_REG 'x', 33 (const#1)
    LOAD_CONST_REG R0, 1 (const#2)
    BINARY_ADD_REG R0, 'x', R0
    RETURN_VALUE_REG R0


registervm implementation
-------------------------

 * Replace instructions to use registers instead of the stack
 * Use the single assignment form (SSA)
 * Build the control flow graph
 * Apply different optimizations
 * Run a register allocator
 * Recompute jumps
 * Emit bytecode

registervm implementation
-------------------------

 * Local variables are just a special case of registers

registervm optimizations
------------------------

 * Using registers allow more optimization like moving constant
   loads out of loops
 * Replace duplicate load/store instructions: constants, names, globals, etc.
 * Remove useless jumps (relative jump +0)
 * Remove deadcode: unreachable instructions
 * Convert binary operator to inplace operator:
   "x = x + y" => "x += y"

registervm
----------

 * Constant folding
 * Dummy operations like STORE_FAST, LOAD_FAST

 * Useless jump: JUMP_ABSOLUTE <offset+0>
 * Generate dead code: RETURN_VALUE; RETURN_VALUE (the second instruction is unreachable)
 * Duplicate constants: see TupleSlicing of pybench
 * Constant folding: see astoptimizer project
 * STORE_NAME 'f'; LOAD_NAME 'f'
 * STORE_GLOBAL 'x'; LOAD_GLOBAL 'x'

registervm: implementation issues
---------------------------------

 * Register Allocation
 * Control Flow
 * Data Flow
 * registervm uses basic and naive algorithms
 * registervm still emits invalid code

registervm TODO list
--------------------

 * Fix bugs: better code to understand the control graph
 * Constants as read-only registers: no more LOAD_CONST_REG instruction
 * Move loading attributes out of loops, but only for methods


registervm: pybench
-------------------

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

Questions ?
-----------

 * https://bitbucket.org/haypo/astoptimizer
 * http://hg.python.org/sandbox/registervm

