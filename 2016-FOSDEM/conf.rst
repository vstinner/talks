FAT Python
new static optimizer for CPython

== Agenda

* Part 1: Python is slow
* Part 2: Specialize functions with guards
* Part 3: AST optimizers
* Part 4: Implementation
* Part 5: Future, TODO

== Part 1: Python is slow

=== Python is slow

* CPython is slower than C, "compiled" language
* Slower than Javascript and its JIT compilers

== Existing optimizers

* JIT: PyPy (RPython), Pyston (LLVM), Pyjion (.NET)
* Numba (LLVM): specialized to numeric types (numpy)
* Cython: static optimizer

Fact: none replaced CPython yet.

... even if PyPy is much faster than CPython!

=== Goal

Replace::

    def func():
        return len("abc")

with::

    def func():
        return 3

=== Problem

* *Everything* is mutable in Python
* Builtin functions
* Function code
* Function local variables

== Problem

Replace a builtin function::

    builtins.len = lambda obj: "mock!"
    print(len("abc"))

Output::

    mock!

== Constraints

* Respect the Python semantics
* Don't break applications
* Don't require to modify the source code

== New static optimizer

Goal:

* Must not make Python slower than unused
* Negligible overhead at startup

Non-goal:

* Not a JIT: it's a *static* optimizer, run ahead of time
* C API unchanged, don't expect better memory footprint or crazy
  optimizations on boxing/unboxing objects

== Part 2: Specialization, guards and AST optimizers

== Guards

* Make Python "immutable" again
* Check if something changed
* Example of guard: was the len() function replaced?

== Guards on namespaces

* Builtins, module, class, function, list-comprehension, etc. have their
  own namespace
* In practice, a namespace is a Python dict
* Technical challenge: implement fast guards on namespace
* Solution: add a private "version" to dict, incremented at each change

== Specialization

* Efficent optimizations require assumptions
* Guards provide us various kinds of assumptions
* Code can be specialize for a specific environment
* Example: optimize the case when len() was not replaced
* Example: optimize if the first parameter is an int
* everything is mutable: we can use "guards" to have assumptions
* then specialize with these assumptions

== Specialization

Pseudo code:

    if check_guards():
        code = super_fast_specialized_code
    else:
        code = original_original
    execute(code)

== Peephole optimizer

* CPython peephole optimizer is implemented in C
* Narrow view of the code: optimize a few instructions
* Constant folding
* Dead code elimitation
* Remove useless jumps

== AST

Arbre syntaxique abstrait (Abstract Syntax Tree, AST).

Code Python => AST => Bytecode

== AST

len("abc") as AST::

Call(func=Name(id='len', ctx=Load()), args=[Str(s='abc')])

== AST optimizer

Most basic AST optimizer::

class Optimizer(ast.NodeTransformer):
    def visit_Call(self, node):
        return ast.Num(n=3)

== Implementation of FAT Python

PEPs:

* PEP 509: dict version
* PEP 510: Function specialization with guards
* PEP 511: API for code transformers

== Changes already merged

* ast.Constant
* Support negative line number delta in co_lnotab of code objects
* Support tuple and frozenset constants in the compiler
* marshal uses the empty frozenset singleton

== PEP 510 & Cython

* XXX

== Optimizations already implemented

* Call pure builtin functions
* Loop unrolling
* Constant propagation
* Constant folding
* Replace builtin constants (__debug__)
* Dead code elimitation
* Copy builtin functions to constants
* Simplify itereable

== Future optimizations

* Constang propagation accross different namespaces, especially for global
  variables
* Detect pure functions: call them at the compilation, like GCC strlen("abc")
* Elimination of unused variables
* Specialization for argument types
* Call methods of constants: 'abc'.encode('utf-8') => b'abc'
* Convert keyword arguments to positional arguments
* Move invariant out of loops: obj.append() => obj_append = obj.append,
  need a guard on the object type, obj.__getattribute__('append') can do crazy things

== Python semantics and limitations

* guards only checked when a function is called, not in the middle of the function
* builtins can be modified anytime from anywhere: threads, signals, etc.
* concrete issue: unittest.mock.patch() used to mock builtin functions

Much more optimizations are planned!

== Profiling

* Run the application in a profiler recording types of function arguments
  and variables
* Generate type annotations
* Use thee annotations to specialize functions
