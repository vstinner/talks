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


== On est bon ?

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

Code Python => AST => Bytecode

