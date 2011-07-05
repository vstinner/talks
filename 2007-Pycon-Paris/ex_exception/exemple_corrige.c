#include <stdlib.h>
#include <stdio.h>
#include <string.h>

#define TAILLE 10

int main()
{
    char *tampon, *ok;
    size_t len;

    tampon = (char *)malloc(TAILLE);
    if (!tampon) {
        fprintf(stderr, "Impossible d'allouer le tampon !\n");
        exit(EXIT_FAILURE);
    }

    printf("Entrez votre nom : ");
    fflush(stdout);

    ok = fgets(tampon, TAILLE, stdin);
    if (!ok) {
        free(tampon);
        fprintf(stderr, "Erreur lors de la lecture du nom !\n");
        exit(EXIT_FAILURE);
    }

    len = strlen(tampon);
    if (1 <= len && tampon[len-1] == '\n') {
        tampon[len-1] = '\0';
    }

    printf("Bonjour %s !\n", tampon);
    free(tampon);
    exit(EXIT_SUCCESS);
}
