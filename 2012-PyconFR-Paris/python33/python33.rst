**********
Python 3.3
**********

yield from: PEP 380
-------------------

 * Meilleur performances ?
 * yield from permet d'envoyer et recevoir des valeurs

Langage
-------

 * Ajout de list.copy() et list.clear(), et pareil pour bytearray
 * u"hé hé" est à nouveau accepté dans Python 3.3


Suppresssin exception context: PEP 409
--------------------------------------

 * raise ValueError("oups!") from None

virtualenv: PEP 405
-------------------

 * pyvenv

Qualified name: PEP 3155
------------------------

 * MaClasse.methode.__name__ : "MaClasse.methode"
 * MaClasse.methode.__qualname__ : "MaClasse.methode"

Optimisations
-------------

 * PEP 393
 * Key-Sharing Dictionary: PEP 412

Namespace Packages: PEP 420
---------------------------

 * XXX

Unicode: PEP 393
----------------

 * Python 2.x : "abc" une chaîne d'octets, "abc" consomme 3 octets
 * Python 3.2 : "abc" est une chaîne de caractères, "abc" consomme 6 ou 12 octets
 * Python 3.3 : "abc" consomme 3 octets
 * Python 3.2 : "\U0010ffff"[0] donne '\udbff' (surrogate) sous Windows
 * Python < 3.3 : code complexe pour gérer les caractères non-BMP, problèmes
   avec le mode narrow
 * Python 3.3 : "\U0010ffff"[0] donne toujours "\U0010ffff"
 * Bonus : meilleures performances pour le texte ASCII

OSError simplifié (PEP 3151)
----------------------------

 * Avant : code non portable, except WindowsError ou except OSError
 * Avant : besoin d'importer errno et connaître les codes d'erreur
 * EACCESS ou EPERM ?
 * Maintenant : OSWindows (WindowsError et IOError sont des alias)

Avant::

    from errno import ENOENT, EACCES, EPERM

    try:
        with open("document.txt") as f:
            content = f.read()
    except IOError as err:
        if err.errno == ENOENT:
            print("document.txt file is missing")
        elif err.errno in (EACCES, EPERM):
            print("You are not allowed to read document.txt")
        else:
            raise

Maintenant::

    try:
        with open("document.txt") as f:
            content = f.read()
    except FileNotFoundError:
        print("document.txt file is missing")
    except PermissionError:
        print("You are not allowed to read document.txt")

New memoryview et buffer protocol (PEP 3118)
--------------------------------------------

 * Gestion explicite de la durée de vie d'un buffer qui évite de nombreux crashs
 * hash(buffer)
 * buffer[::-1]

Race conditions: open("x")
--------------------------

 * Opérations atomiques
 * Bugs et sécurité
 * open("nouveau.txt", "x") : erreur si le fichier existe déjà

Race conditions: CLOEXEC
------------------------

 * os.pipe2(), os.O_CLOEXEC
 * tempfile
 * xmlrpc.server.SimpleXMLRPCServer
 * subprocess: err pipe, close_fds, etc.

importlib
---------

 * Namespace?
 * Finer-Grained Import Lock

time: PEP 418
-------------

 * time.monotonic() : éviter les soucis de saut de temps (NTP)
 * time.perf_counter() : mesure de performance
 * time.process_time() : temps CPU, utile pour le profiling

Next
----

 * math.log2()
 * os.sendfile()
 * socket: sendmsg(), recvmsg(), recvmsg_into() => passer un (descripteur de)
   fichier à un autre processus
 * symlink vulnerability

   * "at": os.openat(), os.readlinkat(), ... => pathlib
   * os.fdlistdir()

 * os : extended attributes, ex: os.getxattr() => SE Linux

Thread + signal
---------------

 * signal.pthread_sigmask()
 * signal.pthread_kill()
 * signal.sigtimedwait()
 * multiprocessing; faulthandler: pthread_sigmask()
 * sys.thread_info
 * sys.thread_info(name='pthread', lock='semaphore', version='NPTL 2.10.2')

Securité
--------

 * crypt : support du sel
 * ssl: RAND_bytes(), RAND_pseudo_bytes(): PRNG cryptographiques

Misc
----

 * collections.ChainMap
 * module faulthandler

