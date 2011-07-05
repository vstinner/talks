SOURCES = $(wildcard *.tex)
PICTURES = Montparnasse.eps
TEX = fosdem.tex
DVI = fosdem.dvi
PDF = fosdem_2009.pdf
PS  = fosdem.ps
TMPPDF = fosdem.pdf

all: slides

slides: $(SOURCES)
	latex $(TEX)
	latex $(TEX)
	latex $(TEX)
	dvipdf $(DVI) $(TMPPDF)
	mv $(TMPPDF) $(PDF)

Montparnasse.eps: Montparnasse.jpg
	jpeg2ps $< $@

handout: slides
	pdftops -paper A4 -expand $(PDF)
	psnup -4 -b2mm $(PS) > handouts.ps
	ps2pdf handouts.ps

# eps/%.eps: %.fig
# 	fig2dev -L eps $*.fig > $@

clean:
	rm -f *.aux *.toc *.nav *.log *.snm *.vrb *.out $(DVI) $(TMPPDF)

