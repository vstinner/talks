http://python-fosdem.org/talk/10-two-projects-to-optimize-python

Two projects to optimize Python

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
