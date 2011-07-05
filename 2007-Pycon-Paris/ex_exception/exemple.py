from sys import exit

def main():
    tampon = raw_input("Entrez votre nom : ")

    if tampon[len(tampon)-1] == '\n':
        tampon = tampon[:len(tampon)-1]

    print "Bonjour %s !" % tampon
    exit(0)

if __name__ == "__main__":
    main()

