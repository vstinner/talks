/**
 * Atelier securité Lolut
 * Session 01 - Langage C et retro-ingénierie
 * 6 octobre 2005 par Victor Stinner
 * 
 * Exemple 5 : L'intérêt de factoriser son code. 
 * 
 * Le code est plus compact, et si une fonction est corrigée, tout le
 * programme en profite.
 *
 * Toujours imaginer le pire des cas, et ne jamais faire confiance
 * à ce qui vient de l'extérieur (n'est pas connu à l'avance).
 */

#include <stdio.h>
#include <string.h>
#include <stdlib.h>

// Replace "\n" by "\0" at the end of a string
void trim(char *str)
{
    size_t len;
    if (str == NULL) return;
    len = strlen(str);
    if (len == 0) return;
    if (str[len-1] != '\n') return;
    str[len-1] = '\0';
}

// Read one line from stdin, and then call trim
// Returns 0 if fails, 1 else
int readline(char *str, int size)
{
    if (str == NULL) return 0;
    char *err = fgets(str, size, stdin);
    if (err == NULL) return 0;
    trim(str);
    return 1;
}

// Convert a string to a long value
// Returns 0 if fails, 1 else
int str2long(char *str, long *value)
{
    char *err;
    if ((str == NULL) || (value == NULL)) return 0;
    *value = strtol(str, &err, 10);
    if ((err == str) || (err != NULL && *err != '\0')) return 0;
    return 1;
}

// Our Hello World
int hello(void)
{
#define SIZE 10
    char name[SIZE], str_age[SIZE];
    long age;
    
    // Ask age
    printf("Enter your age: ");
    if (readline(str_age, SIZE) == 0) return 0;
    if (str2long(str_age, &age) == 0) return 0; 

    // Ask name
    printf("Enter your name: ");
    if (readline(name, SIZE) == 0) return 0;

    // Display result
    printf("Hello %s, you're %li years old!\n", name, age);
    return 1;
}

int main(void)
{
    if (hello() == 0) printf ("\nError ...\n");
    return 0;
}    
