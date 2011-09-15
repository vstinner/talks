++++++++++++++++++++++++
Développement de CPython
++++++++++++++++++++++++

 * Vu par un core developer
 * Pycon FR 2011, Rennes

CPython
=======

* Interprète
* Bibliothèque standard : 183 modules
* Documentation: 182 000 lignes de reST
* 1 million de ligne de code :
* 60% (630k) de Python, 40% (410k) de C

Personnes
=========

 * Misc/ACKS : 1046 contributeurs
 * Doc/ACKS : 224 contributeurs
 * Core : 157 développeurs dont 7 français
 * 61 core developers actifs (au moins 1 commit depuis 1 an)
 * sur 12 fuseaux horaires (UTC: -08, -07, -06, -05, -04, +00, +01, +02, +03, +08, +10, +11)

Canaux de communication
=======================

 * Tout est public
 * Bugtracker
 * Liste python-dev (30 courriels / jour)
 * IRC #python-dev (peu actif)
 * Liste python-commiters (xx courriels / jour)
 * Liste python-ideas (5 courriels / jour)

Méritocratie
============

* N'importe qui peut contribuer, à son niveau
* Droit de commit en échange de patchs d'excellente qualité
* Ça s'apprend (parainage, devguide)

Versions de Python
==================

* Active : 3.3
* Correctifs uniquement : 2.7, 3.2
* Sécurité uniquement : 2.5, 2.6, 3.1

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
* Propositions de correctif
* Amélioration/réécriture du correctif
* Correctif appliqué à Python 2.7, 3.2 et 3.3
* 24h à quelque semaines (parfois, plusieurs années)

Commit
======

 * Code relu par plusieurs pairs
 * Ajout de nouveaux tests
 * Documentation mise à jour
 * Entrée Misc/NEWS
 * Toute la suite de test passe
 * Buildbots verts

Anciens bugs
============

 * Besoin pas clairement exprimé
 * Intérêt limité
 * Concerne peu de monde
 * Pas de développeur compétent
 * Complexe à implémenter
 * Implémentation proposée trop crade

Suite de tests
==============

 * 10.000 tests
 * 595 fichiers
 * 203.000 lignes de Python

Buildbot
========

* 70 buildbots
* 2.7, 3.2, 3.3
* Windows (XP, 2008R2, Seven)
* Linux (Ubuntu, Debian, Gentoo)
* FreeBSD 6, 7, 8
* Solaris, OpenIndiana

Qualité
=======

 * Code portable
 * Buildbots
 * Revue de code : patchs sur le backtracker
 * Outil : Rietveld
 * Liste python-checkins (xx courriels / jour)

PEPs
====

* Nécessaire quand il n'y a pas de consensus
* Nécessaire pour l'évolution du langage : with, yield from, (switch)
* Détaille le problème solutionné par la PEP
* Liste les différentes propositions

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

Pour finir
==========

 * Developer Guide écrit par Brett Canon : http://docs.python.org/devguide/
 * Vie en dehors de CPython : http://pypi.python.org/ (Cheeseshop)
 * Python 3.3 prévu pour août 2012 (PEP 398)
 * http://www.python.org/
 * http://www.python.org/dev/

Exemple de code C
=================

::

    int
    PyList_SetItem(PyObject *op, register Py_ssize_t i,
                   PyObject *newitem)
    {
        PyObject *olditem, **p;
        if (!PyList_Check(op)) {
            Py_XDECREF(newitem);
            PyErr_BadInternalCall();
            return -1;
        }
        if (i < 0 || i >= Py_SIZE(op)) {
            Py_XDECREF(newitem);
            PyErr_SetString(PyExc_IndexError,
                            "list assignment index out of range");
            return -1;
        }
        p = ((PyListObject *)op) -> ob_item + i;
        olditem = *p;
        *p = newitem;
        Py_XDECREF(olditem);
        return 0;
    }

Statistiques
============

 * Période du 1er sept 2010 au 11 sept 2011

