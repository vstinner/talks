https://fosdem.org/2016/schedule/event/fat_python/

FAT Python
new static optimizer for CPython

    Track: Python devroom
    Room: UD2.218A
    Day: Saturday
    Start: 15:00
    End: 16:00


The Python language is hard to optimize. Let's see how guards checked at
runtime allows to implement new optimizations without breaking the Python
semantic.

(Almost) everything in Python is mutable which makes Python a language very
difficult to optimize. Most optimizations rely on assumptions, for example that
builtin functions are not replaced. Optimizing Python requires a trigger to
disable optimization when an assumption is no more true. FAT Python exactly
does that with guards checked at runtime. For example, an optimization relying
on the builtin len() function is disabled when the function is replaced.

Guards allows to implement various optimizations. Examples: loop unrolling
(duplicate the loop body), constant folding (propagates constants), copy
builtins to constants, remove unused local variables, etc.

FAT Python implements guards and an optimizer rewriting the Abstract Syntax
Tree (AST). The optimizer is implemented in Python so it's easy to enhance it
and implement new optimizations.

FAT Python uses a static optimizer, it is less powerful than a JIT compiler
like PyPy with tracing, but it was written to be integrated into CPython.

Speakers
        Victor Stinner (haypo)
Links

    FAT Python homepage

