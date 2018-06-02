#for running haskell program gnome-terminal -e 
gnome-terminal -e "ghc -o algo algo.hs"
gnome-terminal -e "./algo"
#running for creating digraphs
gnome-terminal -e "python graph.py"
gnome-terminal -e "dot -Tpng input.dot -o input.png"
gnome-terminal -e "dot -Tpng output.dot -o output.png"
