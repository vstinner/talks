#008: Traquer les fuites mémoire en Python (Victor Stinner, Track: )

    Proposal Details
    Supporting Documents
    Reviewer Feedback 0

Submitted by
    Victor Stinner
Track

Audience Level
    Intermediate
Description

    Les fuites mémoire en Python ne peuvent pas être analysées avec les outils
    traditionnels car Python repose sur les compteurs de référence. Je vais
    présenter des outils spécifiques à Python pour vous aider à localiser vos
    fuites mémoires.

Abstract

        Consommation globale du processus (mémoire RSS)
        Comprendre les cycles de référence
        Générer une image représentant les liens entre les objets
        Utilisation de gc.get_objects() et calcul manuel de la taille des objets
        Tracer les allocations mémoires à leur création
        PEP 445: Add new APIs to customize Python memory allocators implementée dans Python 3.4
        Projet pytracemalloc


Notes

Speaker Bio

    Core developer Python depuis 2010, je suis l'auteur de nombreuses
    applications et bibliothèques Python. Voir mes projets Bitbucket et mes
    projets Github.

Documents
    No supporting documents attached to this proposal.

