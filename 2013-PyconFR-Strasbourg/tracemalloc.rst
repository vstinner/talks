Titre

* Traquer les fuites mémoire en Python
* Pycon FR 2013, Strasbourg
* Victor Stinner - victor.stinner@gmail.com

Moi

* Core developer Python depuis 2010
* github.com/haypo
* bitbucket.org/haypo
* Enovance

Consommation globale du processus (RSS)

* Représentatif pour le système
* Mesure grossière
* Difficile à exploiter pour identifier une fuite mémoire
* Fragmentation du tas

memory_profiler (RSS + trace)::

    Mem usage  Increment  Line Contents
    =====================================
                          @profile
      5.97 MB    0.00 MB  def my_func():
     13.61 MB    7.64 MB      a = [1] * (10 ** 6)
    166.20 MB  152.59 MB      b = [2] * (2 * 10 ** 7)
     13.61 MB -152.59 MB      del b
     13.61 MB    0.00 MB      return a

    https://pypi.python.org/pypi/memory_profiler

Comprendre les cycles de référence::

    a.b = b
    b.a = a

=> b.a = weakref.ref(a)

Comprendre les cycles de référence::

    a.b = b
    b.c = c
    ...
    y.z = z
    z.a = a

=> z.a = weakref.ref(a)

Générer une image représentant les liens entre les objets

* obgraph:

.. image:: objgraph.png

* http://mg.pov.lt/objgraph/
* Visualisation des liens entre objets

Introspection Python:

* gc.get_objects()
* gc.get_referrers()
* gc.get_referents()
* id(obj)
* sys.getsizeof(obj)

Utilisation de gc.get_objects() et calcul manuel de la taille des objets::

    >>> import gc, sys
    >>> obj = {None: b'x' * 10000}
    >>> sys.getsizeof(obj)
    296
    >>> sum(sys.getsizeof(ref) for ref in gc.get_referents(obj))
    10049

Utilisation de gc.get_objects() et calcul manuel de la taille des objets::

    >>> data = b'x' * 10000
    >>> obj = {index:data for index in range(500)}
    >>> sum(sys.getsizeof(ref) for ref in gc.get_referents(obj))
    5030496
    >>> refs = set(map(id, gc.get_referents(obj)))
    >>> sum(sys.getsizeof(ref) for ref in refs)
    16028

Melia, Heapy, Pympler::

    Total 17916 objects, 96 types, Total size = 1.5MiB (1539583 bytes)
    Count   Size  Kind
     701  546460  dict
    7138  414639  str
     208   94016  type
    1371   93228  code
    ...

Melia, Heapy, Pympler:

* Ne trace pas toute la mémoire (ex: zlib)
* Ne donne pas l'origine des objects
* Difficile à exploiter

PEP 445: Fonctions pour personnaliser malloc()

* PyMem_GetAllocator()
* PyMem_SetAllocator()
* Accepté et implementé dans Python 3.4

PEP 445: Exemple de wrapper::

    static void* malloc_wrapper(void *ctx, size_t size)
    {
        PyMemAllocator *alloc = (PyMemAllocator *)ctx;
        void *ptr;
        /* ... */
        ptr = alloc->malloc(alloc->ctx, size);
        /* ... */
        return ptr;
    }

Tracer les allocations mémoires à leur création::

    Memory block 0x1725cd0: 768 kB
      File "test/support/__init__.py", line 142
      File "test/support/__init__.py", line 206
      File "test/test_decimal.py", line 48
      File "importlib/__init__.py", line 95
      File "test/regrtest.py", line 1269

Tracer les allocations mémoires à leur création::

    Memory block 0x1725cd0: 768 kB
      File "test/support/__init__.py", line 142
        __import__(name)
      File "test/support/__init__.py", line 206
        _save_and_remove_module(name)
      File "test/test_decimal.py", line 48
        C = import_fresh_module('decimal')
      File "importlib/__init__.py", line 95
        return _bootstrap._gcd_import(name)
      File "test/regrtest.py", line 1269
        the_module = importlib.import_module(abstest)

Top 10 par ligne::

    Lib/linecache.py:127: 616.5 KB
    Lib/collections/__init__.py:368: 234.8 KB
    Lib/unittest/case.py:571: 199.5 KB
    Lib/test/test_grammar.py:132: 199.0 KB
    Lib/abc.py:133: 75.1 KB

Comparer deux snapshots::

    [ Top 10 differences ]
    test.py:4: 0.0 kB (-5.0 kB)
    test.py:8: 0.6 kB (+0.6 kB)

Status pytracemalloc (sur PyPI)

* https://pypi.python.org/pypi/pytracemalloc
* Nécessite de patcher et recompiler Python
* ... voir aussi recompiler les extensions Python
* Patchs pour Python 2.5, 2.7, 3.4

Status tracemalloc (Python 3.4)

* PEP 445 (API malloc): implémentée dans Python 3.4
* PEP 454 (tracemalloc): brouillon
* Portable ! Windows, Linux, FreeBSD, etc.
* Mémoire x 2
* 2x plus lent
* Pérène : va être intégré à Python 3.4

Suite ?

* Euh, faire accepter la PEP 454 (tracemalloc)
* Mettre à jour les projets PyPI
* Jolis graphiques
* GUI pour naviguer dans les données
* GUI pour suivre l'évolution

