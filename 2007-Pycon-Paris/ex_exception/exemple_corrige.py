from sys import exit

def main():
    try:
        tampon = raw_input("Entrez votre nom : ")
    except EOFError:
        exit(0)

    try:
        if tampon[len(tampon)-1] == '\n':
            tampon = tampon[:len(tampon)-1]
    except IndexError:
        pass

    print "Bonjour %s !" % tampon
    exit(0)

if __name__ == "__main__":
    main()

