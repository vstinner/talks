Syntaxe concise
===============

* 1 < x <= 10
* 0 <= x < y <= 20
* a, b = b, a + b # Fibonacci
* color = "red" if load > 0.8 else "green"

Slices
======

::

    >>> carres = [1, 4, 9, 16, 25]
    >>> carres[1:-1]
    [4, 9, 16]
    >>> carres[::2]
    [1, 9, 25]
    >>> carres[::-1]
    [25, 16, 9, 4, 1]

Itérateurs
==========

 * str, unicode, list, tuple, dict, set, <fichier>, ...
 * dict.iterkeys(), dict.itervalues(), dict.iteritems()
 * iter(object) ou "for element in object: ..."
 * Votre objet : méthode __iter__()

Opérations sur les itérateurs
=============================

::

    >>> list(enumerate("abc"))
    [(0, 'a'), (1, 'b'), (2, 'c')]
    >>> list(zip("abc", "XYZ"))
    [('a', 'X'), ('b', 'Y'), ('c', 'Z')]
    >>> gen = itertools.count()
    >>> gen.next(), gen.next(), gen.next()
    (0, 1, 2)

Générateurs (1)
===============

 * imap(operator.itemgetter(1), items)
 * (item[0] for item in items)
 * imap(operator.attrgetter("name"), items)
 * (item.name for item in items)

Générateurs (2)
===============

 * Rapide
 * Générique
 * Suite infinie
 * Algorithme simple

with (avant)
============

::

    f = open('foo.txt', 'w')
    # f n'est pas fermé directement si write déclanche une IOError
    f.write('hello!')
    f.close()

with (après)
============

::

    # Python 2.5
    from __future__ import with_statement
    with open('foo.txt', 'w') as f:
        f.write('hello!')

Fichier, verrou, vos propres objets, etc.

Introspection
=============

::

    >>> help(round)
    round(...)
        round(number[, ndigits]) -> floating point number

        Round a number to a given precision in decimal digits (default 0 digits).
        This always returns a floating point number.  Precision may be negative.

    >>> dir(MaClasse)
    ['__doc__', '__module__', 'f', 'name']
    >>> getattr(MaClasse, 'name')
    'MaClasse'
    >>> hasattr(A, 'xxx')
    False
    >>> type(), isinstance(), issubclass()

 * pydoc math.floor
 * http://docs.python.org/


Décorateur
==========

 * @classmethod
 * @staticmethod
 * @property

Décorateur
==========

::

    def deprecated(comment=None):
        def _deprecated(func):
            def newFunc(*args, **kwargs):
                message = "Call to deprecated function %s" % func.__name__
                if comment:
                    message += ": " + comment
                warn(message, category=DeprecationWarning, stacklevel=2)
                return func(*args, **kwargs)
            newFunc.__name__ = func.__name__
            newFunc.__doc__ = func.__doc__
            newFunc.__dict__.update(func.__dict__)
            return newFunc
        return _deprecated

Décorateur
==========

::

    @deprecated
    def initialize_random():
        ...

    @deprecated("Use TimedeltaWin64 field type")
    def durationWin64(field):
        ...

set
===

::

    >>> "a" in set("abc")
    True
    >>> set("abc") | set("ad")
    set(['a', 'c', 'b', 'd'])
    >>> set("abc") - set("ad")
    set(['c', 'b'])

Chaînes brutes (raw)
====================

::

    >>> len("\n", len(r"\n")
    (1, 2)
    >>> print """Sans anti-slash : 'a', "b"."""
    Sans anti-slash : 'a', "b".

Modules standards
=================

 * datetime : date et heure
 * logging : loguer du texte
 * optparse : arguments sur la ligne de commande
 * pprint.pprint() : **pretty print**

Modules externes
================

 * BeautilfulSoup : parser du HTML non conforme
 * PIL : Python Imaging Library:

Autres
======

::

    >>> 'Zrffntr frperg!'.decode('rot13')
    u'Message secret!'

 * re.compile("^ M{0,4} (CM|CD|D?C{0,3}) $", re.VERBOSE)
 * encodage/décodage unicode
 * doctest
 * from __future__ import braces
 * from __future__ import this


Sources
=======

 * http://stackoverflow.com/questions/101268
 * http://python.net/~goodger/projects/pycon/2007/idiomatic/handout.html
 * Trucs et astuces, Victor Stinner, Hors Série Linux Magazine n°40 (janvier/février 2009)

Sources TODO
============

 * rabbits : http://www.flickr.com/photos/chris-parry/3007001331/
 * défilé : http://www.flickr.com/photos/danhiel/1395670700/
 * http://bigpointyteeth.files.wordpress.com/2009/03/monty-python-foot.jpg
 * http://upload.wikimedia.org/wikipedia/en/9/90/Chapman_as_Brian.jpg
 * http://beeroverip.org/monty-python-holy-ail/

