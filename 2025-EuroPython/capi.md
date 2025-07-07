# Deprecate the private API and add public functions to replace them

## Problem

* Cython, greenlet, numpy frequently need changes when the C API changes
* C API exposes implementation details, structure members
* Borrowed references

## Removal of private functions

* 264 private functions removed in Python 3.13
* 50 functions reverted in alpha2 since used by many projects
* Promote private functions as public functions

## Promotions 3.13

* `PyTime` API. "Raw" functions to get time without exceptions (no GIL needed).
* `PyDict_Pop()` (better API), `PyDict_ContainsString()`
* `PyList_Extend/Clear()`
* `PyLong_AsInt()`
* `PyLong_As/FromNativeBytes()`
* `Py_HashPointer()`
* `PyThreadState_GetUnchecked()`

## Strong references

* Motivation: Free Threading
* `PyDict_GetItemRef()`, `PyList_GetItemRef()`
* `PyDict_SetDefaultRef()`
* `PyImport_AddModuleRef()`
* `PyWeakref_GetRef()` -- deprecate `PyWeakref_GetObject()`

## Misc 3.13

* `Py_GetConstant()`
* `PyImport_ImportModuleAttr()`

## Deprecate 3.14 private functions

* `_PyBytes_Join()`: use `PyBytes_Join()`
* `_PyDict_GetItemStringWithError()`: use `PyDict_GetItemStringRef()`
* `_PyDict_Pop()`: `PyDict_Pop()`
* `_PyLong_Sign()`: use `PyLong_GetSign()`
* `_PyLong_FromDigits()` and `_PyLong_New()`: use `PyLongWriter_Create()`
* `_PyThreadState_UncheckedGet()`: `use PyThreadState_GetUnchecked()`
* `_PyUnicode_AsString()`: use `PyUnicode_AsUTF8()`
* `_PyUnicodeWriter_Init()`: use `PyUnicodeWriter_Create()`
* `_Py_HashPointer()`: use `Py_HashPointer()`.
* `_Py_fopen_obj()`: use `Py_fopen()`.
* Removal in Python 3.18 (deprecated for 3 releases).
