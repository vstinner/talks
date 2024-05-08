# Status of the C API in Python 3.13

## New C API functions

42 new functions:

* ``PyDict_GetItemRef()``
* ``PyDict_GetItemStringRef()``
* ``PyDict_Pop()``
* ``PyDict_PopString()``
* ``PyDict_SetDefaultRef()``
* ``PyErr_FormatUnraisable()``
* ``PyImport_AddModuleRef()``
* ``PyList_Clear()``
* ``PyList_Extend()``
* ``PyLong_AsInt()``
* ``PyLong_AsNativeBytes()``
* ``PyLong_FromNativeBytes()``
* ``PyMapping_HasKeyStringWithError()``
* ``PyMapping_HasKeyWithError()``
* ``PyModule_Add()``
* ``PyObject_ClearManagedDict()``
* ``PyObject_GenericHash()``
* ``PyObject_GetOptionalAttr()``
* ``PyObject_GetOptionalAttrString()``
* ``PyObject_HasAttrStringWithError()``
* ``PyObject_HasAttrWithError()``
* ``PyObject_VisitManagedDict()``
* ``PyRefTracer_GetTracer()``
* ``PyRefTracer_SetTracer()``
* ``PySys_AuditTuple()``
* ``PyThreadState_GetUnchecked()``
* ``PyTime_AsSecondsDouble()``
* ``PyTime_Monotonic()``
* ``PyTime_MonotonicRaw()``
* ``PyTime_PerfCounter()``
* ``PyTime_PerfCounterRaw()``
* ``PyTime_Time()``
* ``PyTime_TimeRaw()``
* ``PyType_GetFullyQualifiedName()``
* ``PyType_GetModuleName()``
* ``PyUnicode_EqualToUTF8()``
* ``PyUnicode_EqualToUTF8AndSize()``
* ``PyWeakref_GetRef()``
* ``Py_GetConstant()``
* ``Py_GetConstantBorrowed()``
* ``Py_HashPointer()``
* ``Py_IsFinalizing()``

Add to the limited C API:

* ``PySys_Audit()``
* ``PyMem_RawCalloc()``
* ``PyMem_RawFree()``
* ``PyMem_RawMalloc()``
* ``PyMem_RawRealloc()``
* ``Py_GetConstant()``
* ``Py_GetConstantBorrowed()``

"Ref" functions to avoid borrowed references: PEP 703 "Free Threading" needs
``PyDict_GetItemRef()``, ``PyDict_SetDefaultRef()`` and ``PyWeakref_GetRef()``.

## Guidelines for new functions

* Don't return borrowed references. Exception: ``Py_GetConstantBorrowed()``
  for backward compatibility.
* Return -1 on error. Return 0 on success. Optional: return 1 if found.
  Example: `PyDict_GetItemRef()`.

## Performance

* Abstraction should not come with a major performance overhead.

## Argument Clinic

Support targetting the limited C API:

* Use functions of the limited C API
* or: inline code to avoid calling private/internal function

## C API consumers

* Cython
* cffi: C
* PyO3: Rust
* pybind11 and nanobind: C++

Limited C API:

* nanobind: 100% feature coverage on Python 3.12.
* Cython: opt-in build mode
* PyO3: opt-in build mode

## Stable ABI in Python 3.13

* Singletons (ex: `Py_None`) reimplemented as
  `Py_GetConstant()` calls to avoid accessing private names
  (ex: `&_Py_NoneStruct`)

## Build stdlib ext with limited C API

16 extensions:

* _ctypes_test
* _multiprocessing.posixshmem
* _scproxy
* _stat
* _statistics
* _testconsole
* _testimportmultiple
* _uuid
* errno
* fcntl
* grp
* md5
* pwd
* resource
* termios
* winsound

Limited C API:

* Add new functions such as `PyLong_AsInt()`
* `PyMem_RawMalloc()`
* PEP 737: "%T" format: fully qualified name of an object type

## Private functions

* Third party projects can use private functions.
* Consequence: they use private functions.
* Problem? No backward compatibility, no tests, no doc.
* Solution? Convert private functions to public functions.
* Python 3.12 exports 389 private functions.
* Python 3.13 exports 125 private functions (-264).

Exception:

* Public macros / static inline functions calling private functions are ok.
* Example: `Py_DECREF()` calls `_Py_Dealloc()` which is part of the stable ABI
  ("ABI only" function).

## Add `_testlimitedcapi`

Split C API tests: add `_testlimitedcapi` built with the limited C API.

## Limited C API in Python 3.13

* Debug build `Py_TRACE_REFS` is now compatible with the limited C API
  (ABI compatibility)
* Argument Clinic supports the limited C API.
* PEP 737: API to format a type name (fully qualified name).
* Build 16 extensions with the limited C API.
* Split C API tests: add `_testlimitedcapi`

## TODO

* PEP 741 "Python Configuration C API".
* PEP 703 "Free Threading": add support for the limited C API somehow.
* Cython: enhance limited C API support.
* Enhance abi3audit tool which emits false alarms.
  https://github.com/trailofbits/abi3audit
* PyO3: use the limited C API by default.
  https://github.com/trailofbits/abi3audit
* API for PyFrameObject for Cython, greenlet, gevent and eventlet.
* API for PyThreadState for Cython.
* Design a migration path away from PyTypeObject members direct access.
