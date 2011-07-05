FILE=presentation
TEX=$(FILE).tex
DVI=$(FILE).dvi
PDF=$(FILE).pdf
all: $(PDF)
view: $(PDF)
	kpdf $(PDF)
$(PDF): $(DVI)
	dvipdf $(DVI)
$(DVI): $(TEX) php.tex sql.tex config.tex vrac.tex
	# Call LaTeX twice to regenerate the menu
	(latex $(TEX) && latex $(TEX)) || ($(MAKE) clean; exit 1)
clean:
	rm -f $(DVI) $(PDF) *.log *.out *.aux *.toc *.nav *.snm
