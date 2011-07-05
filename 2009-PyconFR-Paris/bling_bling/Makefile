SOURCES = $(wildcard *.tex)
TEX = bling_bling.tex
DVI = bling_bling.dvi
PDF = bling_bling.pdf
PS  = bling_bling.ps
TMPPDF = bling_bling.pdf.tmp

all: slides

slides: $(SOURCES)
	latex $(TEX)
	latex $(TEX)
	latex $(TEX)
	dvipdf $(DVI) $(TMPPDF)
	mv $(TMPPDF) $(PDF)

clean:
	rm -f *.aux *.toc *.nav *.log *.snm *.vrb *.out $(DVI) $(TMPPDF)

