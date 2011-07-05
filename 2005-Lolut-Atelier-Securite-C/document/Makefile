FILE=document
PDF=$(FILE).pdf
TEX=$(FILE).tex
$(PDF): $(TEX)
	pdflatex $(TEX)
view: $(PDF)
	gpdf $(PDF)
clean:
	rm -f $(PDF) *.log *.aux
