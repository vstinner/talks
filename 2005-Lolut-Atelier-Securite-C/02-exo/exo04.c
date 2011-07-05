/**
 * Atelier securité Lolut
 * Session 01 - Langage C et retro-ingénierie
 * 6 octobre 2005 par Victor Stinner
 * 
 * Recherchez la/les faille(s) ... 
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>

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
// Add \n to string if needed
// Returns 0 if fails, 1 else
int readline(char *str, int size)
{
    size_t len;
    if (str == NULL) return 0;
    char *err = fgets(str, size-1, stdin);
    if (err == NULL) return 0;
    trim(str);
    len = strlen(str);
    str[len] = '\n';
    str[len+1] = '\0';
    return 1;
}

// Write a string into a file
// Flush the file to prevent crash
void writeString(FILE *f, char *buffer)
{
    fwrite(buffer, sizeof(buffer[0]), strlen(buffer), f);
    fflush(f);
}    

void process(FILE *f)
{
    char buffer[100];
    
    printf("Name? "); if (!readline(buffer, sizeof(buffer))) return;
    writeString(f, buffer);

    printf("Password? "); if (!readline(buffer, sizeof(buffer))) return;
    writeString(f, buffer);
    
    printf("Email? "); if (!readline(buffer, sizeof(buffer))) return;
    writeString(f, buffer);
}

int main(int argc, char **argv)
{
    // Open file
    const char *filename = "private";
    FILE *f;
    f = fopen(filename, "w");
    if (f == NULL)
    {
        fprintf(stderr, "Fail to open %s\n", filename);
        exit(EXIT_FAILURE);
    }

    // Read data and write them in the file
    process(f);
    fclose(f);

    // Set file permissions (to forbid *anyone* to read it :-))
    chmod("private", 0000);
    exit(EXIT_SUCCESS);
}
