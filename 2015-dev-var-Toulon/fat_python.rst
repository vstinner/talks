http://devvar.org/devvar12.html

Source photos: https://commons.wikimedia.org/wiki/File:Stra%C5%BCnik_przed_Pa%C5%82acem_Buckingham;_Buckingham_guard.JPG#

= Le projet FAT Python

Python est langage de programmation difficile à optimiser, encore plus que les
autres langages de script, notamment parce que tout est modifiable dans Python.
Nous allons voir comment l'ajout de "gardes" testés à l'exécution permet
d'implémenter des optimisations sans casser la sémantique du langage Python.


== Python est lent

Comparé au C, Javascript
xxx fois plus lent


== Problème

Optimiser ::

    def func():
        return len("abc")


== Facile !

Version optimisée ::

    def func():
        return 3


== Tout est modifiable

* Fonctions builtins : module builtins
* Code d'une fonction : func.__code__
* Variables locales
* etc.

== Tout est modifiable

Code::

    print(len("abc"))
    builtins.len = lambda obj: "mock!"
    print(len("abc"))

Sortie::

    3
    "mock"

Bug::

    3
    3


== Gardes

Idée : tester si builtins.len a été modifié

Pseudo-code::

    if garde_ok():
        version_optimisée()
    else:
        version_normale()

Code::

    def func():
        return len("abc")

    def fast():
        return 3

    func.specialize(fast,
                    [{'guard_type': 'builtins',
                      'name': 'len'}])

== AST

Arbre syntaxique abstrait (Abstract Syntax Tree, AST).

Code Python => AST => Bytecode


== AST

len("abc") as AST::

    Call(func=Name(id='len', ctx=Load()),
         args=[Str(s='abc')])

== AST transformer

Code::

    class Optimizer(ast.NodeTransformer):
        def visit_Call(self, node):
            return ast.Num(n=3)

== Optimisations

* Call pure builtins
* Loop unrolling
* Constant propagation
* Constant folding
* Replace builtin constants
* Dead code elimination
* Copy builtin functions to constants


== More optimisations

* Function inlining


= Questions

Merci

https://faster-cpython.readthedocs.org/fat_python.html

