"dot -Tpng input.dot -o input.png"
input_string = ""
output_string = ""
with open("data_in.txt") as f:
	for line in f:
		words = line.split()
		input_string = input_string + words[0] + " -> " + words[1] + "[label=" + "\"" + words[2] + "\"" + "]" + "\n"
		
input_string = "digraph M { \n" + input_string + "}"

f = open('input.dot','w')
f.write(input_string)



with open("data_out.txt") as f:
	for line in f:
		words = line.split()
		output_string = output_string + words[0] + " -> " + words[1] + "[label=" + "\"" + words[2] + "\"" + "]" + "\n"
		
output_string = "digraph N { \n" + output_string + "}"

f = open('output.dot','w')
f.write(output_string)

