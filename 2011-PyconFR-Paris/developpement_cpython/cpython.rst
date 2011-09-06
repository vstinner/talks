++++++++++++++++++++++++
Développement de CPython
++++++++++++++++++++++++

 * Vu par un core developer
 * Pycon FR 2011, Rennes

CPython ?
=========

* Interprète
* Bibliothèque standard : 183 modules (de errno à concurrent.futures)
* Documentation (182 000 lignes de reST)
* 1 million de ligne de code
* (410k de C, 630k de Python)

Développeurs
============

 * Misc/ACKS : 1046 contributeurs
 * Doc/ACKS : 224 contributeurs
 * Core : ??? développeurs

Français
========

* Antoine Pitrou : optimisation, Linux, réorganisation exceptions
* A de forge : Windows
* Florent flox ?
* Charles François Xavier : POSIX, threads/fork, fonctions atomiques
* Éric Araujo : Documentation, distutils
* Victor Stinner : Unicode
* Tarek Ziadé : distutils, packaging

Personnes
=========

* Guido van Rossum : solicitations occassionnelles, tranche si nécessaire, surtout sur le langage (auteur, 20 ans)
* Martin von Loewis : unicode, plateformes exotiques (xx ans)
* Georg.
* Raymond
* Marc Andre Lemburg
* Brett Canon
* Jess Noller
* Doug Hellman

Méritocratie
============

* N'importe qui peut contribuer, à son niveau
* Droit de commit en échange de patchs d'excellente qualité
* ça s'apprend

Code écrit en C
===============

* Refleak
* C : pas de liste, with, exception
* C : goto, API C de (CPython), macros (Py_RETURN_NONE)
* Portabilité : configure, #ifdef

Code écrit en Python
====================

* Portabilité
* Style code
* Subtilités quand un module est en partie écrit en C

Version de Python
=================

* Actif : 3.3
* Bugfix uniquement : 2.7, 3.2
* Sécurité uniquement : 2.5, 2.6, 3.1
* Branches mortes : Python < 2.5, Python 3.0

Canaux de communication
=======================

* Bugtracker
* Liste python-dev (xx courriels / jour)
* IRC #python-dev (peu actif)
* Liste python-commiters (xx courriels / jour)
* Liste python-checkins (xx courriels / jour)
* PEPs
* (python-ideas) (xx courriels / jour)

Nouvelle fonction
=================

* python-ideas et/ou python-dev
* PEP optionnelle
* Patch ou fork Mercurial (bitbucket)
* Bug tracker
* Nombreuses discussions
* Commit
* 1 semaine à 3 mois (parfois, plusieurs années)

Mort d'une mauvaise idée
========================

* Modification d'une fonction existante
* Transformée en documentation, ex: sys.platform.startswith('linux')
* Poubelle
* Généralement quelques semaines

Bugfix
======

* Rapport de bug
* Reproduction
* Isoler les versions affectées
* Isoler l'origine du bug
* Proposition de correctif
* Modification/réécriture du correctif
* Correctif appliqué à Python 2.7, 3.2 et 3.3
* 24h à quelque semaines (parfois, plusieurs années)

Calendrier
==========

* Release Schedule : PEP
* Release Manager : xxx pour 3.3
* ?? mois entre deux versions mineures (3.2.x)
* ?? mois entre deux versions majeures (3.x)
* Lenteur des releases => modules externes

Mercurial
=========

* Fonctionnalité : commit dans 3.3
* Bugfix : Commit dans 3.2, forward port dnas 3.3, commit dans 2.7

PEPs
====

* Nécessaire quand il n'y a pas de consensus
* Nécessaire pour l'évolution du langage : with, yield from, (switch)
* Détaille le problème solutionné par la PEP
* Liste les différentes propositions

Liste de discussion python-dev
==============================

* Paint my house
* Bikesheding

Autres implémentations
======================

* PyPy : Python 2.7. 3.x?
* IronPython : 2.6 ?
* Jython : 2.6 ?

Vie en dehors de CPython
========================

* Modules externes, centralisés sur le magasin fromage (pypi.python.org)

Comment contribuer à Python
===========================

* Devguide écrit par Brett Canon

