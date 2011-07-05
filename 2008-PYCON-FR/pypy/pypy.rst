 .. footer:: Victor Stinner - Pycon FR 2008

PyPy : l'interprète Python écrit en Python

 .. image:: manneken_pis2.jpg
    :align: center

Victor Stinner - Ptycon 2008

C'est quoi PyPy ?
=================

 * Interprète Python écrit en Python
 * 100% compatible Python 2.4
 * Permet d'expérimenter des technologies
 * Applications réelles 1,5 à 3x plus lente

Motivation du projet
====================

 * Étendre l'implémentation de Python
 * Améliorer les performances
 * Ajouter de l'expressivité
 * Faciliter le portage

Faire évoluer CPython ?
=======================

 * Portabilité de code C
 * psyco et stackless difficiles à maintenir
 * Choix difficiles à changer (compteur de référence)

Interprète Python
=================

 * Langage interprété :
 * Script Python (.py) compilé en *bytecode* (.pyc)
 * Traduit en code machine par l'interprète

Projet fédérateur
=================

 * Jython
 * IronPython
 * Stackless
 * psyco

Langage RPython
===============

 * Noyau de PyPy écrit en RPython
 * Sous-ensemble de Python
 * Beaucoup de contraintes

Évaluation paresseuse
=====================

::

    $ pypy -o thunk
    >>> def f():
    ...    print 'computing...'
    ...    return 6*7
    ...
    >>> from __pypy__ import thunk

Évaluation paresseuse (suite)
=============================

::

    (...)
    >>> x = thunk(f)
    >>> x
    computing...
    42
    >>> x
    42

Proxy transparent
=================

 * Observer les opérations faites sur un objet
 * Remplacer les opération faites sur un objet
 * Transparence réseau

Coroutines de Stackless
=======================

 * Chaque fonction est une coroutine
 * Tasklet et channel
 * Sérialiser une coroutine
 * Cloner une coroutine

Optimisations
=============

 * Inlining des fonctions
 * Suppression d'allocations mémoires
 * Structures typées

Expérimentations
================

 * Ramasse-miettes
 * Nombre entier (int)
 * Chaîne de caractères (str)

Backends PyPy
=============

 * Avancés : C et LLVM
 * Actifs : et  JVM
 * Expérimentaux : Javascript et Squeak

Compilation à la volée (JIT)
============================

 * En cours de développement
 * Performances similaires à psyco
 * Portage plus simple que psyco

Bac à sable
===========

 * Environnement isolé pour exécuter du code
 * Isolement des appels aux fonctions externes
 * Pas de segfault possible

Modules externes
================

 * Nombreux modules écrits avec API C Python
 * Modules à réécrire avec ctypes

Divers
======

 * Projets abandonné : programmation logique
 * PyPy est publié sous licence MIT
 * Projet développé sous forme de sprints

Questions ?
===========

 * http://codespeak.net/pypy - Site web
 * http://morepypy.blogspot.com - Blog
 * Salon IRC #pypy sur Freenode (irc.freenode.net)

Cette présentation
==================

 * Photo du *Manneken Pis* de flickr.com sous licence Creative Commons
 * Thème dessiné par Olivier Grisel

