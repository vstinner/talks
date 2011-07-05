FILE=presentation
TEX=$(FILE).tex
DVI=$(FILE).dvi
PDF=$(FILE).pdf
all: $(PDF)
view: $(PDF)
	gpdf $(PDF)
$(PDF): $(DVI)
	dvipdf $(DVI)
$(DVI): $(TEX) stockage.tex attaque.tex intro.tex config.tex chiffrement.tex cryptanalyse.tex
	# Call LaTeX twice to regenerate the menu
	latex $(TEX)
	latex $(TEX)
clean:
	rm -f $(DVI) $(PDF) *.log *.out *.aux *.toc *.nav *.snm
