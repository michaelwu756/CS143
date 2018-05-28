Our cleartext.py takes in a filename command line argument that points to a json
file. Each line is a json-formatted object, which we read in as a string and
parse into an object. We take the 'body' field and run our sanitize method on it
and print out the result.

Use:

./python cleartext.py <file>
