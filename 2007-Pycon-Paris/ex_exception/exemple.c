#include <stdlib.h>
#include <stdio.h>
#include <string.h>

#define TAILLE 10

int main()
{
    char *tampon;
    size_t len;

    tampon = (char *)malloc(TAILLE);

    printf("Entrez votre nom : ");
    fflush(stdout);
    fgets(tampon, TAILLE, stdin);

    len = strlen(tampon);
    if (tampon[len-1] == '\n') {
        tampon[len-1] = '\0';
    }

    printf("Bonjour %s !\n", tampon);
    exit(EXIT_SUCCESS);
}
