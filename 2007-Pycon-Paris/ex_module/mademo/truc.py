def somme(x, y):
    """
    Calcule la somme de x et y.

    >>> somme(1, 2)
    Appelle somme(1, 2)
    3
    >>> somme("Hello ", "World!")
    Appelle somme('Hello ', 'World!')
    'Hello World!'
    """
    print "Appelle somme(%r, %r)" % (x, y)
    return x+y

if __name__ == "__main__":
    import doctest
    print "Test le module"
    doctest.testmod()

