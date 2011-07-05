FILE=presentation
TEX=$(FILE).tex
DVI=$(FILE).dvi
PDF=$(FILE).pdf
all: $(PDF)
view: $(PDF)
	kpdf $(PDF)
$(PDF): $(DVI)
	dvipdf $(DVI)
$(DVI): $(TEX) intro.tex definition.tex maillon.tex conclusion.tex config.tex
	# Call LaTeX twice to regenerate the menu
	latex $(TEX)
	latex $(TEX)
clean:
	rm -f $(DVI) $(PDF) *.log *.out *.aux *.toc *.nav *.snm
