#include <stdio.h>
#include <stdlib.h>
#include <string.h>

void read_name(const char* filename)
{
    FILE* file;
    unsigned int size;
    char *name;

    file = fopen(filename, "r");
    if (file) {
        fread(&size, sizeof(size), 1, file);
        name = (char*)malloc(size + 1);
        fread(name, size, 1, file);
        name[size] = 0;
        fclose(file);

        printf("previous name: (%u bytes) \"%s\".\n", size, name);
        free(name);
    } else {
        printf("(no previous run)\n");
    }
}

void write_name(const char* filename)
{
    FILE* file;
    char name[100];
    unsigned int size;
    char *ret;

    printf("enter your name: ");
    fflush(stdout);
    ret = fgets(name, sizeof(name), stdin);
    if (ret == NULL)
        return;

    file = fopen(filename, "w");
    if (!file) {
        perror("unable to create the file");
        exit(1);
    }

    size = strlen(name);
    if (size && name[size-1] == '\n') {
        size--;
        name[size] = '\0';
    }
    printf("name >%s< (size=%u)\n", name, size);

    fwrite(&size, sizeof(size), 1, file);
    fwrite(name, size, 1, file);
    fclose(file);

    printf("Write name to %s\n", filename);
}

int main()
{
    char* home;
    char filename[512];

    home = getenv("HOME");
    if (!home) {
        fprintf(stderr, "Missing HOME env var!\n");
        exit(1);
    }

    strcpy(filename, home);
    strcat(filename, "/");
    strcat(filename, ".bug");

    read_name(filename);
    write_name(filename);

    exit(0);
}

