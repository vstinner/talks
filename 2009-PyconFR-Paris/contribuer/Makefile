SOURCES = $(wildcard *.tex)
TEX = contribuer.tex
DVI = contribuer.dvi
PDF = contribuer.pdf
PS  = contribuer.ps
TMPPDF = contribuer.pdf.tmp

all: slides

slides: $(SOURCES)
	latex $(TEX)
	latex $(TEX)
	latex $(TEX)
	dvipdf $(DVI) $(TMPPDF)
	mv $(TMPPDF) $(PDF)

handout: slides
	pdftops -paper A4 -expand $(PDF)
	psnup -4 -b2mm $(PS) > handouts.ps
	ps2pdf handouts.ps

clean:
	rm -f *.aux *.toc *.nav *.log *.snm *.vrb *.out $(DVI) $(TMPPDF)

