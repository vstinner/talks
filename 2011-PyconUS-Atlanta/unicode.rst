Status of Unicode in Python 3
=============================

 * Victor Stinner
 * Pycon US 2011, Atlanta

.. duration: 30 min

----

Status of Unicode in Python 3
=============================

 * Victor Stinner
 * Python core developer
 * Hacking Unicode since 2 years

----

Unicode errors
==============

::

    Traceback (most recent call last):
      File "<stdin>", line 1, in <module>
    UnicodeEncodeError: 'ascii' codec can't encode character
    '\xe9' in position 3: ordinal not in range(128)


----

Python 2 history
================

 * 2.0: unicode, unicodedata
 * 2.2: str.decode(), unicode.encode(), __unicode__()
 * 2.3: PEP 263: "#coding:xxx" cookie
 * 2.3: PEP 277: Unicode filenames on Windows
 * 2.3: open(), os.listdir()

----

Python 2: modules
=================

 * 2.3: socket, array
 * 2.5: fileinput
 * 2.6: tarfile, zipfile, glob, msvcrt
 * 2.7: email, decimal, os.path

----

3.0: Unicode by default
=======================

 * 'abc' is Unicode, unicode → str, str → bytes
 * Source code encoding: UTF-8
 * Unicode for filenames, os.environ, sys.argv
 * os.listdir(bytes)
 * 8 years after 2.0

----

3.1: PEP 383
============

 * PEP 383: surrogateescape; undecodable byte sequences
 * PyUnicode_FSConverter(): str→bytes
 * os: environ, listdir(), getcwd()
 * sys.argv
 * grp, pwd, spwd modules

----

Surrogates... WTF?
==================

 * USB key: latin1
 * 'abcé'.encode('latin1'): b'abc\\xE9'
 * Locale encoding: UTF-8
 * b'abc\\xE9'.decode('UTF-8'): UnicodeDecodeError!

----

Surrogates... WTF?
==================

 * b'abc\\xE9'.decode('UTF-8', 'surrogateescape'): 'abc\\uDCE9'
 * 'abc\\uDCE9'.encode('UTF-8', 'surrogateescape'): b'abc\\xE9'
 * 0x80-0xFF ⇔ U+DC80-U+DCFF

----


3.1 issues
==========

 * Unicode strings but don't support undecodable byte strings
 * Wrong encoding for some OS data
 * Only work correctly with UTF-8 locale encoding
 * ... Windows uses the ANSI code page

----

Migration to Unicode step-by-step
=================================

 * 2.0: bytes only, no Unicode support
 * 2.2: unicode→bytes, only locale encoding
 * 3.0: bytes→str, undecodable byte sequences
 * 3.2: bytes→str + surrogateescape, no more byte issues

----

3.2: New API for surrogateescape
================================

 * PyUnicode_FSDecoder(): bytes→str
 * PyUnicode_EncodeFSDefault(): str→bytes
 * os.fsdecode(), os.fsencode()
 * Unicode filenames, even on UNIX

----

3.2: Use surrogateescape everywhere
===================================

 * os, subprocess, platform, imp, zipimport, email, cgi
 * ftp, nntplib, ctypes, bz2, ssl, profile
 * libpython (gdb), sqlite, distutils
 * locale, warnings, tarfile, pickle, pickletools
 * traceback, nis, tkinter, xmlrpclib

----

3.2: Import machinery (part 1)
==============================

 * Import machinery still works on byte filenames
 * ... but use surrogateescape to handle undecodable byte sequences
 * Huge patch
 * zipimport, NullImporter
 * Import machinery: lot of ugly code

----

3.2: Command line arguments
===========================

 * Unicode on Windows
 * locale encoding on UNIX/BSD
 * UTF-8 on OS X
 * Bootstrap issues

----

3.2: FS encoding bootstrap issue
================================

 * ASCII → locale encoding
 * codecs+encodings ⇔ import machinery
 * PYTHONFSENCODING and sys.setfilesystemencoding() inconsistencies
 * Redecode hack

----

3.2: Redecode hack
==================

 * Decode all filenames from UTF-8
 * Get the FS encoding, load the Python codec
 * Encode all filenames to UTF-8
 * (Re)decode all filenames from the FS encoding
 * Exhaustive list of all objects with filename/path attributes

----

3.2: Fix FS encoding bootstrap issue
====================================

 * Remove sys.setfilesystemencoding()
 * Remove PYTHONFSENCODING
 * initfsencoding()
 * _Py_char2wchar(), _Py_wchar2char()
 * Remove redecode hack

----

3.2: UTF-8 on OS X bootstrap issue
==================================

 * UTF-8 on OS X for the command line
 * UTF-8 + surrogateescape
 * PyCodec_LookupError() requires the GIL
 * _Py_DecodeUTF8_surrogateescape()

----

3.2: os.environb
================

 * os.environb
 * os.getenvb()

----

3.2: non-BMP characters
=======================

 * U+10000-U+10FFFF range
 * 16/32 bits wchar_t/Py_UNICODE
 * UTF-16 ⇔ UTF-32 (UCS4)

----

3.2: non-BMP characters
=======================

 * PyUnicode_AsWideCharString()
 * Py_UNICODE → Py_UCS4 on character functions
 * PyUnicode_FromFormat("%c") on narrow build

----

3.2: source code encoding
=========================

 * tokenize.detect_encoding()
 * 3.0: py_compile
 * 3.1: linecache
 * 3.1: tabnanny
 * 3.2: untabify script
 * tokenize.open(): only open the file once

----

Programming with Unicode book
=============================

 * github.com/haypo/unicode_book
 * CC BY-SA license
 * Encodings, operating systems, programming languages, libraries
 * Good practices, Unicode issues

----

Problems to hack Unicode
========================

 * Lack of encoding documentation
 * Difficult to get a review
 * Ugly code with a long history: import machinery, getpath.c
 * Document encodings of all char* arguments

----

3.2: strict mbcs codec
======================

 * Windows ANSI code page
 * mbcs codec ignored errors argument
 * Now strict by default
 * 'ignore' to decode, 'replace' to encode

----

3.2: fileutils.c
================

 * Py_UNICODE*
 * _Py_char2wchar(), _Py_wchar2char()
 * _Py_stat(), _Py_wstat()
 * _Py_fopen(), _Py_wfopen()
 * _Py_wreadlink(), _Py_wrealpath(), _Py_wgetcwd()

----

3.2: new C functions
====================

 * strdup(): PyUnicode_AsUnicodeCopy()
 * strrchr(): Py_UNICODE_strrchr()
 * strncmp(): Py_UNICODE_strncmp()
 * strcat(): Py_UNICODE_strcat()

----

3.2: new C functions
====================

 * PyErr_WarnFormat()
 * PySys_FormatStderr() for verbose mode

----

3.3: Import machinery (part 2)
==============================

 * Use Unicode strings for module paths and names
 * Decode earlier, encode later

----

Questions?
==========

 * Bye bye Unicode errors!
 * github.com/haypo/unicode_book

